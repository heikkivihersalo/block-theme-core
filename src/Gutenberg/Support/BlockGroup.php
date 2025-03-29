<?php

declare(strict_types=1);

namespace Vihersalo\Core\Gutenberg;

use Vihersalo\Core\Gutenberg\Utils\Directories as DirectoriesUtils;

class BlockGroup {
    /**
     * Blocks in the block group
     * @var array
     */
    protected array $blocks = [];

    /**
     * Constructor
     * @param string $source_path The source path of the block group
     * @param string $build_path The build path of the block group (defaults to same as source path)
     * @return void
     */
    public function __construct(protected string $source_path, protected string $build_path) {
        $this->source_path = $source_path;
        $this->build_path  = $build_path;

        $this->blocks = $this->resolveBlocksFromDirectory();
    }

    /**
     * Create a new menu
     * @param string $slug The slug of the menu
     * @param string $name The name of the menu
     * @return self
     */
    public static function create(string $source_path, string $build_path): self {
        return new self($source_path, $build_path);
    }

    /**
     * Get the source path of the block group
     * @return string
     */
    public function getSourcePath(): string {
        return $this->source_path;
    }

    /**
     * Get the build path of the block group
     * @return string
     */
    public function getBuildPath(): string {
        return $this->build_path;
    }

    /**
     * Resolve blocks from directory
     * @return array
     */
    public function resolveBlocksFromDirectory(): array {
        return DirectoriesUtils::getBlockDirectories($this->source_path, 'ksd');
    }

    /**
     * Get the blocks in the block group
     * @return array
     */
    public function blocks(): array {
        return $this->blocks;
    }

    /**
     * Register the block group
     * @return void
     */
    public function register(): void {
        if (! function_exists('register_block_type')) {
            return;
        }

        if (! $this->blocks()) {
            return;
        }

        foreach ($this->blocks() as $block) :
            register_block_type($this->path . '/' . explode('/', $block)[1]);

            // $this->set_block_translation(
            //     'ksd-' . explode('/', $block)[1],
            //     SITE_PATH
            // );
        endforeach;
    }
}
