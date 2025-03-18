<?php

namespace HeikkiVihersalo\BlockThemeCore;

use Illuminate\Container\Container;

/**
 * The core application class.
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore
 * @author     Heikki Vihersalo
 */
class Application extends Container {
	/**
	 * The instance of the container
	 * @var Container
	 */
	protected static $container;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->register_base_bindings();
	}

	protected function register_base_bindings() {
		static::setInstance( $this );

		$this->instance( 'app', $this );
		$this->instance( Container::class, $this );

		$this->singleton(
			Loader::class,
			fn () => new Loader()
		);
	}

	/**
	 * Get the container
	 *
	 * @return Container
	 */
	public static function container() {
		return static::$container;
	}

	/**
	 * Get the loader
	 *
	 * @return Loader
	 */
	public static function loader(): Loader {
		return static::$container->resolve( Loader::class );
	}

	/**
	 * Run the application
	 */
	public static function create() {
		static::loader()->run();
	}
}
