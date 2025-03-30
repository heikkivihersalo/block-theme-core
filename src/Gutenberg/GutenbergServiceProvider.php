<?php

declare(strict_types=1);

namespace Vihersalo\Core\Gutenberg;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Common as CommonUtils;

class GutenbergServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $store  = $this->app->make(HooksStore::class);
        $loader = new BlockLoader($this->app);

        $this->registerBlocks($store, $loader);
        $this->registerAllowedBlocks($store, $loader);
        $this->registerCustomBlockCategories($store, $loader);
        $this->setSeparateCoreBlockAssets($store);
    }

    /**
     * Register blocks
     * @param HooksStore $store The WordPress hooks loader
     * @return void
     */
    protected function registerBlocks(HooksStore $store, BlockLoader $loader): void {
        $store->addAction('init', $loader, 'registerBlocks');
    }

    /**
     * Register allowed blocks
     * @param HooksStore $store The WordPress hooks loader
     * @return void
     */
    protected function registerAllowedBlocks(HooksStore $store, BlockLoader $loader): void {
        if (! CommonUtils::isAdmin()) {
            return;
        }

        $store->addAction('allowed_block_types_all', $loader, 'setAllowedBlocks', 10, 2);
    }

    /**
     * Register custom block categories
     * @param HooksStore $store The WordPress hooks loader
     * @return void
     */
    protected function registerCustomBlockCategories(HooksStore $store, BlockLoader $loader): void {
        if (! CommonUtils::isAdmin()) {
            return;
        }

        $store->addAction('init', $loader, 'setCustomBlockCategories');
    }

    /**
     * Sets editor to load separate core block assets
     * @param HooksStore $store The WordPress hooks loader
     * @return void
     */
    protected function setSeparateCoreBlockAssets(HooksStore $store): void {
        $store->addAction('should_load_separate_core_block_assets', CommonUtils::class, 'returnTrue');
    }

    // /**
    //  * Fix file paths to get blocks working in theme context
    //  *
    //  * @since    2.0.0
    //  * @access   private
    //  * @return   void
    //  */
    // protected function fix_file_paths(HooksStore $store): void {
    //     $store->addFilter('plugins_url', $this, 'fix_block_file_path', 10, 3);
    // }

    /**
     * Boot the navigation provider
     * @return void
     */
    public function boot() {
    }
}
