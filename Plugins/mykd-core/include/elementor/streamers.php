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
class TG_STREAMERS extends Widget_Base
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
        return 'tg-streamers';
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
        return __('Streamers', 'genixcore');
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
        return 'genix-icon eicon-person';
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

        // member list
        $this->start_controls_section(
            '_section_streamers',
            [
                'label' => esc_html__('Streamers', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => esc_html__('Streamer Image', 'genixcore'),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'streamer_name',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => esc_html__('Streamer Name', 'genixcore'),
                'default' => esc_html__('Sky hunter', 'genixcore'),
                'placeholder' => esc_html__('Type name here', 'genixcore'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'streamer_url',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => esc_html__('Streamer URL', 'genixcore'),
                'default' => esc_html__('#', 'genixcore'),
                'placeholder' => esc_html__('Type url here', 'genixcore'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        // REPEATER
        $this->add_control(
            'streamers_lists',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'streamer_name' => esc_html__('Sky hunter', 'genixcore'),
                    ],
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'streamer_name' => esc_html__('Phoenix', 'genixcore'),
                    ],
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'streamer_name' => esc_html__('Max Jett', 'genixcore'),
                    ],
                    [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'streamer_name' => esc_html__('Brimstone', 'genixcore'),
                    ],
                ],
                'title_field' => '{{{ streamer_name }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium_large',
                'separator' => 'before',
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
        $settings = $this->get_settings_for_display(); ?>


        <script>
            jQuery(document).ready(function($) {

                /*=============================================
                    =        Streamers Active		      =
                =============================================*/
                var streamersSwiper = new Swiper('.streamers-active', {
                    // Optional parameters
                    observer: true,
                    observeParents: true,
                    loop: true,
                    slidesPerView: 5,
                    spaceBetween: 20,
                    breakpoints: {
                        '1500': {
                            slidesPerView: 5,
                        },
                        '1200': {
                            slidesPerView: 4,
                        },
                        '992': {
                            slidesPerView: 4,
                        },
                        '768': {
                            slidesPerView: 3,
                        },
                        '576': {
                            slidesPerView: 2,
                        },
                        '0': {
                            slidesPerView: 1.5,
                            centeredSlides: true,
                            centeredSlidesBounds: true,
                        },
                    },
                    // If we need pagination
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // Navigation arrows
                    navigation: {
                        nextEl: ".slider-button-next",
                        prevEl: ".slider-button-prev",
                    },
                });

            });
        </script>

        <div class="swiper-container streamers-active">
            <div class="swiper-wrapper">
                <?php foreach ($settings['streamers_lists'] as $item) :

                    if (!empty($item['image']['url'])) {
                        $genix_streamer_image_url = !empty($item['image']['id']) ? wp_get_attachment_image_url($item['image']['id'], $settings['thumbnail_size']) : $item['image']['url'];
                        $genix_streamer_image_alt = get_post_meta($item["image"]["id"], "_wp_attachment_image_alt", true);
                    }
                ?>
                    <div class="swiper-slide">
                        <div class="streamers__item">
                            <?php if (!empty($genix_streamer_image_url)) : ?>
                                <div class="streamers__thumb">
                                    <a href="<?php echo esc_url($item['streamer_url']); ?>">
                                        <img src="<?php echo esc_url($genix_streamer_image_url); ?>" alt="<?php echo esc_attr($genix_streamer_image_alt); ?>">
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="streamers__content">
                                <h4 class="name"><?php echo genix_kses($item['streamer_name']); ?></h4>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="streamers__pagination">
            <div class="slider-button-prev streamers__pagination-arrow"><i class="fas fa-angle-left"></i></div>
            <div class="swiper-pagination streamers__pagination-dots"></div>
            <div class="slider-button-next streamers__pagination-arrow"><i class="fas fa-angle-right"></i></div>
        </div>

<?php
    }
}

$widgets_manager->register(new TG_STREAMERS());
