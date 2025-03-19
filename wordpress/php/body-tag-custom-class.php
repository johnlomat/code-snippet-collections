<?php
/**
 * Adds custom classes to the body tag.
 *
 * @param array $classes Existing body classes.
 * @return array Modified body classes.
 */
function custom_body_classes( $classes ) {
    $classes[] = 'custom-class'; // Add your custom class.

    return $classes;
}
add_filter( 'body_class', 'custom_body_classes' );
