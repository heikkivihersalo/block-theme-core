<?php

declare(strict_types=1);

namespace Vihersalo\Core\Media;

use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Media as MediaUtils;

class MediaProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $loader = $this->app->make(HooksLoader::class);

        $this->registerImageSizes($loader);
        $this->allowSvgFileUploads($loader);
        $this->setCustomExcerptLength($loader);
    }

    /**
     * Register image sizes
     * @param HooksLoader $loader The hooks loader
     * @return void
     */
    public function registerImageSizes(HooksLoader $loader) {
        $media_config       = $this->app->make('config')->get('app.media');
        $image_size_manager = new ImageSizeManager(
            $media_config['sizes']['default'],
            $media_config['sizes']['custom']
        );

        $loader->addAction('after_setup_theme', $image_size_manager, 'registerImageSizes');
        $loader->addFilter('intermediate_image_sizes', $image_size_manager, 'removeDefaultImageSizes');
        $loader->addFilter('image_size_names_choose', $image_size_manager, 'addCustomImageSizesToAdmin');
    }

    /**
     * Set file uploads
     * @param HooksLoader $loader The hooks loader
     * @return void
     */
    public function allowSvgFileUploads(HooksLoader $loader) {
        $loader->addFilter('upload_mimes', MediaUtils::class, 'allowSvgUploads');
    }

    /**
     * Set custom excerpt length
     * @param HooksLoader $loader The hooks loader
     * @return void
     */
    public function setCustomExcerptLength(HooksLoader $loader) {
        $media_config = $this->app->make('config')->get('app.media');

        $excerpt_manager = new ExcerptManager(
            $media_config['excerpt']['length'],
            $media_config['excerpt']['more']
        );

        $loader->addFilter('excerpt_length', $this, 'customExcerptLength', 999);
        $loader->addFilter('excerpt_more', $this, 'customExcerptMore');
    }

    /**
     * Boot the navigation provider
     * @return void
     */
    public function boot() {
    }
}
