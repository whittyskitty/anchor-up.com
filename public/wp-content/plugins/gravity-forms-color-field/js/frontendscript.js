jQuery(document).ready(function ($) {

    jQuery(document).on('gform_post_render', function(){
 
        // code to trigger on AJAX form render
        $('.advanced-color').ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).val(hex);
                $(el).css('backgroundColor', '#' + hex);
                $(el).ColorPickerHide();
            },
            onChange: function (hsb, hex, rgb, el) {
                // $(el).css('backgroundColor', '#' + hex);
                $(el).css('backgroundColor', '#' + hex);
            },
            onBeforeShow: function () {
                $(this).ColorPickerSetColor(this.value);
            }
        })
        .bind('keyup', function(){
            $(this).ColorPickerSetColor(this.value);
        });

        //re-initialise jscolor
        jscolor.installByClassName("jscolor");
 
    });    
    
});