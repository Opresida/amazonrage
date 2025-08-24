<?php
class GenixServicesPost
{
	function __construct() {
		add_action( 'init', array( $this, 'register_custom_post_type' ) );
		add_action( 'init', array( $this, 'create_cat' ) );
		add_filter( 'template_include', array( $this, 'services_template_include' ) );
	}

	public function services_template_include( $template ) {
		if ( is_singular( 'services' ) ) {
			return $this->get_template( 'single-services.php');
		}
		return $template;
	}

	public function get_template( $template ) {
		if ( $theme_file = locate_template( array( $template ) ) ) {
			$file = $theme_file;
		}
		else {
			$file = GENIXCORE_ADDONS_DIR . '/include/template/'. $template;
		}
		return apply_filters( __FUNCTION__, $file, $template );
	}


	public function register_custom_post_type() {
		// $medidove_mem_slug = get_theme_mod('medidove_mem_slug','member');
		$labels = array(
			'name'                  => esc_html_x( 'Services', 'Post Type General Name', 'genixcore' ),
			'singular_name'         => esc_html_x( 'Service', 'Post Type Singular Name', 'genixcore' ),
			'menu_name'             => esc_html__( 'Service', 'genixcore' ),
			'name_admin_bar'        => esc_html__( 'Service', 'genixcore' ),
			'archives'              => esc_html__( 'Item Archives', 'genixcore' ),
			'parent_item_colon'     => esc_html__( 'Parent Item:', 'genixcore' ),
			'all_items'             => esc_html__( 'All Items', 'genixcore' ),
			'add_new_item'          => esc_html__( 'Add New Service', 'genixcore' ),
			'add_new'               => esc_html__( 'Add New', 'genixcore' ),
			'new_item'              => esc_html__( 'New Item', 'genixcore' ),
			'edit_item'             => esc_html__( 'Edit Item', 'genixcore' ),
			'update_item'           => esc_html__( 'Update Item', 'genixcore' ),
			'view_item'             => esc_html__( 'View Item', 'genixcore' ),
			'search_items'          => esc_html__( 'Search Item', 'genixcore' ),
			'not_found'             => esc_html__( 'Not found', 'genixcore' ),
			'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'genixcore' ),
			'featured_image'        => esc_html__( 'Featured Image', 'genixcore' ),
			'set_featured_image'    => esc_html__( 'Set featured image', 'genixcore' ),
			'remove_featured_image' => esc_html__( 'Remove featured image', 'genixcore' ),
			'use_featured_image'    => esc_html__( 'Use as featured image', 'genixcore' ),
			'inserbt_into_item'     => esc_html__( 'Insert into item', 'genixcore' ),
			'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'genixcore' ),
			'items_list'            => esc_html__( 'Items list', 'genixcore' ),
			'items_list_navigation' => esc_html__( 'Items list navigation', 'genixcore' ),
			'filter_items_list'     => esc_html__( 'Filter items list', 'genixcore' ),
		);

		$args   = array(
			'label'                 => esc_html__( 'Service', 'genixcore' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'elementor'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'   			=> 'dashicons-admin-generic',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);

		register_post_type( 'services', $args );
	}

	public function create_cat() {
		$labels = array(
			'name'                       => esc_html_x( 'Service Categories', 'Taxonomy General Name', 'genixcore' ),
			'singular_name'              => esc_html_x( 'Service Categories', 'Taxonomy Singular Name', 'genixcore' ),
			'menu_name'                  => esc_html__( 'Service Categories', 'genixcore' ),
			'all_items'                  => esc_html__( 'All Service Category', 'genixcore' ),
			'parent_item'                => esc_html__( 'Parent Item', 'genixcore' ),
			'parent_item_colon'          => esc_html__( 'Parent Item:', 'genixcore' ),
			'new_item_name'              => esc_html__( 'New Service Category Name', 'genixcore' ),
			'add_new_item'               => esc_html__( 'Add New Service Category', 'genixcore' ),
			'edit_item'                  => esc_html__( 'Edit Service Category', 'genixcore' ),
			'update_item'                => esc_html__( 'Update Service Category', 'genixcore' ),
			'view_item'                  => esc_html__( 'View Service Category', 'genixcore' ),
			'separate_items_with_commas' => esc_html__( 'Separate items with commas', 'genixcore' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove items', 'genixcore' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'genixcore' ),
			'popular_items'              => esc_html__( 'Popular Service Category', 'genixcore' ),
			'search_items'               => esc_html__( 'Search Service Category', 'genixcore' ),
			'not_found'                  => esc_html__( 'Not Found', 'genixcore' ),
			'no_terms'                   => esc_html__( 'No Service Category', 'genixcore' ),
			'items_list'                 => esc_html__( 'Service Category list', 'genixcore' ),
			'items_list_navigation'      => esc_html__( 'Service Category list navigation', 'genixcore' ),
		);

		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);

		register_taxonomy('services-cat','services', $args );
	}

}

new GenixServicesPost();