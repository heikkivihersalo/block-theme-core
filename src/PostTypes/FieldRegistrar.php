<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

use Vihersalo\Core\PostTypes\Fields\CheckboxField;
use Vihersalo\Core\PostTypes\Fields\CheckboxGroupField;
use Vihersalo\Core\PostTypes\Fields\DateField;
use Vihersalo\Core\PostTypes\Fields\ImageField;
use Vihersalo\Core\PostTypes\Fields\NumberField;
use Vihersalo\Core\PostTypes\Fields\RadioGroupField;
use Vihersalo\Core\PostTypes\Fields\RichTextField;
use Vihersalo\Core\PostTypes\Fields\SelectField;
use Vihersalo\Core\PostTypes\Fields\TaxonomyCheckboxGroupField;
use Vihersalo\Core\PostTypes\Fields\TaxonomyRadioField;
use Vihersalo\Core\PostTypes\Fields\TaxonomySelectField;
use Vihersalo\Core\PostTypes\Fields\TextareaField;
use Vihersalo\Core\PostTypes\Fields\TextField;
use Vihersalo\Core\PostTypes\Fields\UrlField;
use WP_Post;

/**
 * Class responsible for adding custom fields to post types
 *
 * @since      0.1.0
 * @package    HeikkiVihersalo\CustomPostTypes
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class FieldRegistrar {
    /**
     * Nonce
     *
     * @var string
     */
    protected $nonce = 'app';

    /**
     * Metabox fields
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Metabox title
     *
     * @var string
     */
    protected $title;

    /**
     * Metabox label
     *
     * @var string
     */
    protected $label;

    /**
     * Post types
     *
     * @var array
     */
    protected $postTypes = ['post', 'page'];

    /**
     * Position
     *
     * @var string [ normal | advanced | side ]
     */
    protected $position = 'normal';

    /**
     * Priority
     *
     * @var string
     */
    protected $priority = 'high';

    /**
     * Constructor
     *
     * @param FieldCollection  $fields Fields to display in metabox
     * @param string $title Title of metabox
     * @param array  $postTypes Post types to display metabox on (default: post, page)
     * @param string $position Position of metabox (default: normal)
     * @param string $priority Priority of metabox (default: high)
     * @return void
     */
    public function __construct(
        FieldCollection $fields,
        string $title,
        array $postTypes = ['post', 'page'],
        string $position = 'normal',
        string $priority = 'high'
    ) {
        $this->fields    = $fields->registered();
        $this->title     = $title;
        $this->postTypes = $postTypes;
        $this->position  = $position;
        $this->priority  = $priority;
    }

    /**
     * Add metabox
     *
     * @return void
     */
    public function addMetabox(): void {
        add_meta_box(
            preg_replace('/\s+/', '-', strtolower($this->title)),
            $this->title,
            [$this, 'renderHTML'],
            $this->postTypes,
            $this->position,
            $this->priority
        );
    }

    /**
     * Render metabox
     *
     * @param WP_Post $post Post object
     * @return void
     */
    public function renderHTML(WP_Post $post): void {
        wp_nonce_field(basename(__FILE__), $this->nonce);

        echo '<table class="form-table">';
        echo '<tbody>';

        foreach ($this->fields as $field) :
            switch ($field['type']) {
                case 'checkbox':
                    $checkboxField = new CheckboxField($field['id'], $field['label'], $post);
                    echo $checkboxField->getHTML();
                    break;

                case 'checkbox-group':
                    $checkboxGroupField = new CheckboxGroupField(
                        $field['id'],
                        $field['label'],
                        $post,
                        $field['options']
                    );
                    echo $checkboxGroupField->getHTML();
                    break;

                case 'date':
                    $dateField = new DateField($field['id'], $field['label'], $post);
                    echo $dateField->getHTML();
                    break;

                case 'image':
                    $imageField = new ImageField($field['id'], $field['label'], $post);
                    echo $imageField->getHTML();
                    break;

                case 'number':
                    $numberField = new NumberField($field['id'], $field['label'], $post);
                    echo $numberField->getHTML();
                    break;

                case 'radio-group':
                    $radioGroupField = new RadioGroupField($field['id'], $field['label'], $post, $field['options']);
                    echo $radioGroupField->getHTML();
                    break;

                case 'rich-text':
                    $richTextField = new RichTextField($field['id'], $field['label'], $post);
                    echo $richTextField->getHTML();
                    break;

                case 'select':
                    $selectField = new SelectField($field['id'], $field['label'], $post, $field['options']);
                    echo $selectField->getHTML();
                    break;

                case 'taxonomy-checkbox-group':
                    $taxonomyCheckboxGroupField = new TaxonomyCheckboxGroupField(
                        $field['id'],
                        $field['label'],
                        $post,
                        [],
                        $field['taxonomy']
                    );
                    echo $taxonomyCheckboxGroupField->getHTML();
                    break;

                case 'taxonomy-radio':
                    $taxonomyRadioField = new TaxonomyRadioField(
                        $field['id'],
                        $field['label'],
                        $post,
                        [],
                        $field['taxonomy']
                    );
                    echo $taxonomyRadioField->getHTML();
                    break;

                case 'taxonomy-select':
                    $taxonomySelectField = new TaxonomySelectField(
                        $field['id'],
                        $field['label'],
                        $post,
                        [],
                        $field['taxonomy']
                    );
                    echo $taxonomySelectField->getHTML();
                    break;

                case 'text':
                    $textTield = new TextField($field['id'], $field['label'], $post);
                    echo $textTield->getHTML();
                    break;

                case 'textarea':
                    $textareaField = new TextareaField($field['id'], $field['label'], $post);
                    echo $textareaField->getHTML();
                    break;

                case 'url':
                    $urlField = new UrlField($field['id'], $field['label'], $post);
                    echo $urlField->getHTML();
                    break;

                default:
                    // code...
                    break;
            }
        endforeach;

        echo '</tbody>';
        echo '</table>';
    }

    /**
     * Save metabox
     *
     * @param int $postId Post ID
     * @return int Post ID
     */
    public function saveMetabox(int $postId): int {
        /**
         * Validate save function
         */
        $sanitizedNonce = isset($_POST[ $this->nonce ]) ? sanitize_text_field(wp_unslash($_POST[ $this->nonce ])) : '';
        $nonceAction    = basename(__FILE__);

        if (! wp_verify_nonce($sanitizedNonce, $nonceAction)) {
            return $postId;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $postId;
        }

        if (! current_user_can('edit_post', $postId)) {
            return $postId;
        }

        /**
         * Sanitize fields
         */
        foreach ($this->fields as $field) :
            switch ($field['type']) {
                case 'checkbox-group':
                    (new CheckboxGroupField($field['id']))->saveGroup($postId, $field['options']);
                    break;

                case 'checkbox':
                    (new CheckboxField($field['id']))->save($postId);
                    break;

                case 'date':
                    (new DateField($field['id']))->save($postId);
                    break;

                case 'image':
                    (new ImageField($field['id']))->save($postId);
                    break;

                case 'number':
                    (new NumberField($field['id']))->save($postId);
                    break;

                case 'rich-text':
                    (new RichTextField($field['id']))->save($postId);
                    break;

                case 'radio-group':
                    (new RadioGroupField($field['id']))->save($postId);
                    break;

                case 'select':
                    (new SelectField($field['id']))->save($postId);
                    break;

                case 'taxonomy-checkbox-group':
                    (new TaxonomyCheckboxGroupField(
                        $field['id'],
                        $field['label'],
                        null,
                        [],
                        $field['taxonomy']
                    ))->save(
                        $postId
                    );
                    break;

                case 'taxonomy-radio':
                    (new TaxonomyRadioField(
                        $field['id'],
                        $field['label'],
                        null,
                        [],
                        $field['taxonomy']
                    ))->save(
                        $postId
                    );
                    break;

                case 'taxonomy-select':
                    (new TaxonomySelectField(
                        $field['id'],
                        $field['label'],
                        null,
                        [],
                        $field['taxonomy']
                    ))->save(
                        $postId
                    );
                    break;

                case 'text':
                    (new TextField($field['id']))->save($postId);
                    break;

                case 'textarea':
                    (new TextareaField($field['id']))->save($postId);
                    break;

                case 'url':
                    (new UrlField($field['id']))->save($postId);
                    break;

                default:
                    // code...
                    break;
            }
        endforeach;

        return $postId;
    }

    /**
     * Register custom fields
     *
     * @since 0.1.0
     * @access public
     * @return void
     */
    public function register(): void {
        add_action('add_meta_boxes', [$this, 'addMetabox']);
        add_action('save_post', [$this, 'saveMetabox']);
    }
}
