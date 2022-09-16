jQuery(document).ready(function($) {
    jQuery(".install-pack-button").click(function(){
        var data = $(this).attr('class').split(' ')[1];
        jQuery.post(ajaxurl, { action: "plugin_pack_installer", data: data}, function() {
            if(jQuery('.install-pack-button').find('i').hasClass("fa-refresh fa-spin")) {
                jQuery('.install-pack-button').find('i').addClass("fa-download").removeClass("fa-refresh fa-spin");
                location.reload(true);
            }
        });
        if(jQuery(this).find('i').hasClass("fa-download")) {
            jQuery(this).find('i').addClass("fa-refresh fa-spin").removeClass("fa-download");
        }
        $('button').not(this).prop('disabled', true);
    });
})