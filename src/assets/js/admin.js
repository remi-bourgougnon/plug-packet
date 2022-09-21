jQuery(document).ready(function($) {
    jQuery(".plp-install-pack-button").click(function(){ //when one of the plugin packs button is clicked, the function executes
        var data = $(this).attr('class').split(' ')[1]; //jquery gets the second class of the button which was clicked. it contains the name of the plugin pack
        jQuery.post(ajaxurl, { action: "plp_pack_installer", data: data}, function() { //uses ajax to execute the 'plugin_pack_installer' function from the admin.php page. It also sends button class retrieved earlier
            if(jQuery('.plp-install-pack-button').find('i').hasClass("fa-refresh fa-spin")) { //if the button icon is a spinning arrrow
                jQuery('.plp-install-pack-button').find('i').addClass("fa-download").removeClass("fa-refresh fa-spin"); //it changes the button icon and reloads the page.
                location.reload(true);
            }
        });
        if(jQuery(this).find('i').hasClass("fa-download")) {
            jQuery(this).find('i').addClass("fa-refresh fa-spin").removeClass("fa-download");
        }
        $('button').not(this).prop('disabled', true); //disables every button after one is clicked.
    });
})