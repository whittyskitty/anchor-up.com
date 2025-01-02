<!-- Footer: Newsletter -->
<div class="flex flex-row py-4 justify-center flex-wrap" style="background-color:<?= $theme_options['primary_theme_color'] ? $theme_options['primary_theme_color'] : ""; ?>">

    <?php if ($theme_options['newsletter_embed_code']) {
            echo $theme_options['newsletter_embed_code'];
     } ?>
    <?php /* OLD MAILCHIMP CODE
    <div class="flex px-4 text-2xl justify-center flex-col" style="max-width: 500px;">
        <h5>Subscribe to our monthly newsletter and stay up to date with all news and events.</h5>
    </div>
    <div class="px-4">
        <!-- Begin Mailchimp Signup Form -->
        <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7_dtp.css" rel="stylesheet" type="text/css">
        <style type="text/css">
            #mc_embed_signup {
                clear: left;
                font: 14px Helvetica, Arial, sans-serif;
                width: 600px;
            }

            // Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
			We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. // 
        </style>
        <div style="padding:0px; max-width:300px;" id="mc_embed_signup">
            <form style="padding:0px max-width:280px;" action="https://gmail.us9.list-manage.com/subscribe/post?u=c93a588a3bcfa02088f32dfa0&amp;id=150f23efb2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                <div id="mc_embed_signup_scroll">
                    <h2></h2>
                    <!-- <div class="indicates-required"><span class="asterisk">*</span> indicates required</div> -->
                    <div class="mc-field-group">
                        <label for="mce-EMAIL">Email Address <span class="asterisk">*</span>
                        </label>
                        <input type="email" value="" name="EMAIL" placeholder="email@example.com" class="required email" id="mce-EMAIL">
                    </div>
                    <div hidden="true"><input type="hidden" name="tags" value="12508151"></div>
                    <div id="mce-responses" class="clear foot">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div> <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_c93a588a3bcfa02088f32dfa0_150f23efb2" tabindex="-1" value=""></div>
                    <div class="optionalParent">
                        <div class="clear foot">
                            <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
                            <!-- <p class="brandingLogo"><a href="http://eepurl.com/h0SIgr" title="Mailchimp - email marketing made easy and fun"><img src="https://eep.io/mc-cdn-images/template_images/branding_logo_text_dark_dtp.svg"></a></p> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
        <script type='text/javascript'>
            (function($) {
                window.fnames = new Array();
                window.ftypes = new Array();
                fnames[0] = 'EMAIL';
                ftypes[0] = 'email';
                fnames[1] = 'FNAME';
                ftypes[1] = 'text';
                fnames[2] = 'LNAME';
                ftypes[2] = 'text';
                fnames[3] = 'ADDRESS';
                ftypes[3] = 'address';
                fnames[4] = 'PHONE';
                ftypes[4] = 'phone';
                fnames[5] = 'BIRTHDAY';
                ftypes[5] = 'birthday';
                fnames[6] = 'MMERGE6';
                ftypes[6] = 'text';
            }(jQuery));
            var $mcj = jQuery.noConflict(true);
        </script>
        <!--End mc_embed_signup-->
    </div>

    */ ?>
</div>

<!-- FOOTER -->

<div style="background-color:<?= $theme_options['primary_theme_color_hover']; ?>" class="py-12">
    <div class="mx-auto container px-4 flex flex-col justify-between items-center text-white text-3xl text-cener">
        <div style="align-items: center;" class="flex flex-col justify-center align-center">
            <?php if ($theme_options['site_logo']) {
                echo "<a class='flex justify-center' href='/'>";
                echo wp_get_attachment_image($theme_options['site_logo'], array(300, 60));
                echo "</a>";
            } else {
                echo AloeHelpers::front_end_error("Site Logo Not Set: <a style='color:blue;' href='/wp-admin/admin.php?page=acf-options'>SET IT HERE</a>");
            }

            echo "<div class='header-sm text-center mb-4 mt-8'>Contact Us</div>";

            // Contact Address
            if (isset($theme_options['address'])) {
                echo "<div class='header-sm text-center py-2'>" . $theme_options['address'] . "</div>";
            }

            // Contact Number
            if (isset($theme_options['contact_phone_number'])) {
                echo "<div class='header-sm text-center py-2'>" . $theme_options['contact_phone_number'] . "</div>";
            } 
            // else {
            //     echo AloeHelpers::front_end_error("Contact Phone Number Not Set: <a style='color:blue;' href='/wp-admin/admin.php?page=acf-options'>SET IT HERE</a>");
            // }

            // Contact Email
            if (isset($theme_options['contact_email'])) {
                echo "<div class='header-sm text-center py-2'>" . $theme_options['contact_email'] . "</div>";
            } 
            // else {
            //     echo AloeHelpers::front_end_error("Contact Email Not Set: <a style='color:blue;' href='/wp-admin/admin.php?page=acf-options'>SET IT HERE</a>");
            // }
            if (isset($theme_options['instagram_link']) && isset($theme_options['intragram_handle'])) {
                echo "<a target='_blank' class='header-sm py-2 flex flex-wrap justify-center mt-2' href='" . $theme_options['instagram_link'] . "'><span>" . $theme_options['intragram_handle'] . "</span><span class='pr-2'>" . $theme_options['hashtag'] . "</span></a>";
            } 
            // else {
            //     echo AloeHelpers::front_end_error("Site Instragram Details Not Set: <a style='color:blue;' href='/wp-admin/admin.php?page=acf-options'>SET IT HERE</a>");
            // }
            ?>
        </div>
    </div>
</div>