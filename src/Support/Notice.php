<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support;

class Notice {
    /**
     * The message
     * @var string $message The message
     */
    protected $message;

    /**
     * Constructor
     * @param string $message The message
     * @return void
     */
    public function __construct(string $message) {
        $this->message = $message;
    }

    /**
     * Get the HTML for the notice
     * @return void
     */
    public function getHtml() {
        echo '<div class="notice notice-error"><p>' . esc_html($this->message) . '</p></div>';
    }

    /**
     * Display the notice
     * @return void
     */
    public function display() {
        add_action('admin_notices', [$this, 'getHtml']);
    }
}
