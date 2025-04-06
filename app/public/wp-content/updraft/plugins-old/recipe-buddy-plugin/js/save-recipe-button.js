//This jquery function handles the save recipe button when it is clicked and updates the button as required.
jQuery(document).ready(function($) {
    $(".save-recipe-button").click(function() {
        var button = $(this);
        var postID = button.data("post-id"); // Get the post ID 
        var userID = button.data("user-id"); // Get the user ID 

        $.ajax({
            //action type is POST as we are updating the button on click
            type: "POST",
            url: save_recipe_button_obj.ajax_url,
            data: {
                action: "save_recipe_button_click",
                post_id: postID, // Add post id to the data being sent
                user_id: userID  // Add user_id to the data being sent
            },
            success: function(response) {
                if (response.success) {
                    button.text(response.data.button_text); // Correctly update button text
                } else {
                    alert(response.data.message); // Show error message if failed
                }
            },
            //error handling
            error: function() {
                alert("Something went wrong. Please try again.");
            }
        });
    });
});

//This jquery function handles the customised recipe buddy search bar.
jQuery(document).ready(function($) {
    //Enables live searching
    let typingTimer;
    const doneTypingInterval = 200; // Wait 300ms after user stops typing

    $('#recipe-search-input').on('keyup', function() {
        clearTimeout(typingTimer);
        const searchTerm = $(this).val();

        // Don't trigger search on empty input
        if (searchTerm.length > 1) {
            typingTimer = setTimeout(function() {
                runLiveRecipeSearch(searchTerm);
            }, doneTypingInterval);
        } else {
            $('#recipe-results').empty();
        }
    });

    $('#recipe-search-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
        const searchTerm = $('#recipe-search-input').val();

        // Check if searchTerm is not empty
        if (searchTerm.length > 1) {
            runLiveRecipeSearch(searchTerm);
        } else {
            $('#recipe-results').empty(); // Clear results when input is empty
        }
    });

    //Retrieving data through a GET request 
    function runLiveRecipeSearch(searchTerm) {
        $.ajax({
            url: recipeBuddyAjax.ajaxurl, // URL for AJAX handler
            type: 'GET',
            data: {
                action: 'recipe_search', // The custom action for the search
                s: searchTerm, // The search term, matching with html format
                recipe_search: 1, // Ensures this is a Recipe Buddy search, not the default wp search bar
            },
            success: function(response) {
                // Update the results div on the page with the matching search results
                $('#recipe-results').html(response);
            },
            error: function() {
                // Display error handling message if the request fails
                $('#recipe-results').html('<p>Sorry, there was an error fetching the results. Please try again later.</p>');
            }
        });
    }
});
