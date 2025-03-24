<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Settings;

class Submenu {
    /**
     * Constructor
     * @param string $slug The slug of the menu
     * @param string $pageTitle The title of the page
     * @param string $menuTitle The title of the menu
     * @param string $capability The capability required to view the page
     * @return void
     */
    public function __construct(
        private string $slug,
        private string $pageTitle,
        private string $menuTitle,
        private string $capability = 'manage_options',
    ) {
    }

    /**
     * Create a new submenu
     * @param string $slug The slug of the page
     * @param string $pageTitle The title of the page
     * @param string $menuTitle The title of the menu
     * @param string $capability The capability required to view the page
     * @return self
     */
    public static function create(string $slug, string $pageTitle, string $menuTitle, string $capability): self {
        return new self($slug, $pageTitle, $menuTitle, $capability);
    }

    /**
     * Get the slug
     * @return string The slug
     */
    public function getSlug(): string {
        return $this->slug;
    }

    /**
     * Get the page title
     * @return string The page title
     */
    public function getPageTitle(): string {
        return $this->pageTitle;
    }

    /**
     * Get the menu title
     * @return string The menu title
     */
    public function getMenuTitle(): string {
        return $this->menuTitle;
    }

    /**
     * Get the capability
     * @return string The capability
     */
    public function getCapability(): string {
        return $this->capability;
    }
}
