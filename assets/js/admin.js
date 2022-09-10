jQuery(document).ready(function($) {
    $.getJSON( json_url.jsonurl, function( data ) {
        console.log(data.pack1);
        console.log(data.pack2);
    });


    jQuery(".install-pack-button").click(function(){
        jQuery.post(ajaxurl, { action: "plugin_pack_installer"}, function() {
            if(jQuery('.install-pack-button').find('i').hasClass("fa-refresh fa-spin")) {
                jQuery('.install-pack-button').find('i').addClass("fa-download").removeClass("fa-refresh fa-spin");
            }
        });
        if(jQuery(this).find('i').hasClass("fa-download")) {
            jQuery(this).find('i').addClass("fa-refresh fa-spin").removeClass("fa-download");
        }
    });
})