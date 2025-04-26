<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes\Traits;

use Vihersalo\Core\PostTypes\Utils;
use WP_Block_Bindings_Registry;

trait BlockBindings {
    /**
     * Register block bindings for the custom fields
     *
     * @return void
     */
    public function registerBlockBindings(): void {
        parent::fields(); // Initialize the fields
        $fields = parent::getFields()->all();

        foreach ($fields as $field) {
            $metaKey   = $field['id']      ?? null;
            $type      = $field['type']    ?? null;
            $label     = $field['label']   ?? null;
            $options   = $field['options'] ?? null;
            $namespace = 'app/' . str_replace('_', '-', $metaKey);

            if (WP_Block_Bindings_Registry::get_instance()->is_registered($namespace)) {
                continue;
            }

            if (empty($metaKey) || empty($type)) {
                continue;
            }

            if (empty($label)) {
                $label = \ucwords(\str_replace(['-', '_'], ' ', $metaKey));
            }

            switch ($type) {
                case 'text':
                case 'textarea':
                case 'email':
                case 'url':
                case 'select':
                case 'radio':
                    \register_block_bindings_source(
                        $namespace,
                        [
                            'label'              => $label,
                            'get_value_callback' => function (array $source_args, $block_instance) use ($metaKey) {
                                if (empty($block_instance->context['postId'])) {
                                    return null;
                                }

                                return Utils::formatPostMetaText($block_instance->context['postId'], $metaKey);
                            },
                            'uses_context' => ['postId']
                        ]
                    );
                    break;

                default:
                    break;
            }
        }
    }
}
