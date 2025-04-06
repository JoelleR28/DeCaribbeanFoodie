//This jquery function handles displaying the recipe ediotr modal object when the edit icon is clicked.
jQuery(document).ready(function($) {
    // Open the recipe editor modal when the "Edit Recipe" icon link is clicked
    $('.edit-recipe').click(function(e) {
        e.preventDefault(); // Prevent default link behavior to allow modal to properly be displayed

        var recipeID = $(this).data('recipe-id'); // Get the recipe ID from the clicked link

        // Show the recipe editor modal
        $('#recipe-modal').fadeIn();

        // Fetch the existing recipe details from the chosen recipe post via AJAX using the GET method
        $.ajax({
            url: recipeEditorParams.ajaxurl, // WordPress AJAX URL
            method: 'GET', // Use GET to retrieve data
            //used to store data being handled in the request
            data: {
                action: 'get_recipe_details', // Custom action to get recipe details
                recipe_id: recipeID, // Pass the recipe ID
                security: recipeEditorParams.security // Pass the nonce for security
            },
            success: function(response) {
                if (response.success) {
                    // Pre-fill the recipe editor form with the saved recipe details
                    $('#recipe_title').val(response.data.title); //Get the recipe title
                    $('#recipe_ingredients').val(response.data.ingredients); //Get the list of ingredients 
                    $('#recipe_instructions').val(response.data.instructions); // Get the instruction steps
                    $('#recipe_id').val(recipeID); // Set the recipe ID in the hidden field, not visible to the user
                } else {
                    alert('Failed to load recipe details. Please try again later.'); //display unsucessful message to subscriber/user
                }
            },
            error: function(xhr, status, error) {
                alert('Error fetching recipe details: ' + error); //display unsucessful message to subscriber/user
            }
        });
    });

    // Close the recipe editor modal when the "X" button is clicked
    $('#close-modal').click(function() {
        $('#recipe-modal').fadeOut(); // Hide the modal
    });

    // Close the recipe editor modal if clicked outside the modal content
    $(window).click(function(event) {
        if ($(event.target).is('#recipe-modal')) {
            $('#recipe-modal').fadeOut(); // Hide the modal if clicked outside
        }
    });
});

//This jquery function handles updating the saved recipe by the user when the update recipe button is clicked by the user/subscriber.
jQuery(document).ready(function($) {
    // Handle the form submission to update the recipe
    $('#edit-recipe-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
        
        //Store the updated data inputted by the user in the text areas
        var data = {
            action: 'update_recipe', // The custom action for updating the recipe
            recipe_id: $('#recipe_id').val(),  // Pass the recipe post id, hidden to user solely for backend purposes 
            recipe_title: $('#recipe_title').val(),  // Pass the recipe post title if updated by the user
            recipe_ingredients: $('#recipe_ingredients').val(), // Pass the recipe post ingredients if updated by the user
            recipe_instructions: $('#recipe_instructions').val(), // Pass the recipe post instructions if updated by the user
            security: recipeEditorParams.security // Pass the nonce for security, solely for backend processing 
        };

        // Send the POST request to update the user's saved recipe post
        $.post(recipeEditorParams.ajaxurl, data, function(response) {
            if (response.success) {
                $('#message').html('<p>Your recipe was updated successfully!</p>');
                setTimeout(function() {
                    $('#recipe-modal').fadeOut(); // Close the recipe editor modal
                    location.reload(); // Reload the page to reflect changes
                }, 500);
            } else {
                //error handling
                $('#message').html('<p>Error: ' + response.data + '</p>');
            }
        });
    });
});