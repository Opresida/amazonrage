<?php

namespace GenixCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Mykd Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TG_ROADMAP extends Widget_Base
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
        return 'roadmap';
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
        return __('Roadmap', 'genixcore');
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
        return 'genix-icon eicon-toggle';
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

        // Roadmap Active
        $this->start_controls_section(
            '__roadmap_active',
            [
                'label' => esc_html__('Active Status', 'genixcore'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'item_active_status',
            [
                'label' => esc_html__('Is it active?', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'active' => esc_html__('Yes', 'genixcore'),
                    'normal' => esc_html__('No', 'genixcore'),
                ],
                'default' => 'normal',
            ]
        );

        $this->end_controls_section();

        // Roadmap Title
        $this->start_controls_section(
            '__roadmap_heading',
            [
                'label' => esc_html__('Title', 'genixcore'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'roadmap_title',
            [
                'label' => esc_html__('Title', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('season 1', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // Roadmap group
        $this->start_controls_section(
            'roadmap_list',
            [
                'label' => esc_html__('Roadmap List', 'genixcore'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'is_item_active',
            [
                'label' => esc_html__('Is it active?', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'active' => esc_html__('Yes', 'genixcore'),
                    'normal' => esc_html__('No', 'genixcore'),
                ],
                'default' => 'normal',
            ]
        );

        $repeater->add_control(
            'roadmap_name',
            [
                'label' => esc_html__('List Text', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Battle Practice Mode', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'roadamps_list',
            [
                'label' => esc_html__('Roadmap List', 'genixcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' =>  $repeater->get_controls(),
                'default' => [
                    [
                        'roadmap_name' => esc_html__('Battle Practice Mode', 'genixcore'),
                    ],
                    [
                        'roadmap_name' => esc_html__('Android Mobile', 'genixcore'),
                    ],
                    [
                        'roadmap_name' => esc_html__('iOS Open Beta', 'genixcore'),
                    ],

                ],
                'title_field' => '{{{ roadmap_name }}}',
            ]
        );

        $this->end_controls_section();

        // Roadmap Image
        $this->start_controls_section(
            '__roadmap_images',
            [
                'label' => esc_html__('Images', 'genixcore'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'roadmap_image',
            [
                'label' => esc_html__('Roadmap Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'default' => 'full',
                'exclude' => [
                    'custom'
                ]
            ]
        );

        $this->end_controls_section();

        // TAB_STYLE
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'genixcore'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_delay',
            [
                'label' => esc_html__('Animation Delay', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'genixcore'),
                    '.2s' => esc_html__('.2s', 'genixcore'),
                    '.4s' => esc_html__('.4s', 'genixcore'),
                    '.6s' => esc_html__('.6s', 'genixcore'),
                    '.8s' => esc_html__('.8s', 'genixcore'),
                    '1s' => esc_html__('1s', 'genixcore'),
                ],
                'default' => '.2s',
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
        $settings = $this->get_settings_for_display(); ?>

        <div class="roadMap__steps-item wow fadeInUp <?php echo esc_attr($settings['item_active_status']); ?>" data-wow-delay="<?php echo esc_attr($settings['item_delay']) ?>">
            <?php if (!empty($settings['roadmap_title'])) : ?>
                <h3 class="title"><?php echo genix_kses($settings['roadmap_title']); ?></h3>
            <?php endif; ?>
            <ul class="roadMap__list list-wrap">
                <?php foreach ($settings['roadamps_list'] as $item) : ?>
                    <li class="<?php echo esc_attr($item['is_item_active']) ?>">
                        <?php echo genix_kses($item['roadmap_name']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if (!empty($settings['roadmap_image']['url'])) : ?>
                <img src="<?php echo esc_url($settings['roadmap_image']['url']); ?>" alt="<?php echo esc_attr__('Image', 'genixcore') ?>" class="roadMap__steps-img">
            <?php endif; ?>
        </div>

<?php
    }
}

$widgets_manager->register(new TG_ROADMAP());
