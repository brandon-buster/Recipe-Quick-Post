<?php
/*
 * Plugin Name: Recipe Quick Post
 * Description: Post, categorize and search recipes on your Wordpress blog
 * Plugin Author: Brandon Buster
 * Author URI: http://brandonbuster.com
 */

add_action('init', 'register_recipe_post_type');
//add_action('admin_menu', 'recipe_meta'); //removes ingredients tax box
add_action('add_meta_boxes', 'add_recipe_meta');
add_action('admin_enqueue_scripts', 'add_ingredients_js');
add_action('save_post', 'save_recipe_meta');
add_action('template_redirect', 'add_recipe_css');
add_image_size( 'recipe', 300, ''); // Portfolio Image


function register_recipe_post_type() {
	$post_type_args = array(
		'public' => true,
		'query_var' => 'recipes',
		'rewrite' => array('slug' => 'recipes', 'with_front'),
		'supports' => array('title', 'thumbnail', 'comments', 'revisions', 'author', 'excerpt', 'editor'),
		'taxonomies' => array('categories', 'post_tag'),
		'labels' => array(
				'name' => 'Recipes',
				'singular_name' => 'Recipe',
				'add_new' => 'Add New Recipe',
				'add_new_item' => 'Add New Recipe',
				'edit_item' => 'Edit Recipe',
				'new_item' => 'New Recipe',
				'view_item' => 'View Recipe',
				'search_items' => 'Search Recipes',
				'not_found' => 'No Recipes Found',
				'not_found_in_trash' => 'No Recipes Found in Trash'
			)
	);
	
	$ingredients_args = array(
		'hierarchical' => false,
		'query_var' => 'ingredients',
		'rewrite' => array('ingredients', 'with_front' => false),
		'labels' => array(
			'name' => 'Ingredients',
			'singular_name' => 'Ingredient',
			'edit_item' => 'Edit Ingredient',
			'update_item' => 'Update Ingredient',
			'add_new_item' => 'Add New Ingredient',
			'new_item_name' => 'New Ingredient Name',
			'all_items' => 'All Ingredients',
			'search_items' => 'Search Ingredients',
			'popular_items' => 'Popular Ingredients',
			'seperate_items_with_commas' => 'Seperate Ingredients with Commas',
			'add_or_remove_items' => 'Add or Remove Ingredients',
			'choose_from_most_used' => 'Choose from Most Popular Ingredients'
		) 
	);
	
	$cuisine_args = array(
		'hierarchical' => true,
		'query_var' => 'cuisines',
		'rewrite' => array('cuisines', 'with_front' => false),
		'labels' => array(
			'name' => 'Cuisines',
			'singular_name' => 'Cuisine',
			'edit_item' => 'Edit Cuisine',
			'update_item' => 'Update Cuisine',
			'add_new_item' => 'Add New Cuisine',
			'new_item_name' => 'New Cuisine Name',
			'all_items' => 'All Cuisine',
			'search_items' => 'Search Cuisines',
			'popular_items' => 'Popular Cuisines',
			'seperate_items_with_commas' => 'Seperate Cuisine with Commas',
			'add_or_remove_items' => 'Add or Remove Cuisine',
			'choose_from_most_used' => 'Choose from Most Popular Cuisines',
			'parent_item' => 'Parent Cuisine',
			'parent_item_colon' => 'Parent Cuisine:'
		)
	);
	
	$course_type_args = array(
		'hierarchical' => true,
		'query_var' => 'courses',
		'rewrite' => array('courses', 'with_front' => false),
		'labels' => array(
			'name' => 'Courses',
			'singular_name' => 'Course',
			'edit_item' => 'Edit Course',
			'update_item' => 'Update Course',
			'add_new_item' => 'Add New Course',
			'new_item_name' => 'New Course Name',
			'all_items' => 'All Course',
			'search_items' => 'Search Courses',
			'popular_items' => 'Popular Courses',
			'seperate_items_with_commas' => 'Seperate Course with Commas',
			'add_or_remove_items' => 'Add or Remove Course',
			'choose_from_most_used' => 'Choose from Most Popular Courses',
			'parent_item' => 'Parent Course',
			'parent_item_colon' => 'Parent Course:'
		)
	);
	
	register_post_type('recipes', $post_type_args); 
	register_taxonomy('ingredients', array('recipes'), $ingredients_args);
	register_taxonomy('cuisine', array('recipes'), $cuisine_args);
	register_taxonomy('course_type', array('recipes'), $course_type_args);
}


