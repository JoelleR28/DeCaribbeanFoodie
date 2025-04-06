//This jquery function handles the like count when the like-button object is clicked and then returns an alert to user on success.
jQuery(document).ready(function($) {
    $('.like-button').on('click', function() {
        //store the id of the current post 
        var post_id = $(this).data('post-id');
        //store the like button object for further handling
        var like_button = $(this);
        
        $.ajax({
            //action type is POST as we are creating a new like/updating the count on click
            type: 'POST', // Use GET to create data
            url: like_button_obj.ajax_url, // WordPress AJAX URL
            //used to store data being handled in the request
            data: {
                action: 'like_button_click', // Custom action to update like count
                post_id: post_id, // Pass the post ID
            },
            success: function(response) {
                  if (response.success) {
                    //handle the update for the like count display
                    like_button.siblings('.like-count').text(response.data.like_count + ' Likes');
                    alert('You liked this post!'); //display success message to subscriber/user 
                  
                } else {
                    alert('You have already liked this post.');//display unsucessful message to subscriber/user
                }
            }
        });
    });
});