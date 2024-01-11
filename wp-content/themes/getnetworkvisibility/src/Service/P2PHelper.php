<?php

namespace FINNPartners\Theme\Service;

class P2PHelper
{
    /**
     * @var \WP_Post
     */
    protected $post;

    public function __construct()
    {
        $this->setPost(get_queried_object());
    }

    public function getPosts($p2pConnection, ?int $post_per_page = null)
    {
        $args = array(
            'connected_type' => $p2pConnection,
            'connected_items' => $this->getPost(),
            'suppress_filters' => false,
            'posts_per_page' => ($post_per_page ? $post_per_page : -1),
        );

        $posts = get_posts( $args );

        return $posts;
    }

    public function getPostsAsLinksFromConnection($p2pConnection, $useAnd = true, ?int $post_per_page = null)
    {
        $posts  = $this->getPosts($p2pConnection, $post_per_page);
        $result = false;
        $links  = [];
        foreach($posts as $p){
            $links[] = html_link(get_the_permalink($p), get_the_title($p));
        }

        $result = string_joinAnd($links);

        return $result;
    }

    public function getPostsLinkedToCurrentPost($postsType, ?int $post_per_page = null)
    {
        $posts = [];
        $connection = $this->guessConnection($postsType);

        if($connection){
            $posts = $this->getPosts($connection, $post_per_page);
        }

        return $posts;
    }

    public function getPostsLinked($fromPostType = null, $toPostType = null, $post_per_page = null) {
        $posts = [];
        $connection = $this->guessConnection($fromPostType, $toPostType);

        if($connection){
            $posts = $this->getPosts($connection, $post_per_page);
        }

        return $posts;
    }

    public function guessConnection($fromPostType = null, $toPostType = null)
    {

        if(!$fromPostType && !$toPostType) return null;

        if(!$fromPostType) $fromPostType = $this->getPost()->post_type;
        if(!$toPostType) $toPostType = $this->getPost()->post_type;

        $connection = false;
        $connection = p2p_type($fromPostType . '_to_' . $toPostType);
        if($connection) return $connection->name;
        $connection = p2p_type($toPostType . '_to_' . $fromPostType);
        if($connection) return $connection->name;

        return null;
    }

    public function getConnectedPostsIds($connection, $direction = 'from')
    {
        global $wpdb;

        $field = 'p2p_'.$direction;

        $query = "SELECT distinct($field) FROM $wpdb->p2p WHERE p2p_type = '".$wpdb->_real_escape($connection)."'";

        $data = $wpdb->get_results( $query , ARRAY_A);
        $data = wp_list_pluck($data, $field);

        return $data;

    }

    public function getConnectedPostsIdsByPost($connection, $id, $direction = 'from')
    {
        global $wpdb;

        $field = 'p2p_'.$direction;
        $relation = "(p2p_from = '{$id}' OR p2p_to = '{$id}')";

        if(is_array($id)) {
            $id = implode(", ", $id);
            $relation = "(p2p_from IN ({$id}) OR p2p_to IN ({$id}))";
        }

        $query = "SELECT distinct($field) FROM $wpdb->p2p WHERE {$relation} AND p2p_type = '".$wpdb->_real_escape($connection)."'";

        $data = $wpdb->get_results( $query , ARRAY_A);
        $data = wp_list_pluck($data, $field);

        return $data;

    }

    /**
     * @return P2PHelper
     */
    static function getHelper() : P2PHelper
    {
        global $p2ph;
        if(is_null($p2ph)){
            $p2ph = new P2PHelper();
        }

        return $p2ph;
    }

    /**
     * @return \WP_Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param \WP_Post $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

}