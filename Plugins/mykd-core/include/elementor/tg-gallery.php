<?php

namespace GenixCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
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
class TG_GALLERY extends Widget_Base
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
        return 'tg-gallery';
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
        return __('MYKD Gallery', 'genixcore');
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
        return 'genix-icon eicon-slider-push';
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
                'options' => [
                    'layout-1' => esc_html__('Layout 1', 'genixcore'),
                    'layout-2' => esc_html__('Layout 2', 'genixcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // genix_section_title
        $this->start_controls_section(
            'genix_section_title',
            [
                'label' => esc_html__('Title & Content', 'genixcore'),
                'condition' => [
                    'tg_design_style' => 'layout-2',
                ]
            ]
        );

        $this->add_control(
            'heading_animation',
            [
                'label' => esc_html__('Animation Effect', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'yes' => esc_html__('Yes', 'genixcore'),
                    'no' => esc_html__('No', 'genixcore'),
                ],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'tg_title',
            [
                'label' => esc_html__('Title', 'genixcore'),
                'description' => genix_get_allowed_html_desc('intermediate'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Mykd Title Here', 'genixcore'),
                'placeholder' => esc_html__('Type Heading Text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tg_sub_title',
            [
                'label' => esc_html__('Sub Title', 'genixcore'),
                'description' => genix_get_allowed_html_desc('intermediate'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Mykd Sub Title Here', 'genixcore'),
                'placeholder' => esc_html__('Type Heading Text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tg_title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'genixcore'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'h1' => [
                        'title' => esc_html__('H1', 'genixcore'),
                        'icon' => 'eicon-editor-h1'
                    ],
                    'h2' => [
                        'title' => esc_html__('H2', 'genixcore'),
                        'icon' => 'eicon-editor-h2'
                    ],
                    'h3' => [
                        'title' => esc_html__('H3', 'genixcore'),
                        'icon' => 'eicon-editor-h3'
                    ],
                    'h4' => [
                        'title' => esc_html__('H4', 'genixcore'),
                        'icon' => 'eicon-editor-h4'
                    ],
                    'h5' => [
                        'title' => esc_html__('H5', 'genixcore'),
                        'icon' => 'eicon-editor-h5'
                    ],
                    'h6' => [
                        'title' => esc_html__('H6', 'genixcore'),
                        'icon' => 'eicon-editor-h6'
                    ]
                ],
                'default' => 'h2',
                'toggle' => false,
            ]
        );

        $this->end_controls_section();

        // Gallery Group
        $this->start_controls_section(
            '__gallery_list',
            [
                'label' => esc_html__('Gallery List', 'genixcore'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'tg_gallery_image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => esc_html__('Gallery Image', 'genixcore'),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'gallery_name',
            [
                'label' => esc_html__('Item Title', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Pubg tournament', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'gallery_desc',
            [
                'label' => esc_html__('Item Desc', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Rate 50%', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'gallery_list',
            [
                'label' => esc_html__('Gallery List', 'genixcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' =>  $repeater->get_controls(),
                'default' => [
                    [
                        'gallery_name' => esc_html__('Pubg tournament', 'genixcore'),
                        'gallery_desc' => esc_html__('rate 50%', 'genixcore'),
                    ],
                    [
                        'gallery_name' => esc_html__('Assassins Creed', 'genixcore'),
                        'gallery_desc' => esc_html__('rate 65%', 'genixcore'),
                    ],
                    [
                        'gallery_name' => esc_html__('World of Warcraft', 'genixcore'),
                        'gallery_desc' => esc_html__('rate 60%', 'genixcore'),
                    ],

                ],
                'title_field' => '{{{ gallery_name }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'full',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ]
            ]
        );

        $this->end_controls_section();

        // Style
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'genixcore'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'section_padding',
            [
                'label' => esc_html__('Section Padding', 'genixcore'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .project-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'tg_design_style' => 'layout-2',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_background',
                'selector' => '{{WRAPPER}} .project-area',
                'exclude' => [
                    'image'
                ],
                'condition' => [
                    'tg_design_style' => 'layout-2',
                ]
            ]
        );

        $this->end_controls_section();

        // Style Tab Here
        $this->start_controls_section(
            '_section_style_content',
            [
                'label' => esc_html__('Title / Content', 'genixcore'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'tg_design_style' => 'layout-2',
                ]
            ]
        );

        // Subtitle
        $this->add_control(
            '_heading_subtitle',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__('Subtitle', 'genixcore'),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'subtitle_spacing',
            [
                'label' => esc_html__('Bottom Spacing', 'genixcore'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Text Color', 'genixcore'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sub-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub-title',
                'selector' => '{{WRAPPER}} .sub-title',
            ]
        );

        // Title
        $this->add_control(
            '_heading_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__('Title', 'genixcore'),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => esc_html__('Bottom Spacing', 'genixcore'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'genixcore'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title',
                'selector' => '{{WRAPPER}} .title',
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


        <?php if ($settings['tg_design_style'] == 'layout-2') :

            $this->add_render_attribute('title_args', 'class', 'title');
            $show_animation = ($settings['heading_animation'] == 'yes') ? 'text' : 'none';
        ?>

            <script>
                jQuery(document).ready(function($) {

                    /*==========================================
                        =        Project Active		      =
                    =============================================*/
                    var $swiperSelector = $('.project-active');

                    $swiperSelector.each(function(index) {
                        var $this = $(this);
                        $this.addClass('swiper-slider-' + index);

                        var dragSize = $this.data('drag-size') ? $this.data('drag-size') : 24;
                        var freeMode = $this.data('free-mode') ? $this.data('free-mode') : false;
                        var loop = $this.data('loop') ? $this.data('loop') : true;
                        var slidesDesktop = $this.data('slides-desktop') ? $this.data('slides-desktop') : 4;
                        var slidesLaptop = $this.data('slides-laptop') ? $this.data('slides-laptop') : 4;
                        var slidesTablet = $this.data('slides-tablet') ? $this.data('slides-tablet') : 3;
                        var slidesSmall = $this.data('slides-small') ? $this.data('slides-small') : 3;
                        var slidesMobile = $this.data('slides-mobile') ? $this.data('slides-mobile') : 2;
                        var slidesXs = $this.data('slides-xs') ? $this.data('slides-xs') : 1.5;
                        var spaceBetween = $this.data('space-between') ? $this.data('space-between') : 15;

                        var swiper = new Swiper('.swiper-slider-' + index, {
                            direction: 'horizontal',
                            loop: loop,
                            freeMode: freeMode,
                            spaceBetween: spaceBetween,
                            observer: true,
                            observeParents: true,
                            breakpoints: {
                                1920: {
                                    slidesPerView: slidesDesktop
                                },
                                1200: {
                                    slidesPerView: slidesLaptop
                                },
                                992: {
                                    slidesPerView: slidesTablet
                                },
                                768: {
                                    slidesPerView: slidesSmall
                                },
                                576: {
                                    slidesPerView: slidesMobile,
                                    centeredSlides: true,
                                    centeredSlidesBounds: true,
                                },
                                0: {
                                    slidesPerView: slidesXs,
                                    centeredSlides: true,
                                    centeredSlidesBounds: true,
                                }
                            },
                            navigation: {
                                nextEl: '.slider-button-next',
                                prevEl: '.slider-button-prev'
                            },
                            scrollbar: {
                                el: '.swiper-scrollbar',
                                draggable: true,
                                dragSize: dragSize
                            }
                        });
                    });

                });
            </script>

            <section class="project-area project-bg section-pt-120 section-pb-140">
                <div class="container custom-container">
                    <div class="project__wrapper">

                        <?php if (!empty($settings['tg_title'] || $settings['tg_sub_title'])) : ?>
                            <div class="section__title text-start">
                                <?php
                                if (!empty($settings['tg_title'])) :
                                    printf(
                                        '<%1$s %2$s>%3$s</%1$s>',
                                        tag_escape($settings['tg_title_tag']),
                                        $this->get_render_attribute_string('title_args'),
                                        genix_kses($settings['tg_title'])
                                    );
                                endif;
                                ?>
                                <?php if (!empty($settings['tg_sub_title'])) : ?>
                                    <span class="sub-title tg__animate-<?php echo esc_attr($show_animation) ?>"><?php echo genix_kses($settings['tg_sub_title']); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="swiper-container project-active">
                            <div class="swiper-wrapper">
                                <?php foreach ($settings['gallery_list'] as $item) :
                                    if (!empty($item['tg_gallery_image']['url'])) {
                                        $tg_gallery_image_url = !empty($item['tg_gallery_image']['id']) ? wp_get_attachment_image_url($item['tg_gallery_image']['id'], $settings['thumbnail_size']) : $item['tg_gallery_image']['url'];
                                        $tg_gallery_image_alt = get_post_meta($item["tg_gallery_image"]["id"], "_wp_attachment_image_alt", true);
                                    }
                                ?>
                                    <div class="swiper-slide">
                                        <div class="project__item">
                                            <a href="<?php echo esc_url($tg_gallery_image_url); ?>" class="popup-image">
                                                <img src="<?php echo esc_url($tg_gallery_image_url); ?>" alt="<?php echo esc_attr($tg_gallery_image_alt) ?>">
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="slider-button-prev">
                            <i class="flaticon-right-arrow"></i>
                            <i class="flaticon-right-arrow"></i>
                        </div>
                    </div>
                </div>
                <div class="swiper-scrollbar"></div>
            </section>

        <?php else : ?>

            <script>
                jQuery(document).ready(function($) {

                    /*==========================================
                        =        Gallery Active		      =
                    =============================================*/
                    var $swiperSelector = $('.gallery-active');

                    $swiperSelector.each(function(index) {
                        var $this = $(this);
                        $this.addClass('swiper-slider-' + index);

                        var dragSize = $this.data('drag-size') ? $this.data('drag-size') : 200;
                        var freeMode = $this.data('free-mode') ? $this.data('free-mode') : false;
                        var loop = $this.data('loop') ? $this.data('loop') : true;
                        var slidesDesktop = $this.data('slides-desktop') ? $this.data('slides-desktop') : 1;
                        var slidesTablet = $this.data('slides-tablet') ? $this.data('slides-tablet') : 1;
                        var slidesMobile = $this.data('slides-mobile') ? $this.data('slides-mobile') : 1;
                        var spaceBetween = $this.data('space-between') ? $this.data('space-between') : 1;

                        var swiper = new Swiper('.swiper-slider-' + index, {
                            direction: 'horizontal',
                            loop: loop,
                            freeMode: freeMode,
                            centeredSlides: true,
                            spaceBetween: spaceBetween,
                            observer: true,
                            observeParents: true,
                            breakpoints: {
                                1920: {
                                    slidesPerView: slidesDesktop
                                },
                                992: {
                                    slidesPerView: slidesTablet
                                },
                                320: {
                                    slidesPerView: slidesMobile
                                }
                            },
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev'
                            },
                            scrollbar: {
                                el: '.swiper-scrollbar',
                                draggable: true,
                                dragSize: dragSize
                            }
                        });
                    });

                });
            </script>

            <div class="gallery__slider">
                <div class="container p-0">
                    <div class="row justify-content-center">
                        <div class="col-xl-9 col-lg-10 col-md-11">
                            <div class="swiper-container gallery-active">
                                <div class="swiper-wrapper">
                                    <?php foreach ($settings['gallery_list'] as $item) :
                                        if (!empty($item['tg_gallery_image']['url'])) {
                                            $tg_gallery_image_url = !empty($item['tg_gallery_image']['id']) ? wp_get_attachment_image_url($item['tg_gallery_image']['id'], $settings['thumbnail_size']) : $item['tg_gallery_image']['url'];
                                            $tg_gallery_image_alt = get_post_meta($item["tg_gallery_image"]["id"], "_wp_attachment_image_alt", true);
                                        }
                                    ?>
                                        <div class="swiper-slide">
                                            <div class="gallery__item">
                                                <div class="gallery__thumb">
                                                    <a href="<?php echo esc_url($tg_gallery_image_url); ?>" data-cursor="-theme" data-cursor-text="<?php echo esc_attr__('View <br> Image', 'genixcore') ?>" class="popup-image" title="<?php echo genix_kses($item['gallery_name']); ?>">
                                                        <img src="<?php echo esc_url($tg_gallery_image_url); ?>" alt="<?php echo esc_attr($tg_gallery_image_alt) ?>">
                                                    </a>
                                                </div>
                                                <div class="gallery__content">
                                                    <?php if (!empty($item['gallery_name'])) : ?>
                                                        <h3 class="title">
                                                            <?php echo genix_kses($item['gallery_name']); ?>
                                                        </h3>
                                                    <?php endif; ?>
                                                    <?php if (!empty($item['gallery_desc'])) : ?>
                                                        <span class="rate">
                                                            <?php echo genix_kses($item['gallery_desc']); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="swiper-scrollbar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

<?php
    }
}

$widgets_manager->register(new TG_GALLERY());
