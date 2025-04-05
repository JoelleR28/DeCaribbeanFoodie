jQuery(document).ready(function($) {
    // Open the modal when the "Edit Recipe" link is clicked
    $('.edit-recipe').click(function(e) {
        e.preventDefault(); // Prevent default link behavior

        var recipeID = $(this).data('recipe-id'); // Get the recipe ID from the clicked link

        // Show the modal
        $('#recipe-modal').fadeIn();

        // Fetch the recipe details via AJAX using GET
        $.ajax({
            url: recipeEditorParams.ajaxurl, // WordPress AJAX URL
            method: 'GET', // Use GET to retrieve data
            data: {
                action: 'get_recipe_details', // Custom action to get recipe details
                recipe_id: recipeID, // Pass the recipe ID
                security: recipeEditorParams.security // Pass the nonce for security
            },
            success: function(response) {
                if (response.success) {
                    // Pre-fill the form with the recipe details
                    $('#recipe_title').val(response.data.title);
                    $('#recipe_ingredients').val(response.data.ingredients);
                    $('#recipe_instructions').val(response.data.instructions);
                    $('#recipe_id').val(recipeID); // Set the recipe ID in the hidden field
                } else {
                    alert('Failed to load recipe details. Please try again later.');
                }
            },
            error: function(xhr, status, error) {
                alert('Error fetching recipe details: ' + error);
            }
        });
    });

    // Close the modal when the "X" button is clicked
    $('#close-modal').click(function() {
        $('#recipe-modal').fadeOut(); // Hide the modal
    });

    // Close the modal if clicked outside the modal content
    $(window).click(function(event) {
        if ($(event.target).is('#recipe-modal')) {
            $('#recipe-modal').fadeOut(); // Hide the modal if clicked outside
        }
    });
});

jQuery(document).ready(function($) {
    // Handle the form submission to update the recipe
    $('#edit-recipe-form').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        var data = {
            action: 'update_recipe', // The custom action for updating the recipe
            recipe_id: $('#recipe_id').val(),
            recipe_title: $('#recipe_title').val(),
            recipe_ingredients: $('#recipe_ingredients').val(),
            recipe_instructions: $('#recipe_instructions').val(),
            security: recipeEditorParams.security // Pass the nonce for security
        };

        // Send the POST request to update the recipe
        $.post(recipeEditorParams.ajaxurl, data, function(response) {
            if (response.success) {
                $('#message').html('<p>Recipe updated successfully!</p>');
                setTimeout(function() {
                    $('#recipe-modal').fadeOut(); // Close the modal
                    location.reload(); // Reload the page to reflect changes
                }, 500);
            } else {
                $('#message').html('<p>Error: ' + response.data + '</p>');
            }
        });
    });
});