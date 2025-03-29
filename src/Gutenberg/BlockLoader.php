<?php

declare(strict_types=1);

namespace Vihersalo\Core\Gutenberg;

use Vihersalo\Core\Foundation\Application;
use WP_Block_Type_Registry;

class BlockLoader {
    /**
     * The block groups.
     * @var array
     */
    protected array $groups = [];

    /**
     * The allowed blocks array
     * @var array
     */
    protected array $blockBlacklist = [];

    /**
     * Constructor
     */
    public function __construct(protected Application $app) {
        $this->groups         = $this->app->make('config')->get('gutenberg.groups');
        $this->blockBlacklist = $this->app->make('config')->get('gutenberg.blacklist');
    }

    /**
     * Get the block groups
     * @return array|false
     */
    public function groups(): array|false {
        if (count($this->groups) === 0) {
            return false;
        }

        return $this->groups;
    }

    /**
     * Get the block blacklist
     * @return array
     */
    public function blockBlacklist(): array {
        return $this->blockBlacklist;
    }

    /**
     * Register the blocks
     * @return void
     */
    public function registerBlocks(): void {
        if (! $this->groups()) {
            return;
        }

        foreach ($this->groups() as $group) :
            foreach ($group->blocks() as $block) :
                \register_block_type($this->path . '/' . explode('/', $block)[1]);

                // $this->set_block_translation(
                //     'ksd-' . explode('/', $block)[1],
                //     SITE_PATH
                // );
            endforeach;
        endforeach;
    }

    /**
     * Filters the list of allowed block types.
     * @param array $allowed_block_types The list of allowed block types.
     * @return array The filtered list of allowed block types.
     */
    public function setAllowedBlocks($allowedBlockTypes) {
        // Get all registered blocks if $allowed_block_types is not already set.
        if (! is_array($allowedBlockTypes) || empty($allowedBlockTypes)) {
            $registeredBlocks  = WP_Block_Type_Registry::get_instance()->get_all_registered();
            $allowedBlockTypes = array_keys($registeredBlocks);
        }

        // Create a new array for the allowed blocks.
        $filteredBlocks = [];

        // Loop through each block in the allowed blocks list.
        foreach ($allowedBlockTypes as $block) {
            // Check if the block is not in the disallowed blocks list.
            if (! in_array($block, $this->blockBlacklist(), true)) {
                // If it's not disallowed, add it to the filtered list.
                $filteredBlocks[] = $block;
            }
        }

        // Return the filtered list of allowed blocks
        return $filteredBlocks;
    }

    /**
     * Register custom block categories
     * @param array $editorContext The editor context
     * @return array
     */
    public function setCustomBlockCategories($editorContext) {
        $categories = [];

        if (! empty($editorContext->post)) {
            foreach ($this->categories as $category) {
                array_push(
                    $categories,
                    [
                        'slug'  => $category['slug'],
                        'title' => $category['title'],
                        'icon'  => $category['icon'],
                    ]
                );
            }
        }

        return $categories;
    }
}
