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
class Genix_Background_Shape extends Widget_Base
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
        return 'bg-shapes';
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
        return __('Background Shapes', 'genixcore');
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
        return 'genix-icon eicon-shape';
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
            'genix_layout',
            [
                'label' => esc_html__('Design Layout', 'genixcore'),
            ]
        );
        $this->add_control(
            'tg_design_style',
            [
                'label' => esc_html__('Select Layout', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'label_block' => 'true',
                'options' => [
                    'layout-1' => esc_html__('Banner One Shapes', 'genixcore'),
                    'layout-2' => esc_html__('Banner Three Shapes', 'genixcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // _tg_image
        $this->start_controls_section(
            '_tg_image_section',
            [
                'label' => esc_html__('Image', 'genixcore'),
            ]
        );

        $this->add_control(
            'tg_image',
            [
                'label' => esc_html__('Choose Image', 'genixcore'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'tg_image2',
            [
                'label' => esc_html__('Choose Image 02', 'genixcore'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'tg_image3',
            [
                'label' => esc_html__('Choose Image 03', 'genixcore'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'tg_image4',
            [
                'label' => esc_html__('Choose Image 04', 'genixcore'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tg_image_size',
                'default' => 'full',
                'exclude' => [
                    'custom'
                ]
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
        $settings = $this->get_settings_for_display();

        if (!empty($settings['tg_image']['url'])) {
            $tg_image_url = !empty($settings['tg_image']['id']) ? wp_get_attachment_image_url($settings['tg_image']['id'], $settings['tg_image_size_size']) : $settings['tg_image']['url'];
            $tg_image_alt = get_post_meta($settings["tg_image"]["id"], "_wp_attachment_image_alt", true);
        }

        if (!empty($settings['tg_image2']['url'])) {
            $tg_image_url2 = !empty($settings['tg_image2']['id']) ? wp_get_attachment_image_url($settings['tg_image2']['id'], $settings['tg_image_size_size']) : $settings['tg_image2']['url'];
            $tg_image_alt2 = get_post_meta($settings["tg_image2"]["id"], "_wp_attachment_image_alt", true);
        }

        if (!empty($settings['tg_image3']['url'])) {
            $tg_image_url3 = !empty($settings['tg_image3']['id']) ? wp_get_attachment_image_url($settings['tg_image3']['id'], $settings['tg_image_size_size']) : $settings['tg_image3']['url'];
            $tg_image_alt3 = get_post_meta($settings["tg_image3"]["id"], "_wp_attachment_image_alt", true);
        }

        if (!empty($settings['tg_image4']['url'])) {
            $tg_image_url4 = !empty($settings['tg_image4']['id']) ? wp_get_attachment_image_url($settings['tg_image4']['id'], $settings['tg_image_size_size']) : $settings['tg_image4']['url'];
            $tg_image_alt4 = get_post_meta($settings["tg_image4"]["id"], "_wp_attachment_image_alt", true);
        }
?>

        <?php if ($settings['tg_design_style'] == 'layout-2') : ?>



        <?php else : ?>

            <div class="slider__shapes">
                <?php if (!empty($tg_image_url)) : ?>
                    <img src="<?php echo esc_url($tg_image_url); ?>" width="35" alt="<?php echo esc_attr($tg_image_alt); ?>">
                <?php endif; ?>

                <?php if (!empty($tg_image_url2)) : ?>
                    <img src="<?php echo esc_url($tg_image_url2); ?>" width="35" alt="<?php echo esc_attr($tg_image_alt2); ?>">
                <?php endif; ?>

                <?php if (!empty($tg_image_url3)) : ?>
                    <img src="<?php echo esc_url($tg_image_url3); ?>" width="33" alt="<?php echo esc_attr($tg_image_alt3); ?>">
                <?php endif; ?>

                <?php if (!empty($tg_image_url4)) : ?>
                    <img src="<?php echo esc_url($tg_image_url4); ?>" width="61" alt="<?php echo esc_attr($tg_image_alt4); ?>">
                <?php endif; ?>
            </div>

        <?php endif; ?>

<?php
    }
}

$widgets_manager->register(new Genix_Background_Shape());
