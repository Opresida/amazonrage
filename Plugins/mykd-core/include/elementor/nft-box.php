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
class TG_NFT extends Widget_Base
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
        return 'tg-nft';
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
        return __('NFT Box', 'genixcore');
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
        return 'genix-icon eicon-parallax';
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

        // NFT group
        $this->start_controls_section(
            '__nft_list',
            [
                'label' => esc_html__('NFT List', 'genixcore'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'tg_design_style' => 'layout-1'
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->start_controls_tabs(
            '_tab_style_member_box_item'
        );

        $repeater->start_controls_tab(
            '_tab_member_info',
            [
                'label' => __('Information', 'genixcore'),
            ]
        );

        $repeater->add_control(
            'nft_image',
            [
                'label' => esc_html__('NFT Image', 'genixcore'),
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
            'nft_name',
            [
                'label' => esc_html__('Item Name', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('wolf gaming art', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'nft_price',
            [
                'label' => esc_html__('Item Price', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('1.002', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'nft_price_currency',
            [
                'label' => esc_html__('Currency', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Eth', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'nft_btn_text',
            [
                'label' => esc_html__('Button Text', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Bid', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'nft_url',
            [
                'label' => esc_html__('Item URL', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('#', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            '_tab_member_links',
            [
                'label' => __('Author', 'genixcore'),
            ]
        );

        $repeater->add_control(
            'nft_author',
            [
                'label' => esc_html__('Author Image', 'genixcore'),
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
            'nft_author_name',
            [
                'label' => esc_html__('Author Name', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Alax Max', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'nft_author_url',
            [
                'label' => esc_html__('Author URL', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('#', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'author_designation',
            [
                'label' => esc_html__('Designation', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Creator', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'nfts_list',
            [
                'label' => esc_html__('NFT List', 'genixcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' =>  $repeater->get_controls(),
                'default' => [
                    [
                        'nft_name' => esc_html__('wolf gaming art', 'genixcore'),
                    ],
                    [
                        'nft_name' => esc_html__('Forest Princess', 'genixcore'),
                    ],
                    [
                        'nft_name' => esc_html__('girl firefly art', 'genixcore'),
                    ],

                ],
                'title_field' => '{{{ nft_name }}}',
            ]
        );

        $this->end_controls_section();

        // NFT group
        $this->start_controls_section(
            '__nft_list2',
            [
                'label' => esc_html__('NFT List', 'genixcore'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'tg_design_style' => 'layout-2'
                ]
            ]
        );

        $repeater2 = new \Elementor\Repeater();

        $repeater2->start_controls_tabs(
            '_tab_style_member_box_item2'
        );

        $repeater2->start_controls_tab(
            '_tab_member_info2',
            [
                'label' => __('Information', 'genixcore'),
            ]
        );

        $repeater2->add_control(
            'nft_image2',
            [
                'label' => esc_html__('NFT Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater2->add_control(
            'nft_bid2',
            [
                'label' => esc_html__('Bid Text', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Last Bid', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater2->add_control(
            'nft_price2',
            [
                'label' => esc_html__('Item Price', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('1.002', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater2->add_control(
            'nft_price_currency2',
            [
                'label' => esc_html__('Currency', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Eth', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater2->add_control(
            'nft_btn_text2',
            [
                'label' => esc_html__('Button Text', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Bid', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater2->add_control(
            'nft_url2',
            [
                'label' => esc_html__('Item URL', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('#', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater2->end_controls_tab();

        $repeater2->start_controls_tab(
            '_tab_member_links2',
            [
                'label' => __('Author', 'genixcore'),
            ]
        );

        $repeater2->add_control(
            'nft_author2',
            [
                'label' => esc_html__('Author Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater2->add_control(
            'nft_author_name2',
            [
                'label' => esc_html__('Author Name', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('King Crypto', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater2->add_control(
            'author_designation2',
            [
                'label' => esc_html__('Designation', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('@Jon Max', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater2->add_control(
            'nft_author_url2',
            [
                'label' => esc_html__('Author URL', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('#', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater2->end_controls_tab();

        $repeater2->end_controls_tabs();

        $this->add_control(
            'nfts_list2',
            [
                'label' => esc_html__('NFT List', 'genixcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' =>  $repeater2->get_controls(),
                'default' => [
                    [
                        'nft_author_name2' => esc_html__('wolf gaming art', 'genixcore'),
                    ],
                    [
                        'nft_author_name2' => esc_html__('Forest Princess', 'genixcore'),
                    ],
                    [
                        'nft_author_name2' => esc_html__('girl firefly art', 'genixcore'),
                    ],

                ],
                'title_field' => '{{{ nft_author_name2 }}}',
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


        <?php if ($settings['tg_design_style'] == 'layout-2') : ?>
            <script>
                jQuery(document).ready(function($) {

                    /*=============================================
                        =        Trending Active		      =
                    =============================================*/
                    var trendSwiper = new Swiper('.trendingNft-active', {
                        // Optional parameters
                        observer: true,
                        observeParents: true,
                        loop: true,
                        slidesPerView: 3,
                        spaceBetween: 30,
                        breakpoints: {
                            '1500': {
                                slidesPerView: 3,
                            },
                            '1200': {
                                slidesPerView: 3,
                            },
                            '992': {
                                slidesPerView: 2,
                            },
                            '768': {
                                slidesPerView: 2,
                            },
                            '576': {
                                slidesPerView: 1,
                            },
                            '0': {
                                slidesPerView: 1,
                            },
                        },
                        // Navigation arrows
                        navigation: {
                            nextEl: ".slider-button-next",
                            prevEl: ".slider-button-prev",
                        },
                    });

                });
            </script>

            <div class="swiper-container trendingNft-active">
                <div class="swiper-wrapper">
                    <?php foreach ($settings['nfts_list2'] as $item) : ?>
                        <div class="swiper-slide">
                            <div class="trendingNft__item">
                                <div class="trendingNft__item-top">
                                    <div class="trendingNft__item-avatar">
                                        <?php if (!empty($item['nft_author2']['url'])) : ?>
                                            <div class="image">
                                                <a href="<?php echo esc_url($item['nft_author_url2']); ?>" target="_blank">
                                                    <img src="<?php echo esc_url($item['nft_author2']['url']); ?>" alt="<?php echo esc_attr__('NFT Author', 'genixcore') ?>">
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="info">
                                            <h6 class="name"><?php echo genix_kses($item['nft_author_name2']); ?></h6>
                                            <a href="<?php echo esc_url($item['nft_author_url2']); ?>" class="userName" target="_blank"><?php echo genix_kses($item['author_designation2']); ?></a>
                                        </div>
                                    </div>
                                    <div class="trendingNft__item-wish">
                                        <a href="<?php echo esc_url($item['nft_url2']); ?>" target="_blank">
                                            <i class="far fa-heart"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php if (!empty($item['nft_image2']['url'])) : ?>
                                    <div class="trendingNft__item-image">
                                        <a href="<?php echo esc_url($item['nft_url2']); ?>" target="_blank">
                                            <img src="<?php echo esc_url($item['nft_image2']['url']); ?>" alt="<?php echo esc_attr__('NFT Image', 'genixcore') ?>">
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="trendingNft__item-bottom">
                                    <div class="trendingNft__item-price">
                                        <?php if (!empty($item['nft_bid2'])) : ?>
                                            <span class="bid"><?php echo genix_kses($item['nft_bid2']); ?></span>
                                        <?php endif; ?>
                                        <h6 class="eth"><i class="fab fa-ethereum"></i> <?php echo genix_kses($item['nft_price2']); ?> <span><?php echo genix_kses($item['nft_price_currency2']); ?></span></h6>
                                    </div>
                                    <a href="<?php echo esc_url($item['nft_url2']); ?>" class="bid-btn" target="_blank"><?php echo genix_kses($item['nft_btn_text2']); ?> <i class="fas fa-long-arrow-alt-right"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php else : ?>

            <div class="nft-item__area">
                <div class="row justify-content-center">
                    <?php foreach ($settings['nfts_list'] as $item) : ?>
                        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-9">
                            <div class="nft-item__box">
                                <?php if (!empty($item['nft_image']['url'])) : ?>
                                    <div class="nft-item__thumb">
                                        <a href="<?php echo esc_url($item['nft_url']); ?>" target="_blank">
                                            <img src="<?php echo esc_url($item['nft_image']['url']); ?>" alt="<?php echo esc_attr__('NFT Image', 'genixcore') ?>">
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="nft-item__content">
                                    <?php if (!empty($item['nft_name'])) : ?>
                                        <h4 class="title">
                                            <a href="<?php echo esc_url($item['nft_url']); ?>" target="_blank"><?php echo genix_kses($item['nft_name']); ?></a>
                                        </h4>
                                    <?php endif; ?>
                                    <div class="nft-item__avatar">
                                        <?php if (!empty($item['nft_author']['url'])) : ?>
                                            <div class="avatar-img">
                                                <a href="<?php echo esc_url($item['nft_author_url']); ?>" target="_blank">
                                                    <img src="<?php echo esc_url($item['nft_author']['url']); ?>" width="38" alt="<?php echo esc_attr__('NFT Author', 'genixcore') ?>">
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="avatar-name">
                                            <h5 class="name">
                                                <a href="<?php echo esc_url($item['nft_author_url']); ?>" target="_blank"><?php echo genix_kses($item['nft_author_name']); ?></a>
                                            </h5>
                                            <?php if (!empty($item['author_designation'])) : ?>
                                                <span class="designation">
                                                    <?php echo genix_kses($item['author_designation']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="nft-item__bid">
                                        <div class="nft-item__price">
                                            <p><?php echo genix_kses($item['nft_price']); ?> <span class="currency"><?php echo genix_kses($item['nft_price_currency']); ?></span></p>
                                            <a href="<?php echo esc_url($item['nft_url']); ?>" class="bid-btn" target="_blank"><?php echo genix_kses($item['nft_btn_text']); ?> <i class="fas fa-long-arrow-alt-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php endif; ?>

<?php
    }
}

$widgets_manager->register(new TG_NFT());
