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
class TG_ABOUT_TAB extends Widget_Base
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
        return 'tg-about-tab';
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
        return __('About Tab', 'genixcore');
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
        return 'genix-icon eicon-tabs';
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

        // About Section
        $this->start_controls_section(
            'tg_about_group',
            [
                'label' => esc_html__('About Group', 'genixcore'),
            ]
        );

        $this->add_control(
            'is_click_sound',
            [
                'label' => esc_html__('Show Sound', 'genixcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'genixcore'),
                'label_off' => esc_html__('Hide', 'genixcore'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'tab_image',
            [
                'label' => esc_html__('Tab Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->start_controls_tabs(
            '_tab_style_tabs_box'
        );
        $repeater->start_controls_tab(
            '_tab_content_default',
            [
                'label' => esc_html__('Content', 'genixcore'),
            ]
        );

        $repeater->add_control(
            'content_title',
            [
                'label' => esc_html__('Main Title', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Human game', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content_rate',
            [
                'label' => esc_html__('Sub Title', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Rate 50%', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content_desc',
            [
                'label' => esc_html__('Description', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consteur adipiscing Duis elementum sollicitudin is yaugue euismods Nulla ullamcorper. Morbi pharetra tellus miolslis, tincidunt massa venenatis.', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content_image',
            [
                'label' => esc_html__('Content Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            '_tab_button_grp',
            [
                'label' => esc_html__('Item List', 'genixcore'),
            ]
        );

        $repeater->add_control(
            'list_img01',
            [
                'label' => esc_html__('Image Icon', 'genixcore'),
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
            'list_text01',
            [
                'label' => esc_html__('List Content', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Chichi Dragon Ball', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'list_img02',
            [
                'label' => esc_html__('Image Icon 02', 'genixcore'),
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
            'list_text02',
            [
                'label' => esc_html__('List Content 02', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Space Babe Night', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'list_img03',
            [
                'label' => esc_html__('Image Icon 03', 'genixcore'),
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
            'list_text03',
            [
                'label' => esc_html__('List Content 03', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Dragon Ball', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            '_tab_content_btn',
            [
                'label' => esc_html__('Button', 'genixcore'),
            ]
        );

        $repeater->add_control(
            'tab_btn01',
            [
                'label' => esc_html__('Button Text', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Dragon Ball', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_btn_url01',
            [
                'label' => esc_html__('Button URL', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('#', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_btn02',
            [
                'label' => esc_html__('Button Text 02', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Nft market', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_btn_url02',
            [
                'label' => esc_html__('Button URL 02', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('#', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_btn03',
            [
                'label' => esc_html__('Button Text 03', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Support', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_btn_url03',
            [
                'label' => esc_html__('Button URL 03', 'genixcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('#', 'genixcore'),
                'label_block' => true,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'abouts_list',
            [
                'label' => esc_html__('Roadmap List', 'genixcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' =>  $repeater->get_controls(),
                'default' => [
                    [
                        'content_title' => esc_html__('Human game', 'genixcore'),
                    ],
                    [
                        'content_title' => esc_html__('Axie Infinity', 'genixcore'),
                    ],
                    [
                        'content_title' => esc_html__('The Walking Dead', 'genixcore'),
                    ],

                ],
                'title_field' => '{{{ content_title }}}',
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
        $settings = $this->get_settings_for_display(); ?>

        <?php if (!empty($settings['is_click_sound'])) : ?>
            <script>
                jQuery(document).ready(function($) {
                    $('.about__tab-wrap ul button').on('click', () => new Audio('<?php echo get_template_directory_uri(); ?>/assets/audio/tab.mp3').play());
                });
            </script>
        <?php endif; ?>

        <div class="about__area">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="about__tab-wrap">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <?php foreach ($settings['abouts_list'] as $key => $tab) :
                                $active = ($key == 0) ? 'active' : '';
                            ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?php echo esc_attr($active); ?>" id="about-tab-<?php echo esc_attr($key); ?>" data-bs-toggle="tab" data-bs-target="#about-<?php echo esc_attr($key); ?>" type="button" role="tab" aria-controls="about-<?php echo esc_attr($key); ?>" aria-selected="true"><span class="img-shape"></span><img src="<?php echo esc_url($tab['tab_image']['url']) ?>" width="77" alt="<?php echo esc_attr__('Image', 'genixcore') ?>"></button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="myTabContent">
                <?php foreach ($settings['abouts_list'] as $key => $tab) :
                    $active = ($key == 0) ? 'show active' : '';
                ?>
                    <div class="tab-pane <?php echo esc_attr($active); ?>" id="about-<?php echo esc_attr($key); ?>" role="tabpanel" aria-labelledby="about-tab-<?php echo esc_attr($key); ?>">
                        <div class="row justify-content-center">
                            <?php if (!empty($tab['content_image']['url'])) : ?>
                                <div class="col-xl-5 col-lg-10">
                                    <div class="about__img">
                                        <img src="<?php echo esc_url($tab['content_image']['url']) ?>" alt="<?php echo esc_attr__('Image', 'genixcore') ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="col-xl-7 col-lg-10">
                                <div class="about__flex-wrap">
                                    <div class="about__content-wrap">
                                        <div class="about__content">
                                            <h4 class="title"><?php echo genix_kses($tab['content_title']); ?></h4>
                                            <span class="rate"><?php echo genix_kses($tab['content_rate']); ?></span>
                                            <p><?php echo genix_kses($tab['content_desc']); ?></p>
                                        </div>
                                        <div class="about__content-list">
                                            <ul class="list-wrap">
                                                <li><?php if (!empty($tab['list_img01']['url'])) : ?><img src="<?php echo esc_url($tab['list_img01']['url']) ?>" width="45" alt="<?php echo esc_attr__('Image', 'genixcore') ?>"><?php endif; ?> <?php echo genix_kses($tab['list_text01']); ?></li>
                                                <li><?php if (!empty($tab['list_img02']['url'])) : ?><img src="<?php echo esc_url($tab['list_img02']['url']) ?>" width="45" alt="<?php echo esc_attr__('Image', 'genixcore') ?>"><?php endif; ?> <?php echo genix_kses($tab['list_text02']); ?></li>
                                                <li><?php if (!empty($tab['list_img03']['url'])) : ?><img src="<?php echo esc_url($tab['list_img03']['url']) ?>" width="45" alt="<?php echo esc_attr__('Image', 'genixcore') ?>"><?php endif; ?> <?php echo genix_kses($tab['list_text03']); ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="about__btn-wrap">
                                        <ul class="list-wrap">
                                            <?php if (!empty($tab['tab_btn_url01'])) : ?>
                                                <li><a href="<?php echo esc_url($tab['tab_btn_url01']); ?>" target="_blank"><?php echo genix_kses($tab['tab_btn01']); ?></a></li>
                                            <?php endif; ?>
                                            <?php if (!empty($tab['tab_btn_url02'])) : ?>
                                                <li><a href="<?php echo esc_url($tab['tab_btn_url02']); ?>" target="_blank"><?php echo genix_kses($tab['tab_btn02']); ?></a></li>
                                            <?php endif; ?>
                                            <?php if (!empty($tab['tab_btn_url03'])) : ?>
                                                <li><a href="<?php echo esc_url($tab['tab_btn_url03']); ?>" target="_blank"><?php echo genix_kses($tab['tab_btn03']); ?></a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

<?php
    }
}

$widgets_manager->register(new TG_ABOUT_TAB());
