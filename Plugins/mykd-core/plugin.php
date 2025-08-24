<?php
namespace GenixCore;

use GenixCore\PageSettings\Page_Settings;
use Elementor\Controls_Manager;


/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Genix_Core_Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Add Category
	 */

    public function genix_core_elementor_category($manager)
    {
        $manager->add_category(
            'genixcore',
            array(
                'title' => esc_html__('Mykd Addons', 'genixcore'),
                'icon' => 'eicon-banner',
            )
        );
    }

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		wp_register_script( 'genixcore', plugins_url( '/assets/js/hello-world.js', __FILE__ ), [ 'jquery' ], false, true );
	}

	/**
	 * Editor scripts
	 *
	 * Enqueue plugin javascripts integrations for Elementor editor.
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function editor_scripts() {
		add_filter( 'script_loader_tag', [ $this, 'editor_scripts_as_a_module' ], 10, 2 );

		wp_enqueue_script(
			'genixcore-editor',
			plugins_url( '/assets/js/editor/editor.js', __FILE__ ),
			[
				'elementor-editor',
			],
			'1.2.1',
			true
		);
	}


	/**
	 * genix_enqueue_editor_scripts
	 */
    function genix_enqueue_editor_scripts()
    {
        wp_enqueue_style('genix-element-addons-editor', GENIXCORE_ADDONS_URL . 'assets/css/editor.css', null, '1.0');
    }





	/**
	 * Force load editor script as a module
	 *
	 * @since 1.2.1
	 *
	 * @param string $tag
	 * @param string $handle
	 *
	 * @return string
	 */
	public function editor_scripts_as_a_module( $tag, $handle ) {
		if ( 'genixcore-editor' === $handle ) {
			$tag = str_replace( '<script', '<script type="module"', $tag );
		}

		return $tag;
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @param Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		// Its is now safe to include Widgets files
		foreach($this->genixcore_widget_list() as $widget_file_name){
			require_once( GENIXCORE_ELEMENTS_PATH . "/{$widget_file_name}.php" );
		}

		// Charitable_Campaign
		if ( function_exists( 'tutor' ) ) {
			foreach($this->genixcore_widget_list_tutor() as $widget_file_name){
				require_once( GENIXCORE_ELEMENTS_PATH . "/{$widget_file_name}.php" );
			}
		}
	}

	public function genixcore_widget_list() {
		return [
            'heading',
            'tg-btn',
            'banner-content',
            'banner-image',
            'background-shapes',
            'brand',
            'about-tab',
            'tg-counter',
            'image-box',
            'tg-gallery',
            'video-button',
            'icon-box',
            'icon-list',
            'team',
            'streamers',
            'roadmap',
            'team-vs',
            'tournament',
            'match-list',
            'nft-box',
            'services-box',
            'tournament-sidebar',
            'social-list',
            'circle-text',
            'pricing',
            'faq',
            // 'blog-post',
            // 'footer-gallery',
		];
	}

	// genixcore_widget_list_campaign
	public function genixcore_widget_list_tutor() {
		return [
			'tutor-course',
		];
	}

	/**
	 * Add page settings controls
	 *
	 * Register new settings for a document page settings.
	 *
	 * @since 1.2.1
	 * @access private
	 */
	private function add_page_settings_controls() {
		require_once( __DIR__ . '/page-settings/manager.php' );
		new Page_Settings();
	}


	/**
	 * Register controls
	 *
	 * @param Controls_Manager $controls_Manager
	 */

    public function register_controls(Controls_Manager $controls_Manager)
    {
        include_once(GENIXCORE_ADDONS_DIR . '/controls/genixgradient.php');
        $genixgradient = 'GenixCore\Elementor\Controls\Group_Control_GenixGradient';
        $controls_Manager->add_group_control($genixgradient::get_type(), new $genixgradient());

        include_once(GENIXCORE_ADDONS_DIR . '/controls/genixbggradient.php');
        $genixbggradient = 'GenixCore\Elementor\Controls\Group_Control_GenixBGGradient';
        $controls_Manager->add_group_control($genixbggradient::get_type(), new $genixbggradient());
    }




    public function genix_add_custom_icons_tab($tabs = array()){


        // Append new icons
        $feather_icons = array(
            'feather-activity',
            'feather-airplay',
            'feather-alert-circle',
            'feather-alert-octagon',
            'feather-alert-triangle',
            'feather-align-center',
            'feather-align-justify',
            'feather-align-left',
            'feather-align-right',
        );

        $tabs['tg-feather-icons'] = array(
            'name' => 'tg-feather-icons',
            'label' => esc_html__('Mykd Feather Icons', 'genixcore'),
            'labelIcon' => 'genix-icon',
            'prefix' => '',
            'displayPrefix' => 'genix',
            'url' => GENIXCORE_ADDONS_URL . 'assets/css/feather.css',
            'icons' => $feather_icons,
            'ver' => '1.0.0',
        );

        // Append new icons
        $flat_icons = array(
            'flaticon-internet',
            'flaticon-worldwide',
            'flaticon-international',
            'flaticon-login',
            'flaticon-import',
            'flaticon-lock',
            'flaticon-padlock',
            'flaticon-edit',
            'flaticon-search',
            'flaticon-duel',
            'flaticon-swords-in-cross-arrangement',
            'flaticon-crossed-swords',
            'flaticon-right-arrow',
            'flaticon-facebook',
            'flaticon-twitter',
            'flaticon-instagram',
            'flaticon-youtube',
            'flaticon-discord',
            'flaticon-twitch',
            'flaticon-right-arrow-1',
            'flaticon-right-arrow-2',
            'flaticon-magnifying-glass',
            'flaticon-swords',
            'flaticon-swords-1',
            'flaticon-chess',
            'flaticon-invoice',
            'flaticon-withdrawal',
            'flaticon-web',
            'flaticon-add-user',
            'flaticon-checked',
            'flaticon-message',
            'flaticon-nft',
            'flaticon-wallet',
            'flaticon-wallet-1',
            'flaticon-paper-plane',
            'flaticon-send',
            'flaticon-loupe',
            'flaticon-search-1',
            'flaticon-play',
            'flaticon-right-arrow-3',
            'flaticon-next',
            'flaticon-diamond',
            'flaticon-ethereum',
            'flaticon-star',
            'flaticon-settings',
            'flaticon-settings-1',
            'flaticon-guru',
            'flaticon-best-employee',
            'flaticon-user-profile',
            'flaticon-quote',
            'flaticon-circle',
            'flaticon-repeat',
            'flaticon-repeat-2',
            'flaticon-quotation',
            'flaticon-quote-1',
            'flaticon-play-1',
            'flaticon-play-button',
        );

        $tabs['tg-flat-icons'] = array(
            'name' => 'tg-flat-icons',
            'label' => esc_html__('Mykd Flat Icons', 'genixcore'),
            'labelIcon' => 'genix-icon',
            'prefix' => '',
            'displayPrefix' => 'genix',
            'url' => GENIXCORE_ADDONS_URL . 'assets/css/flaticon.css',
            'icons' => $flat_icons,
            'ver' => '1.0.0',
        );

        $fontAwesome_icons = array(
	        'angle-up',
	        'check',
	        'times',
	        'calendar',
	        'language',
	        'shopping-cart',
	        'bars',
	        'search',
	        'map-marker',
	        'arrow-right',
	        'arrow-left',
	        'arrow-up',
	        'arrow-down',
	        'angle-right',
	        'angle-left',
	        'angle-up',
	        'angle-down',
	        'phone',
	        'users',
	        'user',
	        'map-marked-alt',
	        'trophy-alt',
	        'envelope',
	        'marker',
	        'globe',
	        'broom',
	        'home',
	        'bed',
	        'chair',
	        'bath',
	        'tree',
	        'laptop-code',
	        'cube',
	        'cog',
	        'play',
	        'trophy-alt',
	        'heart',
	        'truck',
	        'user-circle',
	        'map-marker-alt',
	        'comments',
	        'award',
	        'bell',
	        'book-alt',
	        'book-open',
	        'book-reader',
	        'graduation-cap',
	        'laptop-code',
	        'music',
	        'ruler-triangle',
	        'user-graduate',
	        'microscope',
	        'glasses-alt',
	        'theater-masks',
	        'atom'
        );

        $tabs['tg-fontawesome-icons'] = array(
            'name' => 'tg-fontawesome-icons',
            'label' => esc_html__('Mykd Fontawesome Pro', 'genixcore'),
            'labelIcon' => 'genix-icon',
            'prefix' => 'fa-',
            'displayPrefix' => 'fal',
            'url' => GENIXCORE_ADDONS_URL . 'assets/css/fontawesome-all.min.css',
            'icons' => $fontAwesome_icons,
            'ver' => '1.0.0',
        );

        return $tabs;
    }


	// campaign_template_fun
	public function campaign_template_fun( $campaign_template ) {

	    if ( ( get_post_type() == 'campaign' ) && is_single() ) {
	        $campaign_template_file_path = __DIR__ . '/include/template/single-campaign.php';
	        $campaign_template           = $campaign_template_file_path;
	    }
	    if ( ( get_post_type() == 'tribe_events' ) && is_single() ) {
	        $campaign_template_file_path = __DIR__ . '/include/template/single-event.php';
	        $campaign_template           = $campaign_template_file_path;
	    }

	    if ( ! $campaign_template ) {
	        return $campaign_template;
	    }
	    return $campaign_template;
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Register editor scripts
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );

		add_action('elementor/elements/categories_registered', [$this, 'genix_core_elementor_category']);

		// Register custom controls
	    add_action('elementor/controls/controls_registered', [$this, 'register_controls']);

	    add_filter('elementor/icons_manager/additional_tabs', [$this, 'genix_add_custom_icons_tab']);

	    // $this->genix_add_custom_icons_tab();

	    add_action('elementor/editor/after_enqueue_scripts', [$this, 'genix_enqueue_editor_scripts'] );

	    add_filter( 'template_include', [ $this, 'campaign_template_fun' ], 99 );

		$this->add_page_settings_controls();

	}


}

// Instantiate Plugin Class
Genix_Core_Plugin::instance();