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
                  if (response.success) {
                    like_button.siblings('.like-count').text(response.data.like_count + ' Likes');
                    alert('You liked the post!');
                  
                } else {
                    alert('You have already liked this post.');
                }
            }
        });
    });
});