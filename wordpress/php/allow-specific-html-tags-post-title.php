<?php
/**
 * Allow specific HTML tags in post titles.
 *
 * @param string $title The post title.
 * @return string The modified post title with allowed HTML tags.
 */
function wh_allow_html_in_titles( $title ) {
    // Define which HTML tags and attributes are allowed
    $allowed_html = array(
        'br'     => array(),
        'span'   => array(
            'class' => array(),
            'style' => array(),
        ),
        'em'     => array(),
        'strong' => array(),
    );
    
    // First decode entities if they exist
    $title = html_entity_decode( $title );
    
    // Then apply wp_kses filtering with our allowed tags
    return wp_kses( $title, $allowed_html );
}

add_filter( 'the_title', 'wh_allow_html_in_titles', 10, 1 );
add_filter( 'single_post_title', 'wh_allow_html_in_titles', 10, 1 );