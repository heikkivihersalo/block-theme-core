<?php

declare(strict_types=1);

namespace Vihersalo\Core\Navigation;

class Menu {
    /**
     * Constructor
     * @param string $slug The slug of the menu
     * @param string $name The name of the menu
     * @return void
     */
    public function __construct(private string $slug, private string $name) {
    }

    /**
     * Create a new menu
     * @param string $slug The slug of the menu
     * @param string $name The name of the menu
     * @return self
     */
    public static function create(string $slug, string $name): self {
        return new self($slug, $name);
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
}
