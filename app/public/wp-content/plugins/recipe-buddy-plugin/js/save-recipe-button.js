jQuery(document).ready(function($) {
    $(".save-recipe-button").click(function() {
        var button = $(this);
        var postID = button.data("post-id");
        var userID = button.data("user-id"); // Make sure you grab the user ID as well

        $.ajax({
            type: "POST",
            url: save_recipe_button_obj.ajax_url,
            data: {
                action: "save_recipe_button_click",
                post_id: postID,
                user_id: userID // Add user_id to the data being sent
            },
            success: function(response) {
                if (response.success) {
                    button.text(response.data.button_text); // Correctly update button text
                } else {
                    alert(response.data.message); // Show error message if failed
                }
            },
            error: function() {
                alert("Something went wrong. Please try again.");
            }
        });
    });
});
