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
class TEAM_VS extends Widget_Base
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
        return 'team-vs';
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
        return __('Team VS', 'genixcore');
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
        return 'genix-icon eicon-flip';
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

        // _tg_left_team
        $this->start_controls_section(
            '_tg_left_team',
            [
                'label' => esc_html__('Left Team', 'genixcore'),
            ]
        );

        $this->add_control(
            'tg_left_show',
            [
                'label' => esc_html__('Show Left Team', 'genixcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'genixcore'),
                'label_off' => esc_html__('Hide', 'genixcore'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'left_image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => esc_html__('Upload Image', 'genixcore'),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'left_status',
            [
                'label' => esc_html__('Win Status', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Win', 'genixcore'),
                'placeholder' => esc_html__('Type win text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'left_title',
            [
                'label' => esc_html__('Name', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Black hunt', 'genixcore'),
                'placeholder' => esc_html__('Type name text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'left_price',
            [
                'label' => esc_html__('Price', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('$500 000', 'genixcore'),
                'placeholder' => esc_html__('Type price text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'left_url',
            [
                'label' => esc_html__('Team URL', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('#', 'genixcore'),
                'placeholder' => esc_html__('Type url text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // _tg_right_team
        $this->start_controls_section(
            '_tg_right_team',
            [
                'label' => esc_html__('Right Team', 'genixcore'),
            ]
        );

        $this->add_control(
            'tg_right_show',
            [
                'label' => esc_html__('Show Right Team', 'genixcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'genixcore'),
                'label_off' => esc_html__('Hide', 'genixcore'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'right_image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => esc_html__('Upload Image', 'genixcore'),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'right_status',
            [
                'label' => esc_html__('Win Status', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('2ND', 'genixcore'),
                'placeholder' => esc_html__('Type win text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'right_title',
            [
                'label' => esc_html__('Name', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Black hunt', 'genixcore'),
                'placeholder' => esc_html__('Type name text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'right_price',
            [
                'label' => esc_html__('Price', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('$500 000', 'genixcore'),
                'placeholder' => esc_html__('Type price text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'right_url',
            [
                'label' => esc_html__('Team URL', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('#', 'genixcore'),
                'placeholder' => esc_html__('Type url text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // STYLE TAB
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
        $settings = $this->get_settings_for_display(); ?>

        <div class="row match__result-wrapper justify-content-center">
            <?php if (!empty($settings['tg_left_show'])) : ?>
                <div class="col-xl-5 col-sm-6">
                    <div class="match__winner-wrap">
                        <div class="match__winner-info">
                            <?php if (!empty($settings['left_title'])) : ?>
                                <h4 class="name"><?php echo genix_kses($settings['left_title']); ?></h4>
                            <?php endif; ?>
                            <?php if (!empty($settings['left_price'])) : ?>
                                <span class="price-amount"><?php echo genix_kses($settings['left_price']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="match__winner-img">
                            <div class="team-logo-img">
                                <?php if (!empty($settings['left_image']['url'])) : ?>
                                    <a href="<?php echo esc_url($settings['left_url']) ?>">
                                        <img src="<?php echo esc_url($settings['left_image']['url']) ?>" alt="<?php echo esc_attr__('Image', 'genixcore') ?>">
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="135" height="75" viewBox="0 0 135 75">
                                    <path id="rectangle" class="cls-1" d="M924,1194H809v75H924s20-37.5,20-37.63C944,1231.5,924,1194,924,1194Z" transform="translate(-809 -1194)" />
                                </svg>
                            </div>
                            <?php if (!empty($settings['left_status'])) : ?>
                                <h3 class="match__winner-place"><?php echo genix_kses($settings['left_status']); ?></h3>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($settings['tg_right_show'])) : ?>
                <div class="col-xl-5 col-sm-6">
                    <div class="match__winner-wrap">
                        <div class="match__winner-info">
                            <?php if (!empty($settings['right_title'])) : ?>
                                <h4 class="name"><?php echo genix_kses($settings['right_title']); ?></h4>
                            <?php endif; ?>
                            <?php if (!empty($settings['right_price'])) : ?>
                                <span class="price-amount"><?php echo genix_kses($settings['right_price']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="match__winner-img">
                            <div class="team-logo-img">
                                <?php if (!empty($settings['right_image']['url'])) : ?>
                                    <a href="<?php echo esc_url($settings['right_url']) ?>">
                                        <img src="<?php echo esc_url($settings['right_image']['url']) ?>" alt="<?php echo esc_attr__('Image', 'genixcore') ?>">
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="135" height="75" viewBox="0 0 135 75">
                                    <path id="rectangle" class="cls-1" d="M924,1194H809v75H924s20-37.5,20-37.63C944,1231.5,924,1194,924,1194Z" transform="translate(-809 -1194)" />
                                </svg>
                            </div>
                            <?php if (!empty($settings['right_status'])) : ?>
                                <h3 class="match__winner-place"><?php echo genix_kses($settings['right_status']); ?></h3>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

<?php
    }
}

$widgets_manager->register(new TEAM_VS());
