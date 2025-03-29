<?php

declare(strict_types=1);

namespace Vihersalo\Core\Media;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Media as MediaUtils;

class MediaServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        $store = $this->app->make(HooksStore::class);

        $this->registerImageSizes($store);
        $this->allowSvgFileUploads($store);
        $this->setCustomExcerptLength($store);
    }

    /**
     * Register image sizes
     * @param HooksStore $store The hooks loader
     * @return void
     */
    public function registerImageSizes(HooksStore $store) {
        $media_config       = $this->app->make('config')->get('app.media');
        $image_size_manager = new ImageSizeManager(
            $media_config['sizes']['default'],
            $media_config['sizes']['custom']
        );

        $store->addAction('after_setup_theme', $image_size_manager, 'registerImageSizes');
        $store->addFilter('intermediate_image_sizes', $image_size_manager, 'removeDefaultImageSizes');
        $store->addFilter('image_size_names_choose', $image_size_manager, 'addCustomImageSizesToAdmin');
    }

    /**
     * Set file uploads
     * @param HooksStore $store The hooks loader
     * @return void
     */
    public function allowSvgFileUploads(HooksStore $store) {
        $store->addFilter('upload_mimes', MediaUtils::class, 'allowSvgUploads');
    }

    /**
     * Set custom excerpt length
     * @param HooksStore $store The hooks loader
     * @return void
     */
    public function setCustomExcerptLength(HooksStore $store) {
        $media_config = $this->app->make('config')->get('app.media');

        $excerpt_manager = new ExcerptManager(
            $media_config['excerpt']['length'],
            $media_config['excerpt']['more']
        );

        $store->addFilter('excerpt_length', $this, 'customExcerptLength', 999);
        $store->addFilter('excerpt_more', $this, 'customExcerptMore');
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
