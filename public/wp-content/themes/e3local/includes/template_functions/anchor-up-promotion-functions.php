<?php

/**
 * Anchor Up Promotion Functions
 * Converted from AnchorUpPromotion class to standalone functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get the post type for anchor-up-promotion
 */
function anchor_up_promotion_get_post_type() {
    return 'anchor-up-promotion';
}

/**
 * Get the latest active anchor up promotion
 */
function anchor_up_promotion_get_latest() {
    $possible_active_posts = array(
        'post_type' => anchor_up_promotion_get_post_type(),
        'meta_query' => [
            array(
                'key'     => 'promotion_start_date',
                'value'   => date('Ymd'),
                'compare' => '<=',
            ),
            [
                'key'     => 'promotion_end_date',
                'value'   => date('Ymd'),
                'compare' => '>=',
            ],
        ],
        'orderby'    => 'meta_value_num',
        'order'      => 'ASC',
        'meta_key'   => 'promotion_start_date',
    );

    $posts = get_posts($possible_active_posts);

    if (isset($posts) && $posts) {
        return $posts[0];
    }

    return null;
}

/**
 * Get current promotion
 */
function anchor_up_promotion_get_current($return_just_id = false) {
    $current_post = anchor_up_promotion_get_latest();

    if ($current_post) {
        if ($return_just_id) {
            return $current_post->ID;
        } else {
            return $current_post;
        }
    }

    return null;
}

/**
 * Check if date is between marketing start date and promotional end date
 */
function anchor_up_promotion_is_date_between_marketing_and_end() {
    $current_promotion = anchor_up_promotion_get_current();

    if ($current_promotion) {
        $marketing_to_anchor_up_stores_start_date = strtotime(get_field('marketing_to_anchor_up_stores_start_date', $current_promotion->ID));
        $promotion_end_date = strtotime(get_field('promotion_end_date', $current_promotion->ID));
        $current_date = strtotime(date('Y-m-d'));

        if ($current_date >= $marketing_to_anchor_up_stores_start_date && $current_date <= $promotion_end_date) {
            return true;
        }
    }

    return false;
}

/**
 * Check if post is current promotion
 */
function anchor_up_promotion_is_post_current($post_id) {
    $current_promotion_id = anchor_up_promotion_get_current(true);
    if ($post_id == $current_promotion_id) {
        return true;
    }
    return false;
}

/**
 * Get archive anchor up promotions
 */
function anchor_up_promotion_get_archive_promotions() {
    $archive_posts = array(
        'post_type' => anchor_up_promotion_get_post_type(),
        'meta_query' => [
            [
                'key'     => 'promotion_end_date',
                'value'   => date('Ymd'),
                'compare' => '<=',
            ],
        ],
        'orderby'    => 'meta_value_num',
        'order'      => 'ASC',
        'meta_key'   => 'promotion_start_date',
    );

    $posts = get_posts($archive_posts);

    if (isset($posts) && $posts) {
        return $posts;
    }

    return null;
}

/**
 * Get archive promotions
 */
function anchor_up_promotion_get_archive() {
    $archive_posts = anchor_up_promotion_get_archive_promotions();

    if ($archive_posts) {
        return $archive_posts;
    }

    return null;
}

/**
 * Get promotion submission post from anchor account number and promotion id
 */
function anchor_up_promotion_get_submission_from_account_and_promotion($post_id) {
    $anchor_account_number = null;
    
    if (class_exists('\STW\AnchorUp\AnchorUp')) {
        $anchor_account_number = \STW\AnchorUp\AnchorUp::getAnchorAccountNumber();
    }
    
    if (!$anchor_account_number) {
        return null;
    }

    $args = array(
        'post_type' => 'promo-submission',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'anchor_account_number',
                'value' => $anchor_account_number,
                'compare' => '=',
            ),
            array(
                'key' => 'anchor_up_promotion_relationship',
                'value' => $post_id,
                'compare' => '=',
            ),
        ),
        'fields' => 'ids',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $return_post_id = get_the_ID();
            wp_reset_postdata();
        }
    }

    if (isset($return_post_id)) {
        return $return_post_id;
    }

    return null;
}

