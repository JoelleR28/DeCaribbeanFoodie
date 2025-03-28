jQuery(document).ready(function($) {
    $('.like-button').on('click', function() {
        var post_id = $(this).data('post-id');
        var like_button = $(this);
        
        $.ajax({
            type: 'POST',
            url: like_button_obj.ajax_url,
            data: {
                action: 'like_button_click',
                post_id: post_id,
            },
            success: function(response) {
                like_button.siblings('.like-count').text(response + ' Likes');
            }
        });
    });
});