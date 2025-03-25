<?php
/* 
Plugin Name: Recipe Buddy
Description: Save recipes and edit them, receive suggestions based on ingredients inputted by the user. 
Version: 1.0 
Author: Joelle Ramchandar 
Author URI: ----
License: GPL2 
*/

// Hook to add custom message to the footer
function my_custom_footer_message()
{
    echo '<p style="text-align: center;">This is my custom plugin footer message!</p>';
}
add_action('wp_footer', 'my_custom_footer_message');

// Hook to add settings page to the admin menu
function my_custom_plugin_menu()
{
    add_options_page(
        'My Custom Plugin Settings',    // Page title
        'Custom Plugin',                // Menu title
        'manage_options',               // Capability required to access
        'my-custom-plugin',             // Menu slug
        'my_custom_plugin_settings_page' // Callback function to display the settings page
    );
}
add_action('admin_menu', 'my_custom_plugin_menu');

// Register settings and fields
function my_custom_plugin_register_settings()
{
    // Register the settings group and individual settings
    register_setting('my_custom_plugin_options', 'my_footer_message'); // 'my_footer_message' is the option name

    // Add a settings section to the settings page
    add_settings_section(
        'my_custom_plugin_section',       // Section ID
        'Custom Footer Settings',         // Section Title
        'my_custom_plugin_section_callback', // Callback function
        'my-custom-plugin'                // Page slug
    );

    // Add a settings field to the section
    add_settings_field(
        'my_footer_message',             // Field ID
        'Footer Message',                // Field Title
        'my_custom_plugin_field_callback', // Callback function to render the field
        'my-custom-plugin',              // Page slug
        'my_custom_plugin_section'       // Section ID
    );
}
add_action('admin_init', 'my_custom_plugin_register_settings');

// Callback function for the section (optional)
function my_custom_plugin_section_callback()
{
    echo '<p>Enter the custom footer message that will be displayed on your website.</p>';
}

// Callback function to render the footer message field
function my_custom_plugin_field_callback()
{
    ?>
    <input type="text" id="my_footer_message" name="my_footer_message"
        value="<?php echo esc_attr(get_option('my_footer_message')); ?>" class="regular-text" />
    <?php
}

?>

<?php function my_custom_plugin_settings_page()
{ ?>

    <div class="wrap">
        <h1>My Custom Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
            // Output the settings fields and sections 
// This is the settings group 
            settings_fields('my_custom_plugin_options');
            // This will display the plugin's settings section 
            do_settings_sections('my-custom-plugin');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Footer Message:</th>
                    <td><input type="text" name="my_footer_message"
                            value="<?php echo esc_attr(get_option('my_footer_message')); ?>" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
?>