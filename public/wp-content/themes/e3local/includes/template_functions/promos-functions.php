<?php

/**
 * Promos Functions
 * Converted from STW\Promos\Promos class to standalone functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register all promos (active and product promos)
 * 
 * @param mixed $store Store object (optional, kept for compatibility)
 * @return array Merged array of active promos and product promos
 */
function promos_register($store = null) {
    return array_merge(promos_get_product_promos(), promos_get_active_promos());
}

/**
 * Get active promos from Active directory
 * 
 * @return array Array of promo objects from Active directory
 */
function promos_get_active_promos() {
    // Try to find the Active directory relative to this file
    $active_dir = __DIR__ . '/../classes/Promos/Active';
    
    // If that doesn't exist, try other possible locations
    if (!file_exists($active_dir)) {
        $active_dir = get_template_directory() . '/includes/classes/Promos/Active';
    }
    
    if (!file_exists($active_dir)) {
        $active_dir = get_template_directory() . '/classes/Promos/Active';
    }
    
    $promos = [];
    
    if (file_exists($active_dir)) {
        $files = glob($active_dir . '/*.php');
        
        if ($files) {
            foreach ($files as $file) {
                $classname = basename(str_replace('.php', '', $file));
                $full_classpath = "\\STW\\Promos\\Active\\" . $classname;
                
                // Only instantiate if class exists
                if (class_exists($full_classpath)) {
                    $promos[$classname] = new $full_classpath;
                }
            }
        }
    }
    
    return $promos;
}

/**
 * Get product promos from database
 * 
 * @return array Array of promo objects based on product promotions post type
 */
function promos_get_product_promos() {
    $promos = [];
    
    global $wpdb;
    
    // Use WordPress table prefix
    $table_name = $wpdb->posts;
    $sql = $wpdb->prepare(
        "SELECT ID FROM {$table_name} WHERE post_type = %s AND post_status = %s",
        'product-promotions',
        'publish'
    );
    
    $results = $wpdb->get_results($sql);
    
    if (!$results) {
        return $promos;
    }
    
    foreach ($results as $result) {
        $id = $result->ID;
        
        // Get postmeta promotion_type
        $promotion_type = get_post_meta($id, 'promotion_type', true);
        $trigger_product = get_post_meta($id, 'product_id', true);
        $text_on_item_that_triggered_promotion = get_post_meta($id, 'text_on_item_that_triggered_promotion', true);
        
        $promo = null;
        
        if ($promotion_type == "Discount Based on Quantity Purchased") {
            // Check if class exists before instantiating
            if (class_exists('QtyBasedDiscountPromo')) {
                $promo = new QtyBasedDiscountPromo();
                $promo->stw_id_of_product = $trigger_product;
                $promo->qty_necessary_for_discount = get_post_meta($id, 'qty_necessary_for_discount', true);
                $promo->discount_amount_off_retail = get_post_meta($id, 'discount_amount_off_retail', true);
                $promo->text_on_item_that_triggered_promotion = $text_on_item_that_triggered_promotion;
            }
        } elseif ($promotion_type == "Free Product With Purchase of Specific Product") {
            // Check if class exists before instantiating
            if (class_exists('FreeProductWithPurchaseOfProductPromo')) {
                $promo = new FreeProductWithPurchaseOfProductPromo();
                $promo->stw_product_id_necessary_for_free_product = $trigger_product;
                $promo->free_product_stw_product_id = get_post_meta($id, 'free_product_id_added_to_cart', true);
                $promo->text_on_free_item_in_cart = get_post_meta($id, 'text_on_free_item_in_cart', true);
                $promo->text_on_free_item_product_page = get_post_meta($id, 'text_on_free_item_product_page', true);
                $promo->text_on_item_that_triggered_promotion = $text_on_item_that_triggered_promotion;
            }
        } elseif ($promotion_type == "Free Pdf With Purchase Of Product") {
            // Check if class exists before instantiating
            if (class_exists('FreePdfWithPurchaseOfProductPromo')) {
                $promo = new FreePdfWithPurchaseOfProductPromo();
                $promo->stw_product_id_necessary_for_free_product = $trigger_product;
                $promo->free_pdf_url = get_post_meta($id, 'free_pdf_url', true);
                $promo->free_pdf_email_text = get_post_meta($id, 'free_pdf_email_text', true);
                $promo->text_on_item_that_enabled_free_item_in_cart = get_post_meta($id, 'text_on_item_that_enabled_free_item_in_cart', true);
                $promo->text_on_item_that_triggered_promotion = $text_on_item_that_triggered_promotion;
            }
        }
        
        // Only add promo if it was successfully created
        if ($promo) {
            $promos[$id] = $promo;
        }
    }
    
    return $promos;
}

