<?php
/*
Plugin Name: Page Type for Person
Plugin URI: https://github.com/robynover/wp-chrgj-person
Description: Defines a post type for people on chrgj.org
Version: 1.0
Author: Robyn Overstreet
Author URI: http://robynoverstreeet.com
License: GPL2
*/
//Register custom post type
add_action('init', 'person_register');
// Add custom taxonomy
add_action( 'init', 'person_create_taxonomies',2);
 
function person_register() {
 
	$labels = array(
		'name' => _x('People', 'post type general name'),
		'singular_name' => _x('Person', 'post type singular name'),
		'add_new' => _x('Add New', 'Person'),
		'add_new_item' => __('Add New Person'),
		'edit_item' => __('Edit Person'),
		'new_item' => __('New Person'),
		'view_item' => __('View Person'),
		'search_items' => __('Search People'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'person'),
		'capability_type' => 'page',
		'hierarchical' => false,
		'taxonomies'=> array('person_role'),
		'menu_position' => 5,
		'show_in_menu' => true,
		'supports' => array('title','editor','thumbnail','page-attributes')
	  ); 
 
	register_post_type( 'chrgj_person' , $args );
	add_filter( 'the_content', 'wpautop' );
	add_filter( 'the_excerpt', 'wpautop' );
}

function person_create_taxonomies() {
	$labels = array(
	    'name' => _x( 'Staff Roles', 'taxonomy general name' ),
	    'singular_name' => _x( 'Staff Role', 'taxonomy singular name' ),
	    'search_items' =>  __( 'Search Roles' ),
	    'all_items' => __( 'All Staff Roles' ),
	    
	    'edit_item' => __( 'Edit Role' ), 
	    'update_item' => __( 'Update Role' ),
	    'add_new_item' => __( 'Add New Staff Role' ),
	    'new_item_name' => __( 'New Role Name' ),
	    'menu_name' => __( 'Staff Roles' ),
	  ); 	
	
	// Document type
    register_taxonomy('person_role',array('chrgj_person'),array(
        'hierarchical' => true,
        'labels' => $labels,
        'singular_name' => 'Staff Role',
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'people' ),
		'capabilities' => array('manage_categories'.'edit_posts')
    ));
}
//Posts 2 Posts
function person_connections() {
	// Make sure the Posts 2 Posts plugin is active.
	if ( !function_exists( 'p2p_register_connection_type' ) )
		return;

	p2p_register_connection_type( array(
		'name' => 'book_to_person',
		'from' => 'chrgj_book',
		'to' => 'chrgj_person',
		'reciprocal' => true
	) );
	p2p_register_connection_type( array(
		'name' => 'article_to_person',
		'from' => 'chrgj_article',
		'to' => 'chrgj_person',
		'reciprocal' => true
	) );
	p2p_register_connection_type( array(
	'name' => 'doc_to_person',
	'from' => 'chrgj_document',
	'to' => 'chrgj_person',
	'reciprocal' => true
	) );
}
add_action( 'wp_loaded', 'person_connections' );
