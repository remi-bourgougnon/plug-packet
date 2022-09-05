jQuery(document).ready(function($) {
    jQuery(".install-pack-button").click(function(){
        jQuery.post(ajaxurl, { action: "plugin_pack_installer"}, function() {
            if(jQuery('.install-pack-button').find('i').hasClass("fa-refresh fa-spin")) {
                jQuery('.install-pack-button').find('i').addClass("fa-download").removeClass("fa-refresh fa-spin");
                jQuery('.install-pack-button').css('display', 'none');
                jQuery('.remove-pack-button').css('display', 'inline-block');
                localStorage.setItem('button_clicked', '1');
            }
        });
        if(jQuery(this).find('i').hasClass("fa-download")) {
            jQuery(this).find('i').addClass("fa-refresh fa-spin").removeClass("fa-download");
        }
    });

    jQuery(".remove-pack-button").click(function(){
        jQuery.post(ajaxurl, { action: "plugin_pack_uninstaller"}, function() {
            if(jQuery('.remove-pack-button').find('i').hasClass("fa-refresh fa-spin")) {
                jQuery('.remove-pack-button').find('i').addClass("fa-trash").removeClass("fa-refresh fa-spin");
                jQuery('.install-pack-button').css('display', 'inline-block');
                jQuery('.remove-pack-button').css('display', 'none');
                localStorage.setItem('button_clicked', '0');
            }
        });
        if(jQuery('.remove-pack-button').find('i').hasClass("fa-trash"))
            jQuery('.remove-pack-button').find('i').addClass("fa-refresh fa-spin").removeClass("fa-trash");
    });

    if(localStorage.getItem('button_clicked') === '1')
    {
        jQuery('.install-pack-button').css('display', 'none');
        jQuery('.remove-pack-button').css('display', 'inline-block');
    }

    else if(localStorage.getItem('button_clicked') === '0')
    {
        jQuery('.install-pack-button').css('display', 'inline-block');
        jQuery('.remove-pack-button').css('display', 'none');
    }
})