<?php
/**
 * Add product category on the product title in shop loop.
 *
 * @package WooCommerce
 */

// Remove default product title action.
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

// Add custom product title action with categories.
add_action( 'woocommerce_shop_loop_item_title', 'jl_woo_loop_product_title', 10 );

/**
 * Custom product title function that includes product categories.
 *
 * Displays the product title followed by its categories as links.
 */
function jl_woo_loop_product_title() {
	global $post;
	?>
	<h3 class="woocommerce-loop-product__title"><?php echo get_the_title(); ?></h3>

	<?php
	$terms = get_the_terms( $post->ID, 'product_cat' );
	
	// Only display if the product has at least one category.
	if ( $terms && ! is_wp_error( $terms ) ) :
		$cat_links = array();
		
		foreach ( $terms as $term ) {
			$cat_links[] = '<a href="' . esc_url( home_url() ) . '/product-category/' . $term->slug . '">' . $term->name . '</a>';
		}
		
		$on_cat = join( ', ', $cat_links );
		?>
		<div class="label-group">
			<div class="categories-link"><?php echo $on_cat; ?></div>
		</div>
	<?php endif;
}