<?php
/**
 * Class for duplicate post feature
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    Vihersalo\BlockThemeCore\Theme\Admin\Pages
 */

namespace Vihersalo\BlockThemeCore\Admin\Duplicate;

defined( 'ABSPATH' ) || die();

/**
 * Class for duplicate post feature
 * TODO: This is copy paste from old theme and based on https://rudrastyh.com/wordpress/duplicate-post.html. Needs to be refactored.
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Theme\Admin\Pages
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
final class Helpers {
	/**
	 * This utility class should never be instantiated.
	 */
	private function __construct() {
	}

	/**
	 * Add duplicate post feature to admin
	 * @param array    $actions The post actions
	 * @param \WP_Post $post The post object
	 * @return array The post actions
	 */
	public static function add_duplicate_post_link_to_admin( array $actions, \WP_Post $post ): array {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return $actions;
		}

		$url = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'create_duplicate_post_as_draft',
					'post'   => $post->ID,
				),
				'admin.php'
			),
			basename( __FILE__ ),
			'duplicate_nonce'
		);

		$actions['duplicate'] = '<a href="' . $url . '" title="Duplicate this item" rel="permalink">Duplicate</a>';

		return $actions;
	}

	/**
	 * Function creates post duplicate as a draft and redirects then to the edit post screen
	 * @return void
	 */
	public static function create_duplicate_post_as_draft(): void {
		// check if post ID has been provided and action
		if ( empty( $_GET['post'] ) ) {
			wp_die( 'No post to duplicate has been provided!' );
		}

		// Nonce verification
		if ( ! isset( $_GET['duplicate_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['duplicate_nonce'] ) ), basename( __FILE__ ) ) ) {
			return;
		}

		// Get the original post id
		$post_id = absint( $_GET['post'] );

		// And all the original post data then
		$post = get_post( $post_id );

		/*
		* if you don't want current user to be the new post author,
		* then change next couple of lines to this: $new_post_author = $post->post_author;
		*/
		$current_user    = wp_get_current_user();
		$new_post_author = $current_user->ID;

		// if post data does not exists (I am sure it is, but just in a case)
		if ( ! $post ) {
			wp_die( 'Post creation failed, could not find original post: ' . $post_id );
		}

		/**
		 * Add new duplicate
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order,
		);

		// insert the post by wp_insert_post() function
		$new_post_id = wp_insert_post( $args );

		/*
		* get all current post terms ad set them to the new post draft
		*/
		$taxonomies = get_object_taxonomies( get_post_type( $post ) ); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		if ( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {
				$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
				wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
			}
		}

		// duplicate all post meta
		$post_meta = get_post_meta( $post_id );
		if ( $post_meta ) {
			foreach ( $post_meta as $meta_key => $meta_values ) {
				if ( '_wp_old_slug' === $meta_key ) { // do nothing for this meta key
					continue;
				}

				foreach ( $meta_values as $meta_value ) {
					add_post_meta( $new_post_id, $meta_key, $meta_value );
				}
			}
		}

		// or we can redirect to all posts with a message
		wp_safe_redirect(
			add_query_arg(
				array(
					'post_type' => ( 'post' !== get_post_type( $post ) ? get_post_type( $post ) : false ),
					'saved'     => 'post_duplication_created', // just a custom slug here
				),
				admin_url( 'edit.php' )
			)
		);

		exit;
	}

	/**
	 * Admin notice
	 * @return void
	 */
	public static function show_duplicate_admin_notice(): void {
		// Get the current screen
		$screen = get_current_screen();

		if ( 'edit' !== $screen->base ) {
			return;
		}

		// Checks if settings updated
		// phpcs:ignore
		if ( isset( $_GET['saved'] ) && 'post_duplication_created' == $_GET['saved'] ) {
			echo '<div class="notice notice-success is-dismissible"><p>Post copy created.</p></div>';
		}
	}
}
