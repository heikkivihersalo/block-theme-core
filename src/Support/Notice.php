<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support;

class Notice {
    /**
     * The message
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $message    The message
     */
    protected $message;

    /**
     * Constructor
     *
     * @since    1.0.0
     * @access   public
     */
    public function __construct(string $message) {
        $this->message = $message;
    }

    /**
     * Get the HTML for the notice
     *
     * @return void
     */
    public function getHtml() {
        echo '<div class="notice notice-error"><p>' . esc_html($this->message) . '</p></div>';
    }

    /**
     * Display the notice
     *
     * @since    1.0.0
     */
    public function display() {
        add_action('admin_notices', [$this, 'getHtml']);
    }
}
