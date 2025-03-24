<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Settings;

use Vihersalo\Core\Support\Assets\Localize;

class SettingsMenu {
    /**
     * The slug of the menu
     * @var string $slug The slug of the menu
     */
    private $slug;

    /**
     * The title of the page
     * @var string $pageTitle The title of the page
     */
    private $pageTitle;

    /**
     * The title of the menu
     * @var string $menuTitle The title of the menu
     */
    private $menuTitle;

    /**
     * The capability required to view the page
     * @var string $capability The capability required to view the page
     */
    private $capability;

    /**
     * The icon of the menu
     * @var string $icon The icon of the menu
     */
    private $icon;

    /**
     * The position of the menu
     * @var int $position The position of the menu
     */
    private $position;

    /**
     * The callback function path
     * @var string $path The callback function path
     */
    private $path;

    /**
     * The sub pages
     * @var array $submenu The sub pages
     */
    private $submenu;

    /**
     * The assets
     * @var array $assets The assets
     */
    private $assets;

    /**
     * The localize
     * @var Localize|bool $localize The localize
     */
    private $localize;

    /**
     * Create a new page collection
     * @param string        $slug The slug of the menu
     * @param string        $pageTitle The title of the page
     * @param string        $menuTitle The title of the menu
     * @param path          $path The callback function path
     * @param string        $capability The capability required to view the page
     * @param string        $icon The icon of the menu
     * @param int           $position The position of the menu
     * @param array         $subPages The sub pages
     * @param array         $assets The assets
     * @param Localize|bool $localize The localize
     * @return void
     */
    public function __construct(
        $slug,
        $pageTitle,
        $menuTitle,
        $path,
        $capability = 'manage_options',
        $icon = 'dashicons-admin-generic',
        $position = 50,
        $subPages = [],
        $assets = [],
        $localize = false
    ) {
        $this->slug       = $slug;
        $this->pageTitle  = $pageTitle;
        $this->menuTitle  = $menuTitle;
        $this->path       = $path;
        $this->capability = $capability;
        $this->icon       = $icon;
        $this->position   = $position;
        $this->submenu    = $subPages;
        $this->assets     = $assets;
        $this->localize   = $localize;
    }

    /**
     * Create a new page collection
     * @param string $slug The slug of the menu
     * @param string $pageTitle The title of the page
     * @param string $menuTitle The title of the menu
     * @param string $path The callback function path
     * @param string $capability The capability required to view the page
     * @param string $icon The icon of the menu
     * @param int    $position The position of the menu
     * @return SettingsMenuBuilder
     */
    public static function configure(
        string $slug,
        string $pageTitle,
        string $menuTitle,
        string $path,
        string $capability = 'manage_options',
        string $icon = 'dashicons-admin-generic',
        int $position = 50,
    ) {
        return (new SettingsMenuBuilder(
            new static($slug, $pageTitle, $menuTitle, $path, $capability, $icon, $position)
        ));
    }

    /**
     * Get settings menu slug
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Get settings menu page title
     * @return string
     */
    public function getPageTitle() {
        return $this->pageTitle;
    }

    /**
     * Get settings menu title
     * @return string
     */
    public function getMenuTitle() {
        return $this->menuTitle;
    }

    /**
     * Get settings menu callback
     * @return callable
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Get settings menu capability
     * @return string
     */
    public function getCapability() {
        return $this->capability;
    }

    /**
     * Get settings menu icon
     * @return string
     */
    public function getIcon() {
        return $this->icon;
    }

    /**
     * Get settings menu position
     * @return int
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * Get submenu pages
     * @return array
     */
    public function getSubmenu() {
        return $this->submenu;
    }

    /**
     * Get assets
     * @return array
     */
    public function getAssets() {
        return $this->assets;
    }

    /**
     * Get localize
     * @return Localize|bool
     */
    public function getLocalize() {
        return $this->localize;
    }

    /**
     * Set submenu pages
     * @param Vihersalo\Core\Support\Collections\MenuCollection $submenu The submenu pages
     * @return void
     */
    public function setSubmenu($submenu) {
        $this->submenu = $submenu;
    }

    /**
     * Set assets
     * @param Vihersalo\Core\Support\Collections\AssetCollection $assets The assets
     * @return void
     */
    public function setAssets($assets) {
        $this->assets = $assets;
    }

    /**
     * Set localize
     * @param Localize|bool $localize The localize
     * @return void
     */
    public function setLocalize($localize) {
        $this->localize = $localize;
    }
}
