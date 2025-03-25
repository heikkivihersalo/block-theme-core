<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Duplicate;

use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

class DuplicateServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     */
    public function register() {
        $this->enableDuplicatePosts($this->app->make(HooksLoader::class));
    }

    /**
     * Enable customizer
     * @param    HooksLoader    $loader    The hooks loader
     * @return   void
     */
    private function enableDuplicatePosts(HooksLoader $loader) {
        // Admin actions are create with the following format: admin_action_{action_name}
        $loader->addAction('admin_action_create_duplicate_post_as_draft', Utils::class, 'createDuplicatePostAsDraft');
        $loader->addFilter('post_row_actions', Utils::class, 'addDuplicatePostLinkToAdmin', 10, 2);
        $loader->addFilter('page_row_actions', Utils::class, 'addDuplicatePostLinkToAdmin', 10, 2);
        $loader->addAction('admin_notices', Utils::class, 'showDuplicateAdminNotice');
    }

    /**
     * Boot the navigation provider
     * @return void
     */
    public function boot() {
    }
}
