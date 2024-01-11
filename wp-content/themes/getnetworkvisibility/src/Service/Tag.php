<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage FinnPartners
 * @since FinnPartners 1.0
 */

namespace FINNPartners\Theme\Service;

class Tag extends Term
{
    /**
     * @var Tag[]
     */
    private static $instances = [];

    /**
     * @param int $termId
     * @param string $taxonomy
     * @param \WP_Term|null $term
     * @return Tag
     */
    public static function getInstance(int $termId, string $taxonomy = 'post_tag', ?\WP_Term $term = null): Tag
    {
        if (!isset(self::$instances["{$taxonomy}-{$termId}"])) {
            self::$instances["{$taxonomy}-{$termId}"] = new self($termId, $taxonomy, $term);
        }

        return self::$instances["{$taxonomy}-{$termId}"];
    }

}
