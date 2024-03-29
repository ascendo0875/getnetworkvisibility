<?php

namespace FINNPartners\Theme\Service;

use stdClass;
use Walker_Nav_Menu;
use WP_Post;

class NavMenu extends Walker_Nav_Menu
{
    /**
     * @var NavMenu $instance
     */
    private static $instance;

    /**
     * @var bool[]
     */
    private $hasChildElements = [];

    /**
     * @var bool[]
     */
    private $hasCallout = [];

    /**
     * @return NavMenu
     */
    public static function getInstance(): NavMenu
    {
        if (!(self::$instance instanceof NavMenu)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param object $element
     * @param array $children_elements
     * @param int $max_depth
     * @param int $depth
     * @param array $args
     * @param string $output
     * @return void
     */
    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if (!$element) {
            return;
        }

        $id_field = $this->db_fields['id'];
        $id = $element->$id_field;

        // Display this element.
        $this->has_children = !empty($children_elements[$id]);
        if (isset($args[0]) && is_array($args[0])) {
            $args[0]['has_children'] = $this->has_children; // Back-compat.
        }

        $this->start_el($output, $element, $depth, ...array_values($args));

        // Descend only when the depth is right and there are children for this element.
        if ((0 == $max_depth || $max_depth > $depth + 1) && isset($children_elements[$id])) {
            foreach ($children_elements[$id] as $child) {

                if (!isset($newlevel)) {
                    $newlevel = true;
                    // Start the child delimiter.
                    $this->start_lvl($output, $depth, ...array_values($args));
                }
                $this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
            }
            unset($children_elements[$id]);
        }

        if (isset($newlevel) && $newlevel) {
            // End the child delimiter.
            $this->end_lvl($output, $depth, ...array_values($args));
        }

        // End this element.
        $this->end_el($output, $element, $depth, ...array_values($args));
    }

    /**
     * @param string $output Used to append additional content (passed by reference).
     * @param object $data_object The data object.
     * @param int $depth Depth of the item.
     * @param array $args An array of additional arguments.
     * @param int $current_object_id Optional. ID of the current item. Default 0.
     * @return void
     */
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        parent::start_el($output, $data_object, $depth, $args, $current_object_id);

        if ($this->isHasChildElements($data_object, $args)) {
            $output .= '<div class="dropdown">';
            $output .= '<p><a href="#" class="back" data-parent-controls=".open">Back</a></p>';
            $output .= '<div><div class="sub-menu-callout">';           
            $output .= '<h3 class="is-style-gradient">' . $data_object->title . '</h3>';
        }
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        if ($this->isHasChildElements($data_object, $args)) {
            $output .= '</div>';
        }

        if ($depth < 1 && $this->isHasCallout($data_object)) {
            $output .= '<div class="menu-callout">';
            $heading = get_field('heading', $data_object);
            $blurb = get_field('blurb', $data_object);

            if (!empty(trim($heading))) {
                $output .= '<p class="h3">' . $heading . '</p>';
            }

            if (!empty($blurb)) {
                $output .= $blurb;
            }

            $output .= '</div>';
        }

        if ($this->isHasChildElements($data_object, $args)) {
            $output .= '</div></div>';
        }

        parent::end_el($output, $data_object, $depth, $args); // TODO: Change the autogenerated stub
    }

    /**
     * @param object $dataObject
     * @return bool
     */
    public function isHasCallout(object $dataObject): bool
    {
        if (!isset($this->hasCallout[$dataObject->ID])) {
            $hasCallout = get_field('callout_style', $dataObject->ID);

            $this->setHasCallout(!empty($hasCallout), $dataObject->ID);
        }
        return $this->hasCallout[$dataObject->ID];
    }

    /**
     * @param bool $hasCallout
     * @param $objectId
     * @return $this
     */
    public function setHasCallout(bool $hasCallout, $objectId): NavMenu
    {
        $this->hasCallout[$objectId] = $hasCallout;
        return $this;
    }

    /**
     * @param object $dataObject
     * @param $args
     * @return bool
     */
    public function isHasChildElements(object $dataObject, $args = null): bool
    {
        if(!isset($this->hasChildElements[$dataObject->ID])) {
            $this->setHasChildElements($args->walker->has_children, $dataObject->ID);
        }
        return $this->hasChildElements[$dataObject->ID];
    }

    /**
     * @param $hasChildElements
     * @param $objectId
     * @return $this
     */
    public function setHasChildElements(bool $hasChildElements, $objectId): NavMenu
    {
        $this->hasChildElements[$objectId] = $hasChildElements;
        return $this;
    }
}