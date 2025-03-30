<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Facades;

use Vihersalo\Core\Admin\Settings\SettingsMenu;

// phpcs:disable
/**
 * @method static \Vihersalo\Core\Admin\Settings\SettingsMenu create(string $slug, string $pageTitle, string $menuTitle, string $path, string $capability, string $icon, int $position)
 * @method static \Vihersalo\Core\Admin\Settings\SettingsMenu withSubmenu(?callable $callback = null): self
 * @method static \Vihersalo\Core\Admin\Settings\SettingsMenu withAssets(?callable $callback = null): self
 * @method static \Vihersalo\Core\Admin\Settings\SettingsMenu withLocalize(string $handle, string $objectName, array $l10n): self
 * @see SettingsMenu
 */
class Settings extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'settings';
    }
}
