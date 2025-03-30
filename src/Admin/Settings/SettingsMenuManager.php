<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Settings;

use Vihersalo\Core\Support\Utils\Common as CommonUtils;

class SettingsMenuManager {
    /**
     * Admin pages
     * @var SettingsMenu $page The settings menu
     */
    private $page;

    /**
     * Base path
     * @var string
     */
    private $path;

    /**
     * Base URI
     * @var string
     */
    private $uri;

    /**
     * Constructor
     * @return void
     */
    public function __construct($page, $path, $uri) {
        $this->page = $page;
        $this->path = $path;
        $this->uri  = $uri;
    }

    /**
     * Get the page ID from the menu title
     * - Page title is generated from the menu title by replacing spaces with dashes
     *   and converting the string to lowercase
     * @param string $menuTitle The menu title
     * @return string The page ID
     */
    public function getPageId($menuTitle) {
        return str_replace(' ', '-', strtolower($menuTitle));
    }

    /**
     * Get the prefix for the top level page
     *
     * @return string The prefix for the top level page
     */
    public function getToplevelPagePrefix() {
        return 'toplevel_page_';
    }

    /**
     * Check if the current page is a custom admin page
     *
     * @param string $hook The current admin page
     * @return bool
     */
    public function isCustomAdminPage($hook): bool {
        $is_top_level = str_contains($hook, $this->getToplevelPagePrefix() . $this->page->getSlug());
        $is_sub_page  = false;

        $submenu = $this->page->getSubmenu();

        if ($submenu) {
            foreach ($submenu as $subpage) {
                $is_sub_page = str_contains($hook, $subpage->getSlug()) ? true : $is_sub_page;
            }
        }

        return $is_top_level || $is_sub_page;
    }

    /**
     * Callback function for the admin page
     *
     * @since    1.0.0
     * @access   public
     */
    public function callback() {
        $path = $this->path . '/' . $this->page->getPath();

        if (! current_user_can($this->page->getCapability())) {
            wp_die('You do not have sufficient permissions to access this page');
        }

        if (! CommonUtils::assetExists($path)) {
            return;
        }

        ob_start();
        require $path;
        echo ob_get_clean();
    }

    /**
     * Add the menu
     *
     * @since    1.0.0
     * @access   public
     */
    public function addMenu() {
        // This is WP core function to add a menu page
        add_menu_page(
            $this->page->getPageTitle(),
            $this->page->getMenuTitle(),
            $this->page->getCapability(),
            $this->page->getSlug(),
            [$this, 'callback'],
            $this->page->getIcon(),
            $this->page->getPosition()
        );

        $submenu = $this->page->getSubmenu();

        if (! $submenu) {
            return;
        }

        foreach ($submenu as $subpage) {
            // This is WP core function to add a submenu page
            add_submenu_page(
                $this->page->getSlug(),
                $subpage->getPageTitle(),
                $subpage->getMenuTitle(),
                $subpage->getCapability(),
                $subpage->getSlug(),
                [$this, 'callback']
            );
        }
    }

    /**
     * Enqueue theme option related assets
     * @param string $hook The current admin page
     * @return void
     */
    public function enqueueAssets($hook) {
        if (! $this->isCustomAdminPage($hook)) {
            return;
        }
        $assets = $this->page->getAssets();

        foreach ($assets as $asset) :
            if (method_exists($asset, 'register')) {
                call_user_func([$asset, 'register']);
            }
        endforeach;

        /**
         * Localize the script with the data needed for the REST API
         */
        $localize = $this->page->getLocalize();

        if (! $localize) {
            return;
        }

        if (method_exists($localize, 'register')) {
            call_user_func([$localize, 'register']);
        }
    }
}
