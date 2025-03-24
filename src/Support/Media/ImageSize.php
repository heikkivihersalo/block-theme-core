<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Media;

class ImageSize {
    /**
     * Constructor
     *
     * @param string $slug The slug of the menu
     * @param string $name The name of the menu
     * @return void
     */
    public function __construct(private string $slug, private string $name, private int $width, private int $height) {
    }

    /**
     * Create a new image size
     *
     * @param string $slug The slug of the menu
     * @param string $name The name of the menu
     * @param int    $width The width of the image
     * @param int    $height The height of the image
     * @return self
     */
    public static function create(string $slug, string $name, int $width, int $height): self {
        return new self($slug, $name, $width, $height);
    }
    /**
     * Get the slug of the menu
     * @return string
     */
    public function getSlug(): string {
        return $this->slug;
    }

    /**
     * Get the name of the menu
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Get the width of the image
     * @return int
     */
    public function getWidth(): int {
        return $this->width;
    }

    /**
     * Get the height of the image
     * @return int
     */
    public function getHeight(): int {
        return $this->height;
    }

    /**
     * Get the database option name for the image size width
     * @return string
     */
    public function getWidthOptionName(): string {
        return $this->slug . '_size_w';
    }

    /**
     * Get the database option name for the image size height
     * @return string
     */
    public function getHeightOptionName(): string {
        return $this->slug . '_size_h';
    }
}
