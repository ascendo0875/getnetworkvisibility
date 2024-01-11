<?php
namespace FINNPartners\Theme\Block\Instance\Fields\ACF;
use WpAdvanceCustomFieldsExtend\Service\Media;

class EventsArchive {

    /**
     * @var EventsArchive[]
     */
    private static $instaces = [];

    /**
     * @param int|false $postId
     * @param string|false $blockId
     * @return EventsArchive
     */
    public static function getInstance($postId = false, $blockId = false): EventsArchive
    {
        if(!$postId && !$blockId) {
            return new self($postId, $blockId);
        }
        
        if((!isset(self::$instaces[$postId]) && !isset(self::$instaces[$postId][$blockId])) || !self::$instaces[$postId][$blockId] instanceof EventsArchive) {
            self::$instaces[$postId][$blockId] = new self($postId);
        }

        return self::$instaces[$postId][$blockId];
    }

    /**
     * @var int|false
     */
    private $postId;

    /**
     * @var string
     */
    private $blockId;

    /**
    * @var string|false
    */
    private $theMessageIfThereAreNoUpcomingEvents = null;

    /**
    * @var string|false
    */
    private $theMessageIfThereAreNoPastEvents = null;

    /**
     * @param int|false $postId
     * @param string|false $blockId
     */
    public function __construct($postId = false, $blockId = false) {
        $this->setPostId($postId)
                ->setBlockId(empty($blockId) ? "block_".uniqid() : $blockId);
    }

    /**
     * @return int|false
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @return string
     */
    public function getBlockId(): string
    {
        return $this->blockId;
    }

    /**
     * @return string|false
     */
    public function getTheMessageIfThereAreNoUpcomingEvents()
    {
        if((is_null($this->theMessageIfThereAreNoUpcomingEvents) || (is_admin() && acf_is_block_editor()))) {
            $theMessageIfThereAreNoUpcomingEvents = get_field('the_message_if_there_are_no_upcoming_events');

            $this->setTheMessageIfThereAreNoUpcomingEvents(!empty($theMessageIfThereAreNoUpcomingEvents) ? $theMessageIfThereAreNoUpcomingEvents : "");
        }

        return $this->theMessageIfThereAreNoUpcomingEvents;
    }

    /**
     * @param string|false $theMessageIfThereAreNoUpcomingEvents
     * @return $this
     */
    public function setTheMessageIfThereAreNoUpcomingEvents($theMessageIfThereAreNoUpcomingEvents): self
    {
        $this->theMessageIfThereAreNoUpcomingEvents = !empty($theMessageIfThereAreNoUpcomingEvents) ? $theMessageIfThereAreNoUpcomingEvents : false;

        return $this;
    }

    /**
     * @return string|false
     */
    public function getTheMessageIfThereAreNoPastEvents()
    {
        if((is_null($this->theMessageIfThereAreNoPastEvents) || (is_admin() && acf_is_block_editor()))) {
            $theMessageIfThereAreNoPastEvents = get_field('the_message_if_there_are_no_past_events');

            $this->setTheMessageIfThereAreNoPastEvents(!empty($theMessageIfThereAreNoPastEvents) ? $theMessageIfThereAreNoPastEvents : "");
        }

        return $this->theMessageIfThereAreNoPastEvents;
    }

    /**
     * @param string|false $theMessageIfThereAreNoPastEvents
     * @return $this
     */
    public function setTheMessageIfThereAreNoPastEvents($theMessageIfThereAreNoPastEvents): self
    {
        $this->theMessageIfThereAreNoPastEvents = !empty($theMessageIfThereAreNoPastEvents) ? $theMessageIfThereAreNoPastEvents : false;

        return $this;
    }

    /**
     * @param int|false $postId
     * @return $this
     */
    protected function setPostId(int $postId): self
    {
        $this->postId = $postId;

        return $this;
    }

    /**
     * @param string $blockId
     * @return $this
     */
    protected function setBlockId(string $blockId): self
    {
        $this->blockId = $blockId;

        return $this;
    }

}