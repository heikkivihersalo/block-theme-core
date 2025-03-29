<?php

declare(strict_types=1);

namespace Vihersalo\Core\Gutenberg\Support;

class BlockCategory {
    /**
     * Constructor
     * @param string $slug
     * @param string $title
     * @param string|null $icon
     */
    public function __construct(protected string $slug, protected string $title, protected ?string $icon = null) {
        $this->slug  = $slug;
        $this->title = $title;
        $this->icon  = $icon;
    }

    /**
     * Create a new menu
     * @param string $slug The slug of the menu
     * @param string $name The name of the menu
     * @return self
     */
    public static function create(string $slug, string $title, ?string $icon = null): self {
        return new self($slug, $title, $icon);
    }

    /**
     * Get the block category slug
     * @return string
     */
    public function getSlug(): string {
        return $this->slug;
    }

    /**
     * Get the block category title
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * Get the block category icon
     * @return string
     */
    public function getIcon(): string {
        return $this->icon;
    }
}
