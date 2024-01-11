<?php
namespace FINNPartners\Theme\PostType\Instance\Fields\ACF;

class Bio {

    /**
     * @var Bio[]
     */
    private static $instaces = [];

    /**
     * @param int $postId
     * @return Bio
     */
    public static function getInstance(int $postId): Bio
    {
        if(!isset(self::$instaces[$postId]) || !self::$instaces[$postId] instanceof Bio) {
            self::$instaces[$postId] = new self($postId);
        }

        return self::$instaces[$postId];
    }

    /**
     * @var int
     */
    private $postId;

    /**
    * @var string|false
    */
    private $firstName = null;

    /**
    * @var string|false
    */
    private $lastName = null;

    /**
    * @var string|false
    */
    private $email = null;

    /**
     * @param int $postId
     */
    public function __construct(int $postId) {
        $this->setPostId($postId);
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @return string|false
     */
    public function getFirstName()
    {
        if((is_null($this->firstName) || (is_admin() && acf_is_block_editor()))) {
            $firstName = get_field('first_name', $this->getPostId());

            $this->setFirstName(!empty($firstName) ? $firstName : "");
        }

        return $this->firstName;
    }

    /**
     * @param string|false $firstName
     * @return $this
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = !empty($firstName) ? $firstName : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getLastName()
    {
        if((is_null($this->lastName) || (is_admin() && acf_is_block_editor()))) {
            $lastName = get_field('last_name', $this->getPostId());

            $this->setLastName(!empty($lastName) ? $lastName : "");
        }

        return $this->lastName;
    }

    /**
     * @param string|false $lastName
     * @return $this
     */
    public function setLastName($lastName): self
    {
        $this->lastName = !empty($lastName) ? $lastName : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getEmail()
    {
        if((is_null($this->email) || (is_admin() && acf_is_block_editor()))) {
            $email = get_field('email', $this->getPostId());

            $this->setEmail(!empty($email) ? $email : "");
        }

        return $this->email;
    }

    /**
     * @param string|false $email
     * @return $this
     */
    public function setEmail($email): self
    {
        $this->email = !empty($email) ? $email : false;

        return $this;
    }

    /**
     * @param int $postId
     * @return $this
     */
    protected function setPostId(int $postId): self
    {
        $this->postId = $postId;

        return $this;
    }
    
}