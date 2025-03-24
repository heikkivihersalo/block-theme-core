<?php

namespace Vihersalo\Core\Media;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Media\ImageSizeManager;
use Vihersalo\Core\Media\ExcerptManager;
use Vihersalo\Core\Support\Utils\Media as MediaUtils;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Enqueue
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class MediaProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return void
	 */
	public function register() {
		$loader = $this->app->make( HooksLoader::class );

		$this->register_image_sizes( $loader );
		$this->allow_svg_file_uploads( $loader );
		$this->set_custom_excerpt_length( $loader );
	}

	/**
	 * Register image sizes
	 *
	 * @param HooksLoader $loader The hooks loader
	 * @return void
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function register_image_sizes( HooksLoader $loader ) {
		$media_config       = $this->app->make( 'config' )->get( 'app.media' );
		$image_size_manager = new ImageSizeManager(
			$media_config['sizes']['default'],
			$media_config['sizes']['custom']
		);

		$loader->add_action( 'after_setup_theme', $image_size_manager, 'register_image_sizes' );
		$loader->add_filter( 'intermediate_image_sizes', $image_size_manager, 'remove_default_image_sizes' );
		$loader->add_filter( 'image_size_names_choose', $image_size_manager, 'add_custom_image_sizes_to_admin' );
	}

	/**
	 * Set file uploads
	 *
	 * @param HooksLoader $loader The hooks loader
	 * @return void
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function allow_svg_file_uploads( HooksLoader $loader ) {
		$loader->add_filter( 'upload_mimes', MediaUtils::class, 'allow_svg_uploads' );
	}

	/**
	 * Set custom excerpt length
	 *
	 * @param HooksLoader $loader The hooks loader
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function set_custom_excerpt_length( HooksLoader $loader ) {
		$media_config = $this->app->make( 'config' )->get( 'app.media' );

		$excerpt_manager = new ExcerptManager(
			$media_config['excerpt']['length'],
			$media_config['excerpt']['more']
		);

		$loader->add_filter( 'excerpt_length', $this, 'custom_excerpt_length', 999 );
		$loader->add_filter( 'excerpt_more', $this, 'custom_excerpt_more' );
	}

	/**
	 * Boot the navigation provider
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return void
	 */
	public function boot() {
	}
}
