jQuery(document).ready(function($) {
    const mealPlanner = $('.meal-planner-container');
    const modal = $('.recipe-selection-modal');
    const closeModal = $('.close-modal');
    const editBtn = $('.edit-meal-plan-btn');
    const resetBtn = $('.reset-meal-plan-btn');
    const mealSlots = $('.meal-slot');
    const recipeOptions = $('.recipe-option');
    
    let selectedSlot = null;
    let isEditing = false;
    
    // Function to update total calories display
    function updateTotalCalories() {
        let totalCalories = 0;
        $('.meal-slot').each(function() {
            const caloriesText = $(this).find('.calories-per-serving').text();
            const calories = parseInt(caloriesText) || 0;
            totalCalories += calories;
        });
        $('.total-calories').text(totalCalories);
    }
    
    // Edit mode toggle
    editBtn.on('click', function() {
        isEditing = !isEditing;
        $(this).text(isEditing ? 'Done Editing' : 'Edit Meal Plan');
        mealSlots.toggleClass('editable');
    });
    
    // Reset meal plan
    resetBtn.on('click', function() {
        if (confirm('Are you sure you want to reset your meal plan? This will remove all recipes.')) {
            const mealPlanId = mealPlanner.data('meal-plan-id');
            
            $.ajax({
                url: mealPlannerAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'reset_meal_plan',
                    meal_plan_id: mealPlanId,
                    nonce: mealPlannerAjax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Failed to reset meal plan. Please try again.');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });
    
    // Handle meal slot clicks
    mealSlots.on('click', function() {
        if (!isEditing) return;
        
        selectedSlot = $(this);
        modal.show();
    });
    
    // Close modal
    closeModal.on('click', function() {
        modal.hide();
        selectedSlot = null;
    });
    
    // Handle recipe selection
    recipeOptions.on('click', function() {
        if (!selectedSlot) return;
        
        const recipeId = $(this).data('recipe-id');
        const mealPlanId = mealPlanner.data('meal-plan-id');
        const slotNumber = selectedSlot.data('slot');
        
        // Get the recipe title and thumbnail from the clicked option
        const recipeTitle = $(this).find('h4').text();
        const recipeThumbnail = $(this).find('.recipe-thumbnail').html();
        const recipeExcerpt = $(this).find('.recipe-excerpt').text();
        
        $.ajax({
            url: mealPlannerAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'add_recipe_to_plan',
                meal_plan_id: mealPlanId,
                recipe_id: recipeId,
                slot_number: slotNumber,
                nonce: mealPlannerAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update the slot with the new recipe
                    selectedSlot.find('.empty-slot').remove();
                    selectedSlot.find('.recipe-item').remove();
                    
                    selectedSlot.append(`
                        <div class="recipe-item">
                            <div class="recipe-thumbnail">
                                ${recipeThumbnail}
                            </div>
                            <div class="recipe-details">
                                <h5>${recipeTitle}</h5>
                                <div class="calories-per-serving">${recipeExcerpt}</div>
                            </div>
                        </div>
                    `);
                    
                    updateTotalCalories();
                    modal.hide();
                } else {
                    alert('Failed to add recipe. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
    
    // Close modal when clicking outside
    $(window).on('click', function(event) {
        if (event.target === modal[0]) {
            modal.hide();
            selectedSlot = null;
        }
    });
    
    // Initialize total calories display
    updateTotalCalories();
}); 