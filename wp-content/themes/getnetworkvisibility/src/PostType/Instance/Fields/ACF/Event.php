<?php
namespace FINNPartners\Theme\PostType\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class Event {

    const LABEL_ = "<strong>Note</strong>";
    const LABEL_STARTDATE = "Start Date";
    const LABEL_ENDDATE = "End Date";
    const LABEL_LOCATION = "Location";
    const LABEL_REGISTERPAGE = "Register Page";
    const LABEL_DONTLINKTODETAILPAGE = "Don't link to detail page";

    /**
     * @var Event[]
     */
    private static $instaces = [];

    /**
     * @param int $postId
     * @return Event
     */
    public static function getInstance(int $postId): Event
    {
        if(!isset(self::$instaces[$postId]) || !self::$instaces[$postId] instanceof Event) {
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
    private $startDate = null;

    /**
    * @var string|false
    */
    private $endDate = null;

    /**
    * @var array|false
    */
    private $location = null;

    /**
    * @var array|false
    */
    private $registerPage = null;

    /**
    * @var bool|false
    */
    private $dontLinkToDetailPage = null;

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
    public function getStartDate()
    {
        if((is_null($this->startDate) || (is_admin() && acf_is_block_editor()))) {
            $startDate = get_field('start_date', $this->getPostId());

            $this->setStartDate(!empty($startDate) ? $startDate : null);
        }

        return $this->startDate;
    }

    /**
     * @param string|false $startDate
     * @return $this
     */
    public function setStartDate($startDate): self
    {
        $this->startDate = !empty($startDate) ? $startDate : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getEndDate()
    {
        if((is_null($this->endDate) || (is_admin() && acf_is_block_editor()))) {
            $endDate = get_field('end_date', $this->getPostId());

            $this->setEndDate(!empty($endDate) ? $endDate : null);
        }

        return $this->endDate;
    }

    /**
     * @param string|false $endDate
     * @return $this
     */
    public function setEndDate($endDate): self
    {
        $this->endDate = !empty($endDate) ? $endDate : false;

        return $this;
    }

    /**
     * @return array|false
     */
    public function getLocation()
    {
        if((is_null($this->location) || (is_admin() && acf_is_block_editor()))) {
            $location = get_field('location', $this->getPostId());

            $this->setLocation(!empty($location) ? $location : null);
        }

        return $this->location;
    }

    /**
     * @param array|false $location
     * @return $this
     */
    public function setLocation($location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return array|false
     */
    public function getRegisterPage()
    {
        if((is_null($this->registerPage) || (is_admin() && acf_is_block_editor()))) {
            $registerPage = get_field('register_page', $this->getPostId());

             $this->setRegisterPage(!empty($registerPage) ? $registerPage : false);
        }

        return $this->registerPage;
    }

    /**
     * @param array|false $registerPage
     * @return $this
     */
    public function setRegisterPage($registerPage): self
    {
        $this->registerPage = !empty($registerPage) ? $registerPage : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function isDontLinkToDetailPage()
    {
        if((is_null($this->dontLinkToDetailPage) || (is_admin() && acf_is_block_editor()))) {
            $dontLinkToDetailPage = get_field('dont_link_to_detail_page', $this->getPostId());
            
            $dontLinkToDetailPage = boolval($dontLinkToDetailPage);
            
            $this->setDontLinkToDetailPage($dontLinkToDetailPage);
        }

        return $this->dontLinkToDetailPage;
    }
    
    /**
     * @param bool $dontLinkToDetailPage
     * @return $this
     */
    public function setDontLinkToDetailPage(bool $dontLinkToDetailPage): self
    {
        $this->dontLinkToDetailPage = $dontLinkToDetailPage;

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