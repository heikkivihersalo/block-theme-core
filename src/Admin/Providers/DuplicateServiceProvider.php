<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Providers;

use Vihersalo\Core\Admin\Duplicate\Utils;
use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Common as CommonUtils;

class DuplicateServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        if (! CommonUtils::isAdmin()) {
            return;
        }

        $store = $this->app->make(HooksStore::class);
        $this->registerPostDuplicate($store);
    }

    /**
     * Enable customizer
     * @param    HooksStore    $store    The hooks loader
     * @return   void
     */
    private function registerPostDuplicate(HooksStore $store) {
        // Admin actions are create with the following format: admin_action_{action_name}
        $store->addAction('admin_action_create_duplicate_post_as_draft', Utils::class, 'createDuplicatePostAsDraft');
        $store->addFilter('post_row_actions', Utils::class, 'addDuplicatePostLinkToAdmin', 10, 2);
        $store->addFilter('page_row_actions', Utils::class, 'addDuplicatePostLinkToAdmin', 10, 2);
        $store->addAction('admin_notices', Utils::class, 'showDuplicateAdminNotice');
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
