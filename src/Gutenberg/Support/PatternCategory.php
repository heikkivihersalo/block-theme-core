<?php

declare(strict_types=1);

namespace Vihersalo\Core\Gutenberg;

class PatternCategory {
    /**
     * Constructor
     * @param string $slug
     * @param string $label
     */
    public function __construct(protected string $slug, protected string $label) {
        $this->slug  = $slug;
        $this->label = $label;
    }

    /**
     * Create a new pattern category
     * @param string $slug The slug of the pattern category
     * @param string $label The label of the pattern category
     * @return self
     */
    public static function create(string $slug, string $label): self {
        return new self($slug, $label);
    }

    /**
     * Get the pattern category slug
     * @return string
     */
    public function getSlug(): string {
        return $this->slug;
    }

    /**
     * Get the pattern category label
     * @return string
     */
    public function getLabel(): string {
        return $this->label;
    }

    /**
     * Register the pattern category
     * @return void
     */
    public function register(): void {
        register_block_pattern_category(
            $this->getSlug(),
            ['label' => $this->getLabel()]
        );
    }
}