function recipe_meta() {
	remove_meta_box('tagsdiv-ingredients', 'recipes', 'side');
}

function add_recipe_meta() {
	add_meta_box('serving-meta', 'Number of Servings', 'print_serving_box', 'recipes', 'normal', 'high');
	add_meta_box('prep-time-meta', 'Set Prep & Bake Times', 'print_prep_time_boxes', 'recipes', 'normal', 'high');
	add_meta_box('ingredients-meta', 'Add Recipe Ingredients', 'print_ingredient_boxes', 'recipes', 'normal', 'high');
}

function print_serving_box($recipe) {
	$serving_size = get_post_meta($recipe->ID, 'serving_size', true);
	?>
	<label for="serving-size">Enter Number of People Recipe Will Serve</label>
	<input type="text" name="serving-size" value="<?php echo $serving_size; ?>" />
	<?php 
}

function print_prep_time_boxes($recipe) {
	$prep = get_post_meta($recipe->ID, 'prep_time', true);
	$bake = get_post_meta($recipe->ID, 'bake_time', true);
	?>
	<label for="prep_time">Enter Prep Time</label>
	<input type="text" name="prep_time" value="<?php echo $prep; ?>" />
	<label for="bake_time">Enter Bake Time</label>
	<input type="text" name="bake_time" value="<?php echo $bake; ?>" />
	<?php 
}

function print_ingredient_boxes($recipe) {
	$ingredients = get_post_meta($recipe->ID, 'ingredients', true);
	?>
	<input type="submit" class="button-primary add-ingredient alignright" value="add ingredient" />
	<?php 
	if($ingredients != '') {
		$i = 1;
		foreach($ingredients as $ingredient => $qty) :
		?>
			<div>
				<span class="ingredients-span">
					<label for="ingredient-1">Ingredient Name:</label>
					<input type="text" name="ingredient-<?php echo $i; ?>" width="55" value="<?php echo $ingredient; ?>"/>
					<label for="qty-1">QTY:</label>
					<input type="text" name="qty-<?php echo $i; ?>" value="<?php echo $qty; ?>" />
				</span> 
				<input type="submit" class="secondary delete-ingredient" id="ingredient-<?php echo $i; ?>" value="Delete Ingredient" />
			</div>
		<?php
		$i++;
		endforeach;
		
	} else { ?>
		<span class="ingredients-span">
			<label for="ingredient-1">Ingredient Name:</label>
			<input type="text" name="ingredient-1" width="55" />
			
			<label for="qty-1">QTY:</label>
			<input type="text" name="qty-1" />
		</span>
	<?php }
		
}

function add_ingredients_js() {
	global $post_type;
	if ($post_type != 'recipes') return;
	wp_enqueue_script('ingredients-js', plugins_url('js/ingredients.js', __FILE__), array(jquery), 1);
}

function save_recipe_meta($post_id) {
	if(isset($_POST)) {
		$i = 1;
		while($_POST['ingredient-' . $i]) :
			$ingredient = trim($_POST['ingredient-' . $i]);
			if($ingredient != 'empty') {
				$qty = trim($_POST['qty-' . $i]);
				$ingredients_array[$ingredient] = $qty;
			}
			$i++;
		endwhile;
	}
	update_post_meta($post_id, 'ingredients', $ingredients_array);
	
	if(isset($_POST['serving-size'])) {
		$servings = $_POST['serving-size'];
		update_post_meta($post_id, 'serving_size', $servings);
	}
	
	if(isset($_POST['prep_time'])) {
			$prep = $_POST['prep_time'];
			update_post_meta($post_id, 'prep_time', $prep);
		}
		
	if(isset($_POST['bake_time'])) {
			$bake = $_POST['bake_time'];
			update_post_meta($post_id, 'bake_time', $bake);
		}
}

function add_recipe_css() {
	if(is_page('recipes') || 'recipes' == get_post_type()) {
		wp_enqueue_style('recipes.css', plugins_url('css/recipes.css', __FILE__));
	}
}