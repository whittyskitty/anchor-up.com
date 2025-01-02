<?php 
class STWHelpers {

    public static function checkQueryStringOnUrl($url){
        $tracking_link_append_query_indicator = "?";

        if (!is_string($url) ){
            return $tracking_link_append_query_indicator;
        }

        if (strpos($url, '?') !== false) {
            $tracking_link_append_query_indicator = "&";
        }
        return $tracking_link_append_query_indicator;
    }

    
    public static function copy_link_to_clipboard_html($url, $return_just_wrapper_with_no_link=FALSE) { ?>
        <div class="click_link relative">
        <div class="copy">Copy Link</div>
        <?php if (!$return_just_wrapper_with_no_link) { ?>
            <p class="block pt-2 pb-4 text-shop-the-word-blue" target="_blank" href="<?= $url;?>"><?= $url;?></p>
        <?php } else { ?>
            <p class="ajax-link-div-holder overflow-hidden"></p>
            <?php 
        } ?>
    </div>
    <?php 
    }
}