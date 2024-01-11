<?php

namespace FINNPartners\Theme\Service;

class VideoFrame
{
    const EMBED_ENDPOINTS = [
        'youtube' => 'https://www.youtube.com/embed/',
        'vimeo' => 'https://player.vimeo.com/video/',
    ];

    const WATCH_ENDPOINTS = [
        'youtube' => 'https://www.youtube.com/watch?v=',
        'vimeo' => 'https://vimeo.com/',
    ];

    const THUMBNAIL_QUALITIES_YOUTUBE = [
        'default' => 'default', // small thumbnail 120x90px with top & bottom bars
        'hqdefault' => 'hqdefault', // medium thumbnail 480x360px top & bottom bars
        'mqdefault' => 'mqdefault', // medium thumbnail 320x180px no bars
        'sddefault' => 'sddefault', // medium thumbnail 640x480px  top & bottom bars
        'maxresdefault' => 'maxresdefault', // large thumbnail 1280x720px no bars
    ];

    const THUMBNAIL_QUALITIES_VIMEO = [
        'thumbnail_small' => 'thumbnail_small', // small thumbnail 120x90px with top & bottom bars
        'thumbnail_medium' => 'thumbnail_medium', // medium thumbnail 480x360px top & bottom bars
        'thumbnail_large' => 'thumbnail_large', // medium thumbnail 320x180px no bars
    ];

    /**
     * @var null|string
     */
    private ?string $url = null;

    /**
     * @var null|string
     */
    private ?string $videoID = null;

    /**
     * @var bool
     */
    private bool $autoplay = false;

    /**
     * @var bool
     */
    private bool $showControls = true;

    /**
     * @var bool
     */
    private bool $showInfo = true;

