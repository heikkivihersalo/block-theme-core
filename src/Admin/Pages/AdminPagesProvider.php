<?php

namespace Vihersalo\BlockThemeCore\Admin\Pages;

use Vihersalo\BlockThemeCore\Application;
use Vihersalo\BlockThemeCore\Application\HooksLoader;
use Vihersalo\BlockThemeCore\Support\Utils\Common as Utils;
use Vihersalo\BlockThemeCore\Support\ServiceProvider;
use Vihersalo\BlockThemeCore\Support\Pages\SettingsMenu;

use Vihersalo\BlockThemeCore\Admin\Pages\PagesManager;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Admin
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class AdminPagesProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 */
	public function register() {
		if ( ! Utils::is_admin() ) {
			return;
		}

		$this->register_admin_pages( $this->app->make( HooksLoader::class ) );
	}

	public function register_admin_pages( HooksLoader $loader ) {
		$pages = $this->app->make( 'config' )->get( 'pages' );
		$path  = $this->app->make( 'config' )->get( 'app.path' );
		$uri   = $this->app->make( 'config' )->get( 'app.uri' );

		foreach ( $pages as $page ) :
			$manager = new PagesManager( $page, $path, $uri );
			$loader->add_action( 'admin_menu', $manager, 'add_menu' );
			$loader->add_action( 'admin_enqueue_scripts', $manager, 'enqueue_assets' );
		endforeach;
	}
}
