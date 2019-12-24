//add order details to Stripe payment metadata and add this code in function.php file in your theme or child theme folder
function filter_wc_stripe_payment_metadata( $metadata, $order, $source ) {
    $order_data = $order->get_data();
    $metadata['Total Tax Charged'] = $order_data['total_tax'];
    $metadata['Total Shipping Charged'] = $order_data['shipping_total'];
    $count = 1;
    foreach( $order->get_items() as $item_id => $line_item ){
        $item_data = $line_item->get_data();
        $product = $line_item->get_product();
        $product_name = $product->get_name();
        $item_quantity = $line_item->get_quantity();
        $item_total = $line_item->get_total();
        $metadata['Line Item '.$count] = 'Product name: '.$product_name.' | Quantity: '.$item_quantity.' | Item total: '. number_format( $item_total, 2 );
        $count += 1;
    }

    return $metadata;
}
add_filter( 'wc_stripe_payment_metadata', 'filter_wc_stripe_payment_metadata', 10, 3 );
