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

class User
{
    /**
     * @var User[]
     */
    private static $instances = [];

    /**
     * @return User
     */
    public static function getInstance(int $id): User
    {
        if (!isset(self::$instances[$id]) || !(self::$instances[$id] instanceof User)) {
            self::$instances[$id] = new self($id);
        }

        return self::$instances[$id];
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var string|false
     */
    private $displayName = null;

    /**
     * @var string|false
     */
    private $permalink = null;

    /**
     * @var string|false
     */
    private $description = null;

    /**
     * @var array|false
     */
    private $avatar = [];

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->setId($id);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|false
     */
    public function getDisplayName()
    {
        if (is_null($this->displayName)) {
            $this->displayName = get_the_author_meta('display_name', $this->getId());

            if (empty($this->displayName)) {
                $this->displayName = false;
            }
        }

        return $this->displayName;
    }

    /**
     * @return false|string
     */
    public function getPermalink()
    {
        if (is_null($this->permalink)) {
            $this->permalink = get_author_posts_url($this->getId());

            if (empty($this->permalink)) {
                $this->permalink = false;
            }
        }

        return $this->permalink;
    }

    /**
     * @return false|string
     */
    public function getDescription()
    {
        if (is_null($this->description)) {
            $this->description = get_user_meta($this->getId(), 'description', true);

            if (empty($this->description)) {
                $this->description = false;
            }
        }

        return $this->description;
    }

    /**
     * @return false|string
     */
    public function getAvatar($size = 96)
    {
        if (!isset($this->avatar[$size])) {
            $this->avatar[$size] = get_avatar($this->getId(), $size, '', '', ['class' => 'img lazyload']);

            if (empty($this->avatar[$size])) {
                $this->avatar[$size] = false;
            }
        }

        return $this->avatar[$size];
    }

    /**
     * @param int $id
     * @return $this
     */
    private function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
