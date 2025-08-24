<?php
class GenixProjectPost
{
	function __construct() {
		add_action( 'init', array( $this, 'register_custom_post_type' ) );
		add_action( 'init', array( $this, 'create_cat' ) );
		add_filter( 'template_include', array( $this, 'project_template_include' ) );
	}

	public function project_template_include( $template ) {
		if ( is_singular('project' ) ) {
			return $this->get_template( 'single-project.php');
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
			'name'                  => esc_html_x( 'Projects', 'Post Type General Name', 'genixcore' ),
			'singular_name'         => esc_html_x( 'Project', 'Post Type Singular Name', 'genixcore' ),
			'menu_name'             => esc_html__( 'Project', 'genixcore' ),
			'name_admin_bar'        => esc_html__( 'Project', 'genixcore' ),
			'archives'              => esc_html__( 'Item Archives', 'genixcore' ),
			'parent_item_colon'     => esc_html__( 'Parent Item:', 'genixcore' ),
			'all_items'             => esc_html__( 'All Items', 'genixcore' ),
			'add_new_item'          => esc_html__( 'Add New Project', 'genixcore' ),
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
			'label'                 => esc_html__( 'Project', 'genixcore' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'   			=> 'dashicons-index-card',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);

		register_post_type( 'project', $args );
	}

	public function create_cat() {
		$labels = array(
			'name'                       => esc_html_x( 'Project Categories', 'Taxonomy General Name', 'genixcore' ),
			'singular_name'              => esc_html_x( 'Project Categories', 'Taxonomy Singular Name', 'genixcore' ),
			'menu_name'                  => esc_html__( 'Project Categories', 'genixcore' ),
			'all_items'                  => esc_html__( 'All Project Category', 'genixcore' ),
			'parent_item'                => esc_html__( 'Parent Item', 'genixcore' ),
			'parent_item_colon'          => esc_html__( 'Parent Item:', 'genixcore' ),
			'new_item_name'              => esc_html__( 'New Project Category Name', 'genixcore' ),
			'add_new_item'               => esc_html__( 'Add New Project Category', 'genixcore' ),
			'edit_item'                  => esc_html__( 'Edit Project Category', 'genixcore' ),
			'update_item'                => esc_html__( 'Update Project Category', 'genixcore' ),
			'view_item'                  => esc_html__( 'View Project Category', 'genixcore' ),
			'separate_items_with_commas' => esc_html__( 'Separate items with commas', 'genixcore' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove items', 'genixcore' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'genixcore' ),
			'popular_items'              => esc_html__( 'Popular Project Category', 'genixcore' ),
			'search_items'               => esc_html__( 'Search Project Category', 'genixcore' ),
			'not_found'                  => esc_html__( 'Not Found', 'genixcore' ),
			'no_terms'                   => esc_html__( 'No Project Category', 'genixcore' ),
			'items_list'                 => esc_html__( 'Project Category list', 'genixcore' ),
			'items_list_navigation'      => esc_html__( 'Project Category list navigation', 'genixcore' ),
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

		register_taxonomy('project-cat','project', $args );
	}

}

new GenixProjectPost();