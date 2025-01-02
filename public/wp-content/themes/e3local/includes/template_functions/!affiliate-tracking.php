<?php 

/* 

if ($_GET) {
    $url = $_SERVER['REQUEST_URI'];
    
    $url_parameters = [
        'location_toggle',
        'promo_campaign',
        'affiliate',
        'affiliate_type',
        'affiliate_id',
        'utm_source',
        'utm_campaign',
        'utm_medium',
        'utm_content',
        'utm_term',
        'utm_internal_id',
        'mc_cid',
        'mc_eid',
        'internal_campaign',
        'internal_campaign_id',
        'internal_campaign_name',
    ];

    $tracking_parameters = [];
    foreach ($url_parameters as $parameter) {
        if ($_GET[$parameter]) {
            $tracking_parameters [] = [
                'label' => $parameter,
                'parameter'=> strip_tags($_GET[$parameter])
            ];
        }
    }

    // $tracking_parameters = [
    //     // Country Toggle Tracking
    //     [
    //         'label' => 'location_toggle',
    //         'parameter' => strip_tags($_GET["location_toggle"])
    //     ],
    //     [
    //         'label' => 'author_campaign',
    //         'parameter' => strip_tags($_GET["author_campaign"])
    //     ],
    //     [
    //         'label' => 'promo_campaign',
    //         'parameter' => strip_tags($_GET["promo_campaign"])
    //     ],
    //     [
    //         'label' => 'affiliate',
    //         'parameter' => strip_tags($_GET["affiliate"])
    //     ],
    //     [
    //         'label' => 'affiliate_type',
    //         'parameter' => strip_tags($_GET["affiliate"])
    //     ],
    //     [
    //         'label' => 'affiliate_id',
    //         'parameter' => strip_tags($_GET["affiliate_id"])
    //     ],
    //     [
    //         'label' => 'utm_source',
    //         'parameter' => strip_tags($_GET["utm_source"])
    //     ], 
    //     [
    //         'label' => 'utm_campaign',
    //         'parameter' => strip_tags($_GET["utm_campaign"])
    //     ],  
    //     [
    //         'label' => 'utm_medium',
    //         'parameter' => strip_tags($_GET["utm_medium"])
    //     ],  
    //     [
    //         'label' => 'utm_content',
    //         'parameter' => strip_tags($_GET["utm_content"])
    //     ],  
    //     [
    //         'label' => 'utm_term',
    //         'parameter' => strip_tags($_GET["utm_term"])
    //     ],
    //     [
    //         'label' => 'mc_cid',
    //         'parameter' => strip_tags($_GET["mc_cid"])
    //     ],
    //     [
    //         'label' => 'mc_eid',
    //         'parameter' => strip_tags($_GET["mc_eid"])
    //     ],
    //     [
    //         'label' => 'internal_campaign',
    //         'parameter' => strip_tags($_GET["internal_campaign"])
    //     ],
    //     [
    //         'label' => 'internal_campaign_id',
    //         'parameter' => strip_tags($_GET["internal_campaign_id"])
    //     ],
    //     [
    //         'label' => 'internal_campaign_name',
    //         'parameter' => strip_tags($_GET["internal_campaign_name"])
    //     ],
    //     [
    //         'label' => 'discountbible_coupon',
    //         'parameter' => strip_tags($_GET["discountbible_coupon"])
    //     ],
    //     [
    //         'label' => 'discountbible_redirect',
    //         'parameter' => strip_tags($_GET["discountbible_redirect"])
    //     ],
    //     [
    //         'label' => 'discountbible_redirect_details',
    //         'parameter' => strip_tags($_GET["discountbible_redirect_details"])
    //     ],
    //     [
    //         'label' => 'frequently_bought_together',
    //         'parameter' => strip_tags($_GET["frequently_bought_together"])
    //     ],
        
    // ];

    foreach ($tracking_parameters as $tracking_parameter) { 
        $tracking_label = $tracking_parameter['label'];
        $tracking_value = $tracking_parameter['parameter'];
        if ($tracking_value) {
            if( !isset($_COOKIE[$tracking_label]) || $_COOKIE[$tracking_label] != $tracking_value ) {
                if ($tracking_label == 'utm_source' ) {
                    // set utm_source cookie for one day
                    setcookie($tracking_label, $tracking_value, time() + (24*3600), '/');
                } elseif ($tracking_label == 'utm_campaign' ) {
                    // set utm_campaign cookie for one day
                    setcookie($tracking_label, $tracking_value, time() + (24*3600), '/');
                } elseif ($tracking_label == 'utm_medium' ) {
                    // set utm_medium cookie for one day
                    setcookie($tracking_label, $tracking_value, time() + (24*3600), '/');
                } elseif ($tracking_label == 'affiliate' ) {
                    // Dont Set Cookie - Ryan is setting cookie for this in his affiliate redirect in functions.php
                } else {
                    //Default - Set Cookie for one year
                    setcookie($tracking_label, $tracking_value, time() + (24*3600*7), '/');
                }
            }
        }
    }
}
    
    add_action( 'woocommerce_order_status_on-hold', 'thankyou_grab_cookie_as_meta_data', 9, 1 );
    function thankyou_grab_cookie_as_meta_data( $order_id ) {
        if( ! $order_id ){
            return;
        } else {
            $order = wc_get_order($order_id);
            $order->add_order_note('Starting Affiliate Tracking');

            global $tracking_parameters;
            foreach ($tracking_parameters as $tracking_parameter) {
                $tracking_label = $tracking_parameter['label'];
                $tracking_value = $tracking_parameter['parameter'];
                if( isset($_COOKIE[$tracking_label]) && ! get_post_meta( $order_id, '_cookie_'.$tracking_label, true ) ) {
                    update_post_meta( $order_id, '_cookie_'.$tracking_label, esc_attr($_COOKIE[$tracking_label]) );
                }
                // Clear Cookies
                setcookie($tracking_label, '', time() - 3600, '/');
            }

            $order->add_order_note('Done Affiliate Tracking');
        }
    }
?>

*/