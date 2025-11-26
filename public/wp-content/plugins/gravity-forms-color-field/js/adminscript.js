jQuery(document).ready(function ($) {


    //when clicking save settings clear the update cache
    $("#tab_gravity-forms-color-field #gform-settings-save").click(function (event) {
        event.preventDefault();

        deletepluginupdatetransient();

        $(this).unbind('click').click();

    });    


    function deletepluginupdatetransient(){
        //_site_transient_update_plugins

        var data = {
            'action': 'color_field_delete_plugin_updates_transient',
        };

        jQuery.post(ajaxurl, data, function (response) {
            // console.log('HELLO WORLD');
        });    
    }
    
    
    
});