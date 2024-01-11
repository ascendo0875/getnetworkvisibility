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

class Term
{
    /**
     * @var Term[]
     */
    private static $instances = [];

    /**
     * @param int $termId
     * @param string $taxonomy
     * @param \WP_Term|null $term
     * @return Term
     */
    public static function getInstance(int $termId, string $taxonomy, ?\WP_Term $term = null): Term
    {
        if (!isset(self::$instances["{$taxonomy}-{$termId}"])) {
            self::$instances["{$taxonomy}-{$termId}"] = new self($termId, $taxonomy, $term);
        }

        return self::$instances["{$taxonomy}-{$termId}"];
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $taxonomy;

    /**
     * @var \WP_Term
     */
    private $term;

    /**
     * @param int $termId
     * @param string $taxonomy
     * @param \WP_Term|null $term
     */
    public function __construct(int $termId, string $taxonomy, ?\WP_Term $term = null)
    {
        $this->setId($termId)
            ->setTaxonomy($taxonomy);

        if (is_null($term)) {
            $this->getTerm();
        }

        if ($term instanceof \WP_Term) {
            $this->setTerm($term);
        }
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $taxonomy
     * @return $this
     */
    public function setTaxonomy(string $taxonomy): self
    {
        $this->taxonomy = $taxonomy;

        return $this;
    }

    /**
     * @return string
     */
    public function getTaxonomy(): string
    {
        return $this->taxonomy;
    }

    /**
     * @param \WP_Term $term
     * @return $this
     */
    public function setTerm(\WP_Term $term): self
    {
        $this->term = $term;

        return $this;
    }

    /**
     * @return false|string
     */
    public function getSlug()
    {
        return $this->getTerm() ? $this->getTerm()->slug : false;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->getTerm() ? $this->getTerm()->count : 0;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getTerm() ? $this->getTerm()->name : '';
    }

    /**
     * @return string|false
     */
    public function getPermalink()
    {
        return $this->getTerm() ? get_term_link($this->getTerm()->term_id) : false;
    }

    /**
     * @return \WP_Term
     */
    private function getTerm(): \WP_Term
    {
        if (is_null($this->term)) {
            $this->term = get_term_by('term_id', $this->getId(), $this->getTaxonomy());

            if (empty($this->term)) {
                $this->term = false;
            }
        }

        return $this->term;
    }
}