    /**
     * @var bool
     */
    private bool $showRelated = false;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        if (!empty($url)) {
            $this->setUrl($url);
            $videoId = $this->getVideoIdFromUrl();
            if (!empty($videoId)) {
                $this->setVideoID($videoId);
            }
        }
    }

    /**
     * @param string $url
     * @return void
     */
    function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    function isYouTube(): bool
    {
        return str_contains($this->getUrl(), 'youtube') || str_contains($this->getUrl(), 'youtu.be');
    }

    /**
     * @return bool
     */
    function isVimeo(): bool
    {
        return str_contains($this->url, 'vimeo');
    }

    /**
     * @param bool $value
     * @return void
     */
    function setAutoplay(bool $value): void
    {
        $this->autoplay = $value;
    }

    /**
     * @return bool
     */
    function getAutoplay(): bool
    {
        return $this->autoplay;
    }

    /**
     * @param bool $value
     * @return void
     */
    function setShowControls(bool $value): void
    {
        $this->showControls = $value;
    }

    /**
     * @return bool
     */
    function getShowControls(): bool
    {
        return $this->showControls;
    }

    /**
     * @param bool $value
     * @return void
     */
    function setShowInfo(bool $value): void
    {
        $this->showInfo = $value;
    }

    /**
     * @return bool
     */
    function getShowInfo(): bool
    {
        return $this->showInfo;
    }

    /**
     * @param bool $value
     * @return void
     */
    function setShowRelated(bool $value): void
    {
        $this->showRelated = $value;
    }

    /**
     * @return bool
     */
    function getShowRelated(): bool
    {
        return $this->showRelated;
    }

    /**
     * @param string $videoId
     * @return void
     */
    function setVideoID(string $videoId): void
    {
        $this->videoID = $videoId;
    }

    function getVideoID()
    {

        return $this->videoID;
    }

    /**
     * @return string|null
     */
    function getVideoIdFromUrl(): ?string
    {
        $videoID = null;

        if (!empty($this->getUrl())) {

            if ($this->isYouTube()) {
                // Check if Watch Url: 'https://www.youtube.com/watch?v=5qap5aO4i9A'
                $path = parse_url($this->getUrl(), PHP_URL_QUERY);
                parse_str($path, $args);
                $videoID = empty($args["v"]) ? null : $args["v"];

                // Check if /v/ Url: 'http://www.youtube.com/v/5qap5aO4i9A?version=3&autohide=1'
                if (empty($videoID)) {
                    $parts = explode("?", $this->getUrl());
                    preg_match('/^(.*)\/v\/(.*)/', $parts[0], $matches);
                    $videoID = empty($matches[2]) ? null : $matches[2];
                }

                // Check if Embed Url: 'https://www.youtube.com/embed/5qap5aO4i9A'
                if (empty($videoID)) {
                    $parts = explode("?", $this->getUrl());
                    preg_match('/^(.*)\/embed\/(.*)/', $parts[0], $matches);
                    $videoID = empty($matches[2]) ? null : $matches[2];
                }

                // Check if Sort Url: 'https://youtu.be/5qap5aO4i9A'
                if (empty($videoID)) {
                    preg_match('/(https?:\/\/)?(www\.)?youtu\.be\/(.*)/', $this->getUrl(), $matches);
                    $videoID = empty($matches[3]) ? null : $matches[3];
                }
            } elseif ($this->isVimeo()) {
                $path = parse_url($this->getUrl(), PHP_URL_PATH);
                $args = explode('/', $path);
                $videoID = empty($args) ? null : end($args);
            }
        }

        return empty($videoID) ? null : strval($videoID);
    }

    /**
     * @return string|null
     */
    function getEmbedEndpointURL(): ?string
    {
        $url = null;

        if ($this->isYouTube())
            $url = self::EMBED_ENDPOINTS['youtube'];

        if ($this->isVimeo())
            $url = self::EMBED_ENDPOINTS['vimeo'];

        return $url;
    }

    /**
     * @return string|null
     */
    function getWatchEndpointURL(): ?string
    {
        $url = null;

        if ($this->isYouTube())
            $url = self::WATCH_ENDPOINTS['youtube'];

        if ($this->isVimeo())
            $url = self::WATCH_ENDPOINTS['vimeo'];

        return $url;
    }

    /**
     * @return string|null
     */
    function getEmbedURL(): ?string
    {
        $url = null;

        if (!empty($this->getVideoID())) {
            $url = $this->getEmbedEndpointURL() . $this->getVideoID();
            $url = add_query_arg('autoplay', intval($this->getAutoplay()), $url);
            $url = add_query_arg('controls', intval($this->getShowControls()), $url);
            $url = add_query_arg('info', intval($this->getShowInfo()), $url);
            $url = add_query_arg('rel', intval($this->getShowRelated()), $url);
        }

        return $url;
    }


    /**
     * @return string|null
     */
    function getWatchURL(): ?string
    {
        $url = null;

        if (!empty($this->getVideoID())) {
            $url = $this->getWatchEndpointURL() . $this->getVideoID();
        }

        return $url;
    }

    /**
     * @param string|null $quality
     * @return string
     */
    function getThumbnailPreviewUrl(string $quality = null): string
    {
        $url = null;

        if (!empty($this->getVideoID())) {

            if ($this->isYouTube()) {
                $quality = empty($quality)
                    ? self::THUMBNAIL_QUALITIES_YOUTUBE['maxresdefault']
                    : (in_array($quality, self::THUMBNAIL_QUALITIES_YOUTUBE) ? $quality : self::THUMBNAIL_QUALITIES_YOUTUBE['maxresdefault'])
                ;
                $url = "https://img.youtube.com/vi/{$this->getVideoID()}/{$quality}.jpg";
            }

            if ($this->isVimeo()) {
                /*
                 * To get data about a specific video, use the following url:
                 *  http://vimeo.com/api/v2/video/{video_id}.{output}
                 *      - {video_id} The ID of the video you want information for.
                 *      - {output} Specify the output type. We currently offer JSON, PHP, and XML formats.
                 */
                $vimeoHash = unserialize(file_get_contents("https://vimeo.com/api/v2/video/{$this->getVideoID()}.php"));
                $quality = empty($quality)
                    ? self::THUMBNAIL_QUALITIES_VIMEO['thumbnail_large']
                    : (in_array($quality, self::THUMBNAIL_QUALITIES_VIMEO) ? $quality : self::THUMBNAIL_QUALITIES_VIMEO['thumbnail_large'])
                ;
                //x($vimeoHash);
                $url = strval($vimeoHash[0][$quality]);
            }
        }

        return $url;
    }

    /**
     * @param string $content
     * @param string $tag
     * @return string
     */
    public static function applyEmbedContainerToContent(string $content, string $tag = 'div')
    {
        $content = str_replace('<iframe ', '<' . $tag . ' class="embed-container"><iframe ', $content);

        return str_replace('</iframe>', '</iframe></' . $tag . '>', $content);
    }

}