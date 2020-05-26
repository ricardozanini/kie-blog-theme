<?php

/**
 * Custom walker class.
 * 
 * @since  KIE Theme 1.0.0
 */
class KIE_Walker_Nav_Menu extends Walker_Nav_Menu
{

    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query;

        // Link attributes.
        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';

        // Build HTML output and pass through the proper filter.
        $item_output = sprintf(
            '<a%1$s>%2$s%3$s%4$s</a>',
            $attributes,
            $args->link_before,
            apply_filters('the_title', $item->title, $item->ID),
            $args->link_after
        );
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

add_filter('wp_nav_menu_items', 'kie_add_logo_item_menu', 10, 2);
/**
 * Add Menu Item to end of menu
 */
function kie_add_logo_item_menu($items, $args)
{
    if ($args->theme_location == 'primary') {
        $items =  '<a href="http://kie.org" class="logo"></a> <h1>KIE</h1>' . $items . '<a href="#" class="responsive-menu-button">&#9776;</a>';
    }
    if ($args->theme_location == 'responsive') {
        $items = '<h4>KIE</h4>' . $items;
    }
    return $items;
}
