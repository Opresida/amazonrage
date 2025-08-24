<?php

namespace GenixCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Control_Media;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Mykd Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TG_TournamentSidebar extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'tg-tournament-sidebar';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Tournament Sidebar', 'genixcore');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'genix-icon eicon-sidebar';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['genixcore'];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['genixcore'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls()
    {

        // layout Panel
        $this->start_controls_section(
            'tg_layout',
            [
                'label' => esc_html__('Widget Layout', 'genixcore'),
            ]
        );

        $this->add_control(
            'tg_design_style',
            [
                'label' => esc_html__('Select Widget', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'layout-1' => esc_html__('Search', 'genixcore'),
                    'layout-2' => esc_html__('Matches List', 'genixcore'),
                    'layout-3' => esc_html__('Advertisement', 'genixcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // Widget Group
        $this->start_controls_section(
            '__tg_widget_group',
            [
                'label' => esc_html__('Widget Group', 'genixcore'),
            ]
        );

        $this->add_control(
            'widget_title',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => esc_html__('Title', 'genixcore'),
                'default' => esc_html__('Search', 'genixcore'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'search_placeholder',
            [
                'label' => esc_html__('Search Placeholder Text', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Search here', 'genixcore'),
                'condition' => [
                    'tg_design_style' => 'layout-1'
                ]
            ]
        );

        $this->end_controls_section();

        // Advertisement Image
        $this->start_controls_section(
            '__tg_advertisement_group',
            [
                'label' => esc_html__('Advertisement Image', 'genixcore'),
                'condition' => [
                    'tg_design_style' => 'layout-3'
                ]
            ]
        );

        $this->add_control(
            'advertisement_thumb',
            [
                'label' => esc_html__('Upload Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'advertisement_url',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => esc_html__('Advertisement URL', 'genixcore'),
                'default' => esc_html__('#', 'genixcore'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->end_controls_section();

        // Match Group
        $this->start_controls_section(
            '__tg_match_group',
            [
                'label' => esc_html__('Match Lists', 'genixcore'),
                'condition' => [
                    'tg_design_style' => 'layout-2'
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'match_thumb',
            [
                'label' => esc_html__('Upload Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'match_title',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => esc_html__('Match Title', 'genixcore'),
                'default' => esc_html__('FoxTie Max', 'genixcore'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'match_price',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => esc_html__('Match Prize', 'genixcore'),
                'default' => esc_html__('$ 7500', 'genixcore'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'match_url',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => esc_html__('Match URL', 'genixcore'),
                'default' => esc_html__('#', 'genixcore'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'live_url',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => esc_html__('Live URL', 'genixcore'),
                'default' => esc_html__('https://www.youtube.com/watch?v=a3_o4SpV1vI', 'genixcore'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'item_lists',
            [
                'label' => esc_html__('Match Lists', 'genixcore'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'match_title' => esc_html__('FoxTie Max', 'genixcore'),
                    ],
                    [
                        'match_title' => esc_html__('Hatax ninja', 'genixcore'),
                    ],
                    [
                        'match_title' => esc_html__('Spartan ii', 'genixcore'),
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // Style TAB
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'genixcore'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_transform',
            [
                'label' => esc_html__('Text Transform', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('None', 'genixcore'),
                    'uppercase' => esc_html__('UPPERCASE', 'genixcore'),
                    'lowercase' => esc_html__('lowercase', 'genixcore'),
                    'capitalize' => esc_html__('Capitalize', 'genixcore'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'text-transform: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

?>

        <aside class="tournament__sidebar">
            <?php if ($settings['tg_design_style']  == 'layout-2') : ?>

                <div class="shop__widget">
                    <?php if (!empty($settings['widget_title'])) : ?>
                        <h4 class="shop__widget-title"><?php echo esc_html($settings['widget_title']); ?></h4>
                    <?php endif; ?>
                    <div class="shop__widget-inner">
                        <div class="trending__matches-list">
                            <?php foreach ($settings['item_lists'] as $item) : ?>
                                <div class="trending__matches-item">
                                    <?php if (!empty($item['match_thumb']['url'])) : ?>
                                        <div class="trending__matches-thumb">
                                            <a href="<?php echo esc_url($item['match_url']) ?>"><img src="<?php echo esc_url($item['match_thumb']['url']) ?>" alt="<?php echo esc_attr__('Image', 'genixcore') ?>"></a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="trending__matches-content">
                                        <div class="info">
                                            <h5 class="title"><a href="<?php echo esc_url($item['match_url']) ?>"><?php echo esc_html($item['match_title']); ?></a></h5>
                                            <span class="price"><?php echo esc_html($item['match_price']); ?></span>
                                        </div>
                                        <?php if (!empty($item['live_url'])) : ?>
                                            <div class="play">
                                                <a href="<?php echo esc_url($item['live_url']) ?>" class="popup-video"><i class="far fa-play-circle"></i></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            <?php elseif ($settings['tg_design_style']  == 'layout-3') : ?>

                <div class="shop__widget">
                    <?php if (!empty($settings['widget_title'])) : ?>
                        <h4 class="shop__widget-title"><?php echo esc_html($settings['widget_title']); ?></h4>
                    <?php endif; ?>
                    <div class="shop__widget-inner">
                        <div class="tournament__advertisement">
                            <a href="<?php echo esc_url($settings['advertisement_url']) ?>"><img src="<?php echo esc_url($settings['advertisement_thumb']['url']) ?>" alt="img"></a>
                        </div>
                    </div>
                </div>

            <?php else : ?>

                <div class="shop__widget">
                    <?php if (!empty($settings['widget_title'])) : ?>
                        <h4 class="shop__widget-title"><?php echo esc_html($settings['widget_title']); ?></h4>
                    <?php endif; ?>
                    <div class="shop__widget-inner">
                        <form method="get" action="<?php print esc_url(home_url('/')); ?>" class="shop__search">
                            <input type="text" name="s" value="<?php print esc_attr(get_search_query()) ?>" placeholder="<?php echo esc_attr($settings['search_placeholder']); ?>">
                            <button class="p-0 border-0"><i class="flaticon-search"></i></button>
                        </form>
                    </div>
                </div>

            <?php endif; ?>
        </aside>

<?php
    }
}

$widgets_manager->register(new TG_TournamentSidebar());