/**
 * Get anchor account number from post id
 */
function anchor_up_promotion_get_account_number_from_post($post_id) {
    $anchor_account_number = get_field('anchor_account_number', $post_id);
    return $anchor_account_number;
}

/**
 * Get digital assets for a promotion
 */
function anchor_up_promotion_get_digital_assets($post_id) {
    $assets = get_field('digital_assets', $post_id);
    
    if (!$assets) {
        return [];
    }
    
    // Convert to array of objects if needed
    return array_map(function($asset) {
        return (object)$asset;
    }, $assets);
}

/**
 * Check if Anchor Up Promotions are allowed on store
 * Always returns true - promotions are allowed on this site
 * 
 * @return bool
 */
function anchor_up_promotions_allowed_on_store() {
    return true;
}

/**
 * Convert YouTube URL to iframe embed URL
 * 
 * @param string $url YouTube URL
 * @return string YouTube video ID
 */
function anchor_up_convert_youtube_url_to_iframe_url($url) {
    // Extract video ID from various YouTube URL formats
    $patterns = [
        '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/',
        '/youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]+)/',
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
    }
    
    // If no match, return the URL as-is (might already be an ID)
    return $url;
}

/**
 * Get Tailwind class helper (tw function)
 * 
 * @param string $type Type of class (h1, h2, h3, button, etc.)
 * @return string Tailwind classes
 */
function tw($type = '') {
    $classes = [
        'h1' => 'text-3xl font-bold mb-4',
        'h2' => 'text-2xl font-bold mb-3',
        'h3' => 'text-xl font-bold mb-2',
        'button' => 'bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded inline-block',
    ];
    
    return isset($classes[$type]) ? $classes[$type] : '';
}

/**
 * Post data to Airtable
 * Standalone function extracted from STW\Airtable\Airtable class
 * 
 * @param array $data Data to post to Airtable
 * @param string $key Airtable table key (anchor_up_foot_traffic_stores or connection_plus)
 * @return mixed Response from Airtable API
 */
