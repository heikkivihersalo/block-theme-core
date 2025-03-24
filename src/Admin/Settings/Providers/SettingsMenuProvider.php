<?php

namespace Vihersalo\Core\Admin\Settings\Providers;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\Utils\Common as Utils;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Pages\SettingsMenu;

use Vihersalo\Core\Admin\Settings\SettingsMenuManager;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Admin
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class SettingsMenuProvider extends ServiceProvider {
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
			$manager = new SettingsMenuManager( $page, $path, $uri );
			$loader->add_action( 'admin_menu', $manager, 'add_menu' );
			$loader->add_action( 'admin_enqueue_scripts', $manager, 'enqueue_assets' );
		endforeach;
	}
}
