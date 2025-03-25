<?php

declare(strict_types=1);

namespace Vihersalo\Core\Media;

class ImageSizeManager {
    /**
     * Default image sizes
     * @var array
     */
    private array $defaultImageSizes;

    /**
     * Custom image sizes
     * @var array
     */
    private array $customImageSizes;

    /**
     * Constructor
     * @param array $defaultImageSizes Default image sizes
     * @param array $customImageSizes Custom image sizes
     * @return void
     */
    public function __construct(array $defaultImageSizes, array $customImageSizes) {
        $this->defaultImageSizes = $defaultImageSizes;
        $this->customImageSizes  = $customImageSizes;
    }

    /**
     * Add custom image options for WordPress
     *
     * @param mixed $sizes Image sizes
     * @return void
     */
    public function registerImageSizes(): void {
        /* Update default core image sizes */
        foreach ($this->defaultImageSizes as $size) :
            update_option($size->getWidthOptionName(), $size->getWidth());
            update_option($size->getHeightOptionName(), $size->getHeight());
        endforeach;

        /* Add new image sizes to core */
        foreach ($this->customImageSizes as $size) :
            add_image_size($size->getSlug(), $size->getWidth(), $size->getHeight(), false);
        endforeach;
    }

    /**
     * Remove default image sizes from WordPress
     * @param mixed $sizes Image sizes
     * @return mixed
     */
    public function removeDefaultImageSizes(mixed $sizes): mixed {
        unset($sizes['1536x1536'], $sizes['2048x2048']); // remove 1536x1536 image size
        // remove 2048x2048 image size

        return $sizes;
    }

    /**
     * Add custom image options to admin interface
     * @param mixed $sizes Image sizes
     * @return array
     */
    public function addCustomImageSizesToAdmin(mixed $sizes): array {
        $customImages = [];

        foreach ($this->customImageSizes as $image) :
            $customImages[ $image->getSlug() ] = $image->getName();
        endforeach;

        return array_merge($sizes, $customImages);
    }
}
