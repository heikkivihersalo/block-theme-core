<?php

namespace Vihersalo\Core\Navigation;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Navigation
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class NavigationProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function register() {
		$this->app->make( HooksLoader::class )->add_action( 'init', $this, 'register_navigation_menus' );
	}

	/**
	 * Load navigation menus
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function register_navigation_menus(): void {
		$locations = $this->app->make( 'config' )->get( 'app.navigation' );

		foreach ( $locations as $menu ) :
			register_nav_menu( $menu->get_slug(), $menu->get_name() );
		endforeach;
	}

	/**
	 * Boot the navigation provider
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
	}
}
