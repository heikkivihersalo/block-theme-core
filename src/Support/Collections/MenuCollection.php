<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Collections;

use Vihersalo\Core\Support\Pages\Submenu;

class MenuCollection {
    /**
     * The menus
     * @var array $menus The menus
     */
    private $menus = [];

    /**
     * Constructor
     * @return void
     */
    public function __construct() {
    }

    /**
     * Add a menu or array of menus
     * @param Submenu|array $submenu The submenu or array of submenus
     * @return self
     */
    public function add($submenu) {
        if (is_array($submenu)) {
            foreach ($submenu as $menu) {
                if ($menu instanceof Submenu) {
                    $this->menus[] = $menu;
                }
            }

            return $this;
        }

        if ($submenu instanceof Submenu) {
            $this->menus[] = $submenu;
        }

        return $this;
    }

    /**
     * Get the menus
     * @return array The menus
     */
    public function get(): array {
        return $this->menus;
    }
}
