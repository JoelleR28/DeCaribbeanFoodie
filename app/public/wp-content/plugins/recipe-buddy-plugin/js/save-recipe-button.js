jQuery(document).ready(function($) {
    $('.save-recipe-button').on('click', function() {
        var post_id = $(this).data('post-id');
        var user_id = $(this).data('user-id');
        var save_button = $(this);
        
        $.ajax({
            type: 'POST',
            url: save_recipe_button_obj.ajax_url,
            data: {
                action: 'save_recipe_button_click',
                post_id: post_id,
                user_id: user_id,
            },
            success: function(response) {
                save_button.text(response);
            }
        });
    });
});
