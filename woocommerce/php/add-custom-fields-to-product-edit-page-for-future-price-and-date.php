<?php
/*
 * Snippet: How to Programmatically Schedule Price Changes for Products in WooCommerce
 * Author: John Lomat
 * URL: https://johnlomat.vercel.app/
 * Tested with WooCommerce 9.3.3
 * "Add custom fields to product edit page for future price and date"
*/
function wcsuccess_add_schedule_price_fields() {
    woocommerce_wp_text_input(array(
        'id' => 'wcsuccess_scheduled_price',
        'label' => __('Scheduled Sale Price', 'woocommerce'),
        'description' => __('Enter the scheduled sale price that will automatically apply.', 'woocommerce'),
        'desc_tip' => true,
        'type' => 'text',
    ));
    woocommerce_wp_text_input(array(
        'id' => 'wcsuccess_schedule_date',
        'label' => __('Schedule Date', 'woocommerce'),
        'description' => __('Enter the date when the sale price takes effect (format: MM-DD-YYYY)', 'woocommerce'),
        'desc_tip' => true,
        'type' => 'date',
    ));
}
add_action('woocommerce_product_options_pricing', 'wcsuccess_add_schedule_price_fields');

/*
 * Snippet: How to Programmatically Schedule Price Changes for Products in WooCommerce
 * Author: John Lomat
 * URL: https://johnlomat.vercel.app/
 * Tested with WooCommerce 9.3.3
 * "Save scheduled prices and dates from product edit page"
*/
function wcsuccess_save_schedule_price_fields($post_id) {
    if (isset($_POST['wcsuccess_scheduled_price'])) {
        update_post_meta($post_id, 'wcsuccess_scheduled_price', sanitize_text_field($_POST['wcsuccess_scheduled_price']));
    }
    if (isset($_POST['wcsuccess_schedule_date'])) {
        update_post_meta($post_id, 'wcsuccess_schedule_date', sanitize_text_field($_POST['wcsuccess_schedule_date']));
    }
}
add_action('woocommerce_process_product_meta', 'wcsuccess_save_schedule_price_fields');

/*
 * Snippet: How to Programmatically Schedule Price Changes for Products in WooCommerce
 * Author: John Lomat
 * URL: https://johnlomat.vercel.app/
 * Tested with WooCommerce 9.3.3
 * "Apply scheduled price changes based on stored dates"
*/
function wcsuccess_apply_scheduled_price_changes() {
    $args = array(
        'status' => 'publish',
        'limit' => -1,
        'meta_query' => array(
            array(
                'key' => 'wcsuccess_schedule_date',
                'value' => current_time('Y-m-d'),
                'compare' => '=',
            ),
        ),
    );
    $products = wc_get_products($args);
    foreach ($products as $product_id) {
        $scheduled_price = get_post_meta($product_id, 'wcsuccess_scheduled_price', true);
        if ($scheduled_price) {
            update_post_meta($product_id, '_price', $scheduled_price);
            update_post_meta($product_id, '_sale_price', $scheduled_price);
        }
    }
}
add_action('init', 'wcsuccess_apply_scheduled_price_changes');