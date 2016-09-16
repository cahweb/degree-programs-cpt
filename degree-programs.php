<?php

/*
 *
 * Plugin Name: Common - Degree Programs CPT
 * Description: Degree Programs plugin, for use on applicable CAH sites
 * Author: Austin Tindle
 *
 */

// Degree Programs
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

add_action("admin_init", "degree_init");
add_action('save_post', 'save_degree');
add_action('init', 'create_degree_type');

function create_degree_type() {
    $args = array(
          'label' => 'Degree Programs',
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => 'program'),
            'query_var' => true,
            'supports' => array(
                'title',
                'thumbnail',
                'categories',
                'excerpt'),
            'menu_icon' => 'dashicons-welcome-learn-more',
        );
 

    register_post_type( 'program' , $args );
}

function degree_init() {
	add_meta_box("program-options-meta", "Options", "dp_general_meta_options", "program", "normal", "low");
    add_meta_box("program-options-meta-d", "Overview", "dp_description_meta_options", "program", "normal", "low");
    add_meta_box("program-options-meta-r", "Requirements", "dp_requirements_meta_options", "program", "normal", "low");
}

function dp_general_meta_options(){
    global $post;
    $custom = get_post_custom($post->ID);
    $subtitle = $custom["subtitle"][0];
    $catalog = $custom["catalog"][0];
    $flyer = $custom["flyer"][0];
    $level = $custom["level"][0];
    $name = $custom["name"][0];
    $email = $custom["email"][0];
    $phone = $custom["phone"][0];
    $location = $custom["location"][0];
    $fileName = "Choose or Upload a file";
    if($flyer != "") {
        $fileName = array_pop(explode('/', rtrim($flyer, '/')));
        $fileName .= " (Click to change)";
    }
?>

<h2>General Information</h2>
<table>
    <tr>
        <td style="text-align:center"><label>Subtitle: </label></td>
        <td><input type="text" name="subtitle" value="<?php echo $subtitle; ?>" size="50"/></td>
    </tr>
    <tr>
        <td style="text-align:center"><label>Catalog URL: </label></td>
        <td><input type="text" name="catalog" value="<?php echo $catalog; ?>" size="50"/></td>
    </tr>
    <tr>
        <td style="text-align:center"><label>Program Flyer: </label></td>
        <td><input type="text" name="flyer" class="meta-image" meta-image="1" value="<?php echo $flyer; ?>" hidden/>
            <input type="button" class="button meta-image-button" meta-image="1" value="<?php echo $fileName; ?>" /> <a href="#" meta-image="1" class="meta-image-clear" <?=($flyer == "" ? "hidden" : "")?>>Remove</a></td>
    </tr>
    <tr>
        <td style="text-align:center"><label>Program Level: </label></td>
        <td>
            <label class="radio-inline"><input type="radio" name="level" value="undergrad" <?php if ($level == 'undergrad') echo "checked"?>>Undergraduate</label>
            <label class="radio-inline"><input type="radio" name="level" value="grad" <?php if ($level == 'grad') echo "checked"?>>Graduate</label>
            <label class="radio-inline"><input type="radio" name="level" value="minor" <?php if ($level == 'minor') echo "checked"?>>Minor</label>
            <label class="radio-inline"><input type="radio" name="level" value="certificate" <?php if ($level == 'cert') echo "checked"?>>Certificate</label>
        </td>
    </tr>
</table>
<h2>Contact Information</h2>
<table>
    <tr>
        <td style="text-align:center"><label>Name: </label></td>
        <td><input type="text" name="name" value="<?php echo $name; ?>" size="50"/></td>
    </tr>
    <tr>
        <td style="text-align:center"><label>Email: </label></td>
        <td><input type="text" name="email" value="<?php echo $email; ?>" size="50"/></td>
    </tr>
    <tr>
        <td style="text-align:center"><label>Phone: </label></td>
        <td><input type="text" name="phone" value="<?php echo $phone; ?>" size="50"/></td>
    </tr>
    <tr>
        <td style="text-align:center"><label>Location: </label></td>
        <td><input type="text" name="location" value="<?php echo $location; ?>" size="50"/></td>
    </tr>
</table>
    <script src="<?php echo get_stylesheet_uri() . '/../library/js/meta-media-picker.js'; ?>"></script>

<?php
}

function dp_description_meta_options(){
    global $post;
    $custom = get_post_custom($post->ID);
    $description = $custom["description"][0];
    $editor_id = 'description';
    $settings = array( 'textarea_rows' => 6 );
    wp_editor( $description, $editor_id, $settings );
}

function dp_requirements_meta_options(){
    global $post;
    $custom = get_post_custom($post->ID);
    $requirements = $custom["requirements"][0];
    $editor_id = 'requirements';
    $settings = array( 'textarea_rows' => 6 );
    wp_editor( $requirements, $editor_id, $settings );
}

function save_degree() {
    global $post;
	update_post_meta($post->ID, "description", $_POST["description"]);
    update_post_meta($post->ID, "subtitle", $_POST["subtitle"]);
    update_post_meta($post->ID, "requirements", $_POST["requirements"]);
    update_post_meta($post->ID, "name", $_POST["name"]);
    update_post_meta($post->ID, "email", $_POST["email"]);
    update_post_meta($post->ID, "phone", $_POST["phone"]);
    update_post_meta($post->ID, "location", $_POST["location"]);
    update_post_meta($post->ID, "catalog", $_POST["catalog"]);
    update_post_meta($post->ID, "flyer", $_POST["flyer"]);
    update_post_meta($post->ID, "level", $_POST["level"]);
}

?>
