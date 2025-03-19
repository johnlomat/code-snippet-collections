<?php
/**
 * Add width and height attributes to Oxygen's image component.
 *
 * @param array  $options Component options.
 * @param string $tag     Component tag.
 */
function custom_oxygen_image_dimensions( $options, $tag ) {
	if ( 'ct_image' !== $tag ) {
		return;
	}

	// Setup.
	$image_type        = isset( $options['image_type'] ) ? $options['image_type'] : 0; // 1 = Image URL, 2 = Media Library attachment.
	$width             = null;
	$height            = null;
	$auto_empty_width  = false;
	$auto_empty_height = false;

	// Try and detect width and height from Attachment ID or URL.
	if ( 2 === $image_type && isset( $options['attachment_id'], $options['attachment_size'] ) ) {
		$image_attributes = wp_get_attachment_image_src( $options['attachment_id'], $options['attachment_size'] );
		if ( is_array( $image_attributes ) && isset( $image_attributes[1], $image_attributes[2] ) ) {
			$width  = $image_attributes[1];
			$height = $image_attributes[2];
		}
	} elseif ( 1 === $image_type && isset( $options['src'] ) ) {
		$image_attributes = wp_getimagesize( $options['src'] );
		if ( is_array( $image_attributes ) && isset( $image_attributes[0], $image_attributes[1] ) ) {
			$width  = $image_attributes[0];
			$height = $image_attributes[1];
		}
	}

	// If previous attempts failed, try to get width and height from Oxygen's settings.
	if ( null === $width ) {
		if ( isset( $options['attachment_width'] ) && ! empty( $options['attachment_width'] ) ) {
			$width = $options['attachment_width'];
		} elseif ( isset( $options['width'] ) && ! empty( $options['width'] ) ) {
			$width = $options['width'];
		}
	}

	if ( null === $height ) {
		if ( isset( $options['attachment_height'] ) && ! empty( $options['attachment_height'] ) ) {
			$height = $options['attachment_height'];
		} elseif ( isset( $options['height'] ) && ! empty( $options['height'] ) ) {
			$height = $options['height'];
		}
	}

	// Ensure only integer values are outputted.
	$width  = ( $width ) ? intval( preg_replace( '/[^0-9]/', '', $width ) ) : null;
	$height = ( $height ) ? intval( preg_replace( '/[^0-9]/', '', $height ) ) : null;

	// Print width if set.
	if ( $width ) {
		echo 'width="' . esc_attr( $width ) . '" ';
	}

	// Print height if set.
	if ( $height ) {
		echo 'height="' . esc_attr( $height ) . '" ';
	}
}
add_action( 'oxygen_vsb_component_attr', 'custom_oxygen_image_dimensions', 10, 2 );
