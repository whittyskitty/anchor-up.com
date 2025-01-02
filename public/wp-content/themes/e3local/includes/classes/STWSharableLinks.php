<?php

class STWSharableLinks
{

    public static $sharable_links_table = 'stw_sharable_links_table';

    public static $utm_internal_id_tracking_parameter_key = 'utm_internal_id';

    // Tests Needed:
    /*
    - Button Should Only Show Admin's And Marketing User Roles Can Create these Custom Shareable Links
    - After Clicking the Button, A div should appear that shows 3 input boxes, Utm_campaign, Utm_source, Utm_medium
    - After Typing Values in each input box, auto create link
    - When you click the link - auto copy to clipboard with Button for Auto Copy to Clipboard
*/


    // Still need -> Check if utm_campaign already exists in table for that SPECIFIC USER, it so alert
    // Need to Allow for Permissions -> Administrator, Shop Managers, Markets

    public static function init_hooks()
    {

        // Add simple_role capabilities, priority must be after the initial role definition.
        // add_action( 'init', function() {
        //     // Gets the simple_role role object.
        //     $role = get_role( 'administrator' );

        //     // Add a new capability.
        //     $role->add_cap( 'create_sharable_utm_parameters', true );
        // }, 10);


        if (current_user_can('administrator')) {
            // php POST Function = public/wp-content/themes/shop-the-word/page-admin_utm_form_creator.php

            add_action('tailpress_footer', 'create_sharable_link_html', 10, 0);
            function create_sharable_link_html()
            {
                global $theme_options;
                // action="/admin_utm_form_creator" 

                $variables = [
                    'share_utm_campaign' => [
                        'UTM Campaign',
                        'required'
                    ],
                    'share_utm_source' => [
                        'UTM Source'
                    ],
                    'share_utm_medium' => [
                        'UTM Medium'
                    ],

                    'share_utm_term' => [
                        'UTM Term'
                    ],
                    'share_utm_content' => [
                        'UTM Campaign'
                    ]
                ]
?>
                <style>
                    #admin_utm_form_creator div {
                        display: flex;
                        align-items: center;
                        max-width: 300px;
                        padding-bottom: 5px;
                        justify-content: space-between;
                    }
                </style>
                <a style="background-color:<?= $theme_options['secondary_theme_color']; ?>" class="fixed p-4 text-white z-10 left-0 bottom-0 toggle_admin_utm_sharing font-bold cursor-pointer">UTM ></a>
                <div id="admin_utm_form_div" style="display:none; position: fixed; bottom: 0px; left: 0px; background-color: white; border: 2px solid black; padding: 40px; max-width: 420px;">
                    <form id="admin_utm_form_creator" method="post">
                        <div class="text-lg">Viewable as Admin Only</div>
                        <?php foreach ($variables as $key => $variable) {
                            if ($variable) { ?>
                                <div>
                                    <label><?= $variable[0]; ?></label>
                                    <input class="border p-1 ml-1" type="text" <?= $variable[1]; ?> name="<?= $key; ?>">
                                </div>
                        <?php 
                            }
                        } ?>
                        <button type="submit" class="button button-sm mt-2 bg-blue-400 text-white p-2">Create Trackable Link</button>
                    </form>
                    <a href="https://blog.hootsuite.com/how-to-use-utm-parameters/" target="_blank" class="py-2 mb-2 block text-blue-300">Learn More About UTM Marketing Tracking Parameters</a>
                    <div style="display:none;" id="sharable_link_form_results">
                        <?= STWHelpers::copy_link_to_clipboard_html('', TRUE); ?>
                        <a href="/my-account/" class="block text-blue-400 mb-4 block">View My Account's UTM Links and Results</a>
                    </div>
                </div>
            <?php
            }

            add_action('after_tailpress_footer', function () { ?>
                <style>
                    /* Sharable Links */
                    .click_link {
                        margin: 10px 0px;
                        padding-bottom: 1px;
                    }

                    .click_link .copy {
                        display: none;
                    }

                    .click_link .copy {
                        background-color: rgba(8, 72, 114, .86);
                        margin-top: 1px;
                        border-radius: 12px;
                        position: absolute;
                        margin-top: -2px;
                        cursor: pointer;
                        color: white;
                        text-align: center;
                        justify-content: center;
                        align-items: center;
                        height: 100%;
                        width: 100%;
                    }

                    .click_link p {
                        padding: 15px 10px;
                        background-color: white;
                        border: 1px solid gray;
                        border-radius: 12px;
                    }

                    .click_link:hover .copy {
                        display: flex;
                    }

                    .click_link .copied {
                        background-color: rgb(24 109 17 / 90%);
                    }
                </style>
                <script>
                    jQuery().ready(function($) {
                        // Sharable Links -> Only works for Admins Here
                        $(".click_link .copy").click(function(event) {
                            var $tempElement = $("<input>");
                            $("body").append($tempElement);
                            $tempElement.val($(this).closest(".click_link").find("p").text()).select();
                            document.execCommand("Copy");
                            $tempElement.remove();
                            var copy = $(this).closest(".click_link").find('.copy');
                            copy.addClass('copied').text('Copied');
                            setTimeout(function() {
                                copy.removeClass('copied').text('Copy Link');
                            }, 2000);
                        });

                        $('.toggle_admin_utm_sharing').click(function(e) {
                            $(this).html('UTM <');
                            $('#admin_utm_form_div').toggle();
                        });
                        $("#admin_utm_form_creator").submit(function(event) {
                            var self = $(this);
                            var utm_campaign = $("input[name=share_utm_campaign]").val();
                            var utm_source = $("input[name=share_utm_source").val();
                            var utm_medium = $("input[name=share_utm_medium").val();
                            var utm_term = $("input[name=share_utm_term").val();
                            var utm_content = $("input[name=share_utm_content").val();
                            var results_div = $('#sharable_link_form_results');
                            var sharable_link;
                            $.post('/admin_utm_form_creator', {
                                utm_campaign,
                                utm_source,
                                utm_medium,
                                utm_term,
                                utm_content
                            }, function(response) {
                                sharable_link = response;
                                self.fadeOut();
                                setTimeout(function() {
                                    results_div.fadeIn();
                                }, 500);
                                results_div.find('.ajax-link-div-holder').html(sharable_link);
                            });
                            event.preventDefault();
                        });
                    });
                </script>
            <?php
            });

            // ACCOUNT PAGE HOOKS

            // Add to Account Menu
            add_filter('woocommerce_account_menu_items',  function ($items) {
                $items['sharable-utm-links'] = __('Sharable UTM Marketing Links', 'shoptheword');
                return $items;
            }, 10, 1);

            //add endpoint for sharable-utm-links

            // NOT WORKING
            add_action('init', function () {
                add_rewrite_endpoint('sharable-utm-links', EP_PAGES);
            });

            //sharable-utm-links content
            // add_action('woocommerce_account_sharable-utm-links_endpoint', 
            add_action('woocommerce_account_dashboard', function () {
                self::sharable_utm_links_content_page();
            }, 30);
        }
    }

    public static function sharable_utm_links_content_page()
    {
        $current_user = wp_get_current_user();

        $user_id = $current_user->ID;

        // $links = self::getUtmLinks($user_id);

        $linksWithOrderData = self::getUtmLinksWithOrderData($user_id);

        if (!$linksWithOrderData) {
            echo "No Orders Found";
        } else {
            ?>

            <?php
            do_action('stw_before_sharable_utm_links');
            ?>

            <h1>Your Sharable UTM Marketing Links: (Admin Only)</h1>
            <div class="mt-4 mb-2" style="overflow-x:auto;">
                <table class="shipping-table">
                    <thead>
                        <tr>
                            <?php foreach ($linksWithOrderData[0] as $key => $value) { ?>
                                <th><?= $key; ?></th>
                            <?php
                            } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($linksWithOrderData as $link) { ?>
                            <tr>
                                <?php
                                foreach ($link as $key => $value) { ?>
                                    <td>
                                        <?php
                                        if ($key == 'URL') {
                                            STWHelpers::copy_link_to_clipboard_html($value);
                                        } else {
                                            echo $value;
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                ?>
                            </tr>
                        <?php
                        } ?>

                    </tbody>
                </table>
                <style>
                    .shipping-table {
                        border: 1px solid;
                        width: 100%;
                        margin: auto;
                        text-align: center;
                    }

                    @media(max-width:700px) {
                        .shipping-table {
                            width: 700px;
                        }
                    }

                    .shipping-table tr:nth-child(even),
                    .shipping-table thead tr {
                        background-color: #cccccc;
                    }

                    .free-method {
                        color: #039403;
                    }

                    .shipping-table th {
                        padding: 0px 20px;
                    }
                </style>
            </div>
            <script>
                jQuery().ready(function($) {
                    $('.wishlist-products .product-result').each(function() {
                        $(this).append('<div rel="' + $(this).attr('id') + '" class="wishlist-remove cursor-pointer absolute top-0 right-0 w-8 h-8 p-2 rounded-full bg-gray-200 border-2 shadow border-white flex justify-center content-center align-middle items-center"><div class="text-shop-the-word-red font-bold">X</div></div>');
                    });

                    $(".wishlist-remove").on('click', function() {
                        var productId = $(this).attr('rel');
                        var self = $(this);
                        $.post('/', {
                            remove_from_wishlist: productId
                        }, function(response) {
                            self.parents('li').fadeOut();
                        });

                    })
                });
            </script>
<?php
        }
    }

    public static function create_sharable_link($user_id, $utm_campaign, $utm_source = '', $utm_medium = '', $utm_term = '', $utm_content = '')
    {
        self::ensureTableExists();

        $site_url = $_SERVER['HTTP_HOST'];

        $url = strtok($_SERVER['HTTP_REFERER'], '?');

        $slug = str_replace('https://' . $site_url, '', $url);


        $url_query_string = STWHelpers::checkQueryStringOnUrl($url);

        $table = self::$sharable_links_table;

        global $wpdb;

        $insert = $wpdb->insert($table, [
            'user_id' => $user_id,
            'site_url' => $site_url,
            'slug' => $slug,
            'utm_campaign' => trim($utm_campaign),
            'utm_source' => trim($utm_source),
            'utm_medium' => trim($utm_medium),
            'utm_term' => trim($utm_term),
            'utm_content' => trim($utm_content),
            'original_url' => $url,
            'date_created' => date("Y-m-d"),
        ]);

        $insert_id = $wpdb->insert_id;

        $sharable_url = self::createSharableLinkStructureFromRecord($insert_id);
        $sharable_url = str_replace(' ', '%20', $sharable_url);
        return $sharable_url;
    }

    public static function createSharableLinkStructureFromRecord($utm_internal_id)
    {
        global $wpdb;
        $query = "SELECT * FROM " . self::$sharable_links_table . " where id = $utm_internal_id";

        $link = $wpdb->get_results($query)[0];

        $sharable_url = 'https://' . $link->site_url . $link->slug . '?utm_campaign=' . $link->utm_campaign . ($link->utm_source ? '&utm_source=' . $link->utm_source : '') . ($link->utm_medium ? '&utm_medium=' . $link->utm_medium : '') . ($link->utm_term ? '&utm_term=' . $link->utm_term : '') . ($link->utm_content ? '&utm_content=' . $link->utm_content : '' . '&' . self::$utm_internal_id_tracking_parameter_key . '=' . $utm_internal_id);

        return $sharable_url;
    }

    public static function ensureTableExists()
    {
        global $wpdb;
        $table_query = "SHOW TABLES LIKE '" . self::$sharable_links_table . "'";
        $table_exists = $wpdb->get_results($table_query);
        if (count($table_exists) == 0) {
            $create_query = "CREATE TABLE `" . self::$sharable_links_table . "` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` varchar(255) DEFAULT NULL,
            `site_url` varchar(255) DEFAULT NULL,
            `slug` varchar(255) DEFAULT NULL,
            `utm_campaign` varchar(255) DEFAULT NULL,
            `utm_medium` varchar(255) DEFAULT NULL,
            `utm_source` varchar(255) DEFAULT NULL,
            `utm_term` varchar(255) DEFAULT NULL,
            `utm_content` varchar(255) DEFAULT NULL,
            `original_url`varchar(255) DEFAULT NULL,
            `sharable_url`varchar(255) DEFAULT NULL,
            `date_created` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `id` (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;";

            $wpdb->query($create_query);
        }
    }

    public static function getUtmLinks($user_id)
    {
        $table = self::$sharable_links_table;

        global $wpdb;

        $query = "SELECT id, utm_campaign, utm_medium, utm_source, utm_term, utm_content, sharable_url as 'URL', date_created as 'Date Created' from $table where user_id = $user_id";

        $results = $wpdb->get_results($query);

        return $results;
    }

    public static function getUtmLinksWithOrderData($user_id)
    {

        global $wpdb;

        $links = self::getUtmLinks($user_id);

        $link_data_with_order_info = [];

        // Loop Through Each of the Users Links
        foreach ($links as $link) {
            $order_ids = '';
            $number_of_orders_from_link = 0;
            $total_of_orders_from_link = 0;

            // Get POST IDs Associated to Users Link ID from utm_internal_id
            $query = "SELECT post_id FROM " . $wpdb->postmeta . " where meta_key='_cookie_utm_internal_id' AND meta_value=$link->id";
            $order_ids = $wpdb->get_results($query);

            foreach ($order_ids as $order) {
                $total = 0;
                $number_of_orders_from_link++;
                $order_id = $order->ID;
                $wc_order =  wc_get_order($order->post_id);
                $total = $wc_order->data['total'];
                $total_of_orders_from_link += $total;
            }

            $order_data = (object) [
                '# of Orders' => $number_of_orders_from_link,
                'Total' => '$' . $total_of_orders_from_link
            ];

            $url_array = [
                'URL' => self::createSharableLinkStructureFromRecord($link->id)
            ];


            $obj_merged = (object) array_merge((array) $link, (array) $order_data);

            $obj_merged = (object) array_merge((array) $obj_merged, (array) $url_array);

            $link_data_with_order_info[] = $obj_merged;
        }
        return $link_data_with_order_info;
    }
}

STWSharableLinks::init_hooks();