function anchor_up_airtable_post_data($data, $key = false) {
    if (!$key) {
        return false;
    }
    
    // Airtable URL configurations (without API key - using Personal Access Token in header)
    $airtable_configs = [
        'anchor_up_foot_traffic_stores' => 'https://api.airtable.com/v0/app5k1gf1ZiwgTli8/Anchor%20Up%20Program?view=STW%20Code%20View%20-%20Do%20Not%20Edit%20Name',
        'connection_plus' => 'https://api.airtable.com/v0/app5k1gf1ZiwgTli8/Connection%20Plus?view=Shoptheword%20Code%20View%20-%20Do%20Not%20Delete',
    ];
    
    // Get Airtable URL from config or direct mapping
    $airtable_url = '';
    if (function_exists('stw_config')) {
        $airtable_url = stw_config('airtable.' . $key);
        // Remove API key from URL if present (for backward compatibility)
        $airtable_url = preg_replace('/[&?]api_key=[^&]*/', '', $airtable_url);
    } elseif (defined('AIRTABLE_CONFIG') && is_array(AIRTABLE_CONFIG) && isset(AIRTABLE_CONFIG[$key])) {
        $airtable_url = AIRTABLE_CONFIG[$key];
        // Remove API key from URL if present
        $airtable_url = preg_replace('/[&?]api_key=[^&]*/', '', $airtable_url);
    } elseif (isset($airtable_configs[$key])) {
        $airtable_url = $airtable_configs[$key];
    }
    
    if (!$airtable_url) {
        error_log('Airtable POST Error: No URL found for key: ' . $key);
        return false;
    }
    
    // Get Personal Access Token (preferred) or fall back to API key for backward compatibility
    $airtable_token = '';
    if (isset($_ENV['AIRTABLE_PERSONAL_ACCESS_TOKEN']) && !empty($_ENV['AIRTABLE_PERSONAL_ACCESS_TOKEN'])) {
        $airtable_token = $_ENV['AIRTABLE_PERSONAL_ACCESS_TOKEN'];
    } elseif (isset($_ENV['AIRTABLE_API_KEY']) && !empty($_ENV['AIRTABLE_API_KEY'])) {
        // Fallback to API key for backward compatibility (will show deprecation warning)
        $airtable_token = $_ENV['AIRTABLE_API_KEY'];
        error_log('Airtable Warning: Using deprecated API key. Please migrate to Personal Access Token (AIRTABLE_PERSONAL_ACCESS_TOKEN)');
    }
    
    if (!$airtable_token) {
        error_log('Airtable POST Error: AIRTABLE_PERSONAL_ACCESS_TOKEN or AIRTABLE_API_KEY not set in environment');
        return false;
    }
    
    // Prepare records payload
    $records = [
        'records' => [
            [
                'fields' => $data
            ]
        ]
    ];
    
    // Headers for the API request - use Bearer token authentication
    $headers = [
        'Authorization' => 'Bearer ' . $airtable_token,
        'Content-Type'  => 'application/json',
    ];
    
    // Log request details
    error_log('=== Airtable POST Request ===');
    error_log('Table Key: ' . $key);
    error_log('URL: ' . $airtable_url);
    error_log('Using Token: ' . (isset($_ENV['AIRTABLE_PERSONAL_ACCESS_TOKEN']) ? 'Personal Access Token' : 'API Key (deprecated)'));
    error_log('Data: ' . json_encode($data, JSON_PRETTY_PRINT));
    
    // Make POST request to Airtable
    // Check if GuzzleHttp is available
    if (class_exists('\GuzzleHttp\Client')) {
        $client = new \GuzzleHttp\Client();
        
        try {
            $response = $client->post($airtable_url, [
                'headers' => $headers,
                'json'    => $records,
            ]);
            
            // Log response details
            $status_code = $response->getStatusCode();
            $response_body = $response->getBody()->getContents();
            $response_data = json_decode($response_body, true);
            
            error_log('=== Airtable POST Response (Guzzle) ===');
            error_log('Status Code: ' . $status_code);
            error_log('Response Body: ' . $response_body);
            error_log('Response Data: ' . json_encode($response_data, JSON_PRETTY_PRINT));
            
            // Output to browser console if possible
            if (!headers_sent()) {
                echo '<script>console.log("Airtable POST Response:", ' . json_encode([
                    'status_code' => $status_code,
                    'response' => $response_data,
                    'table_key' => $key
                ]) . ');</script>';
            }
            
            return $response;
        } catch (\Exception $e) {
            error_log('=== Airtable POST Error (Guzzle) ===');
            error_log('Error Message: ' . $e->getMessage());
            error_log('Error Trace: ' . $e->getTraceAsString());
            
            // Output to browser console
            if (!headers_sent()) {
                echo '<script>console.error("Airtable POST Error:", ' . json_encode([
                    'error' => $e->getMessage(),
                    'table_key' => $key
                ]) . ');</script>';
            }
            
            return false;
        }
    } else {
        // Fallback to WordPress HTTP API if GuzzleHttp is not available
        $response = wp_remote_post($airtable_url, [
            'headers' => $headers,
            'body' => json_encode($records),
            'timeout' => 30,
        ]);
        
        if (is_wp_error($response)) {
            error_log('=== Airtable POST Error (WP HTTP) ===');
            error_log('Error Message: ' . $response->get_error_message());
            error_log('Error Code: ' . $response->get_error_code());
            
            // Output to browser console
            if (!headers_sent()) {
                echo '<script>console.error("Airtable POST Error:", ' . json_encode([
                    'error' => $response->get_error_message(),
                    'error_code' => $response->get_error_code(),
                    'table_key' => $key
                ]) . ');</script>';
            }
            
            return false;
        }
        
        // Log response details
        $status_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);
        
        error_log('=== Airtable POST Response (WP HTTP) ===');
        error_log('Status Code: ' . $status_code);
        error_log('Response Body: ' . $response_body);
        error_log('Response Data: ' . json_encode($response_data, JSON_PRETTY_PRINT));
        
        // Output to browser console
        if (!headers_sent()) {
            echo '<script>console.log("Airtable POST Response:", ' . json_encode([
                'status_code' => $status_code,
                'response' => $response_data,
                'table_key' => $key
            ]) . ');</script>';
        }
        
        return $response;
    }
}

