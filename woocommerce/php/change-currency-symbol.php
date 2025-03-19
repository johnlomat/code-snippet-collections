<?php
/**
 * Change WooCommerce currency symbol.
 *
 * @package WooCommerce
 */

/**
 * Filter the WooCommerce currency symbol.
 *
 * @param string $currency_symbol Currency symbol.
 * @param string $currency Currency code.
 * @return string Modified currency symbol.
 */
function change_existing_currency_symbol( $currency_symbol, $currency ) {
	switch ( $currency ) {
		case 'SGD':
			$currency_symbol = 'S$';
			break;
	}
	
	return $currency_symbol;
}

add_filter( 'woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2 );