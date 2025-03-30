<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Settings;

use Vihersalo\Core\Collections\Collection;

/**
 * @template T of \Vihersalo\Core\Admin\Settings\SettingsMenu
 * @template-implements \Vihersalo\Core\Contracts\Collections\Collection<T>
 */
class SettingsMenuCollection extends Collection {
    /**
     * Constructor
     * @return void
     */
    public function __construct() {
    }
}