/**
 * Send email via SendGrid
 * Standalone function extracted from STW\Email\SendGrid class
 * 
 * @param string $from_address Sender email address
 * @param string $from_name Sender name
 * @param string $to_addresses Recipient email address(es)
 * @param string $template_id SendGrid template ID
 * @param array $data Dynamic template data
 * @param bool $is_wh1 Whether to use Whitaker House subuser API key
 * @return mixed Response from SendGrid API or false on error
 */
function anchor_up_sendgrid_send_email($from_address, $from_name, $to_addresses, $template_id, $data = [], $is_wh1 = false) {
    // Check if SendGrid classes are available
    if (!class_exists('\SendGrid\Mail\Mail') || !class_exists('\SendGrid')) {
        error_log('SendGrid classes not available');
        return false;
    }
    
    // Get API key from environment
    $sendgrid_api_key = '';
    if ($is_wh1 && isset($_ENV['SENDGRID_WH1_APIKEY'])) {
        $sendgrid_api_key = $_ENV['SENDGRID_WH1_APIKEY'];
    } elseif (isset($_ENV['SENDGRID_APIKEY'])) {
        $sendgrid_api_key = $_ENV['SENDGRID_APIKEY'];
    }
    
    if (!$sendgrid_api_key) {
        error_log('SendGrid API key not found in environment variables');
        return false;
    }
    
    // Log request details
    error_log('=== SendGrid Email Request ===');
    error_log('From: ' . $from_name . ' <' . $from_address . '>');
    error_log('To: ' . $to_addresses);
    error_log('Template ID: ' . $template_id);
    error_log('Is WH1: ' . ($is_wh1 ? 'Yes' : 'No'));
    error_log('Template Data: ' . json_encode($data, JSON_PRETTY_PRINT));
    
    try {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($from_address, $from_name);
        $email->addTo($to_addresses);
        $email->setTemplateId($template_id);
        
        // Add dynamic template data
        foreach ($data as $key => $value) {
            $email->addDynamicTemplateData($key, $value);
        }
        
        // Optional: Add ASM (Advanced Suppression Management) if configured
        // $asm_group_id = function_exists('stw_config') ? stw_config('sendgrid.asm_group_id') : null;
        // if ($asm_group_id && class_exists('\SendGrid\Mail\Asm')) {
        //     $asm = new \SendGrid\Mail\Asm();
        //     $asm->setGroupId($asm_group_id);
        //     $email->setASM($asm);
        // }
        
        $sendgrid = new \SendGrid($sendgrid_api_key);
        $response = $sendgrid->send($email);
        
        // Log response details
        $status_code = $response->statusCode();
        $response_headers = $response->headers();
        $response_body = $response->body();
        
        error_log('=== SendGrid Email Response ===');
        error_log('Status Code: ' . $status_code);
        error_log('Response Headers: ' . json_encode($response_headers, JSON_PRETTY_PRINT));
        error_log('Response Body: ' . $response_body);
        
        // Output to browser console
        if (!headers_sent()) {
            echo '<script>console.log("SendGrid Email Response:", ' . json_encode([
                'status_code' => $status_code,
                'headers' => $response_headers,
                'body' => $response_body,
                'from' => $from_address,
                'to' => $to_addresses,
                'template_id' => $template_id
            ]) . ');</script>';
        }
        
        return $response;
        
    } catch (\Exception $e) {
        error_log('=== SendGrid Email Error ===');
        error_log('Error Message: ' . $e->getMessage());
        error_log('Error Trace: ' . $e->getTraceAsString());
        
        // Output to browser console
        if (!headers_sent()) {
            echo '<script>console.error("SendGrid Email Error:", ' . json_encode([
                'error' => $e->getMessage(),
                'from' => $from_address,
                'to' => $to_addresses,
                'template_id' => $template_id
            ]) . ');</script>';
        }
        
        return false;
    }
}

