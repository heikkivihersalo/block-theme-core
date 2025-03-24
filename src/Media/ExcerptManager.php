<?php

declare(strict_types=1);

namespace Vihersalo\Core\Media;

class ExcerptManager {
    /**
     * The length of the excerpt
     * @var string|int
     */
    private $length;

    /**
     * The more text for the excerpt
     * @var string
     */
    private $more;

    /**
     * Constructor
     * @param string|int $length The length of the excerpt
     * @param string $more The more text for the excerpt
     * @return void
     */
    public function __construct(string|int $length, string $more) {
        $this->length = $length;
        $this->more   = $more;
    }

    /**
     * Override default excerpt length
     *
     * @return int
     */
    public function customExcerptLength(): int {
        if (! isset($this->length)) {
            return 55;
        }

        // check that is integer
        if (is_int($this->length)) {
            return $this->length;
        }

        // Check that is string and convert to integer
        if (is_string($this->length)) {
            return (int) $this->length;
        }

        return 55;
    }

    /**
     * Override default excerpt more
     *
     * @return string
     */
    public function customExcerptMore(): string {
        if (! isset($this->more)) {
            return '&hellip;';
        }

        // check that is string
        if (is_string($this->more)) {
            return $this->more;
        }

        return '&hellip;';
    }
}
