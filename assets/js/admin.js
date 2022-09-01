jQuery(document).ready(function($) {
    jQuery(".install-pack-button").click(function(){
        jQuery.post(ajaxurl, { action: "plugin_pack_installer"}, null);
    });
})