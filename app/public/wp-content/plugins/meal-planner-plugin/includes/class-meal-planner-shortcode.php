<?php
if (!defined('ABSPATH')) {
    exit;
}

class Meal_Planner_Shortcode {
    private $meal_planner;
    
    public function __construct() {
        $this->meal_planner = new Meal_Planner();
    }
    
    public function init() {
        add_shortcode('meal_planner', array($this, 'render_meal_planner'));
    }
    
    public function render_meal_planner($atts) {
        if (!is_user_logged_in()) {
            return '<p>Please log in to view and manage your meal plan.</p>';
        }
        
        $meal_plan = $this->meal_planner->get_user_meal_plan(get_current_user_id());
        $meal_plan_items = $this->meal_planner->get_meal_plan_items($meal_plan->ID);
        
        ob_start();
        ?>
        <div class="meal-planner-container" data-meal-plan-id="<?php echo esc_attr($meal_plan->ID); ?>">
            <div class="meal-planner-header">
                <h2>My Meal Plan</h2>
                <div class="meal-planner-actions">
                    <button class="edit-meal-plan-btn">Edit Meal Plan</button>
                    <button class="reset-meal-plan-btn">Reset Meal Plan</button>
                </div>
            </div>
            
            <div class="meal-plan-slots">
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    echo '<div class="meal-slot" data-slot="' . esc_attr($i) . '">';
                    echo '<h4>Recipe ' . esc_html($i) . '</h4>';
                    
                    // Find recipe for this slot
                    $recipe = isset($meal_plan_items[$i]) ? $meal_plan_items[$i] : null;
                    if ($recipe) {
                        echo '<div class="recipe-item">';
                        if (has_post_thumbnail($recipe->ID)) {
                            echo '<div class="recipe-thumbnail">';
                            echo get_the_post_thumbnail($recipe->ID, 'thumbnail');
                            echo '</div>';
                        }
                        echo '<div class="recipe-details">';
                        echo '<h5>' . esc_html($recipe->post_title) . '</h5>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="empty-slot">Empty</div>';
                    }
                    
                    echo '</div>';
                }
                ?>
            </div>
            
            <!-- Recipe Selection Modal -->
            <div class="recipe-selection-modal" style="display: none;">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <h3>Select a Recipe</h3>
                    <div class="recipe-list">
                        <?php
                        $recipes_query = new WP_Query(array(
                            'post_type' => 'recipe',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC'
                        ));
                        
                        if ($recipes_query->have_posts()) {
                            while ($recipes_query->have_posts()) {
                                $recipes_query->the_post();
                                echo '<div class="recipe-option" data-recipe-id="' . esc_attr(get_the_ID()) . '">';
                                if (has_post_thumbnail()) {
                                    echo '<div class="recipe-thumbnail">';
                                    the_post_thumbnail('thumbnail');
                                    echo '</div>';
                                }
                                echo '<div class="recipe-info">';
                                echo '<h4>' . esc_html(get_the_title()) . '</h4>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
} 