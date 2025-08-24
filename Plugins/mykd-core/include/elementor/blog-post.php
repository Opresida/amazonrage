<?php

namespace GenixCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Mykd Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Genix_Blog_Post extends Widget_Base
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
        return 'blogpost';
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
        return __('Blog Post', 'genixcore');
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
        return 'genix-icon';
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
                    'layout-3' => esc_html__('Layout 3', 'genixcore'),
                    'layout-4' => esc_html__('Layout 4', 'genixcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // Blog Query
        $this->start_controls_section(
            'genix_post_query',
            [
                'label' => esc_html__('Blog Query', 'genixcore'),
            ]
        );

        $post_type = 'post';
        $taxonomy = 'category';

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Per Page', 'genixcore'),
                'description' => esc_html__('Leave blank or enter -1 for all.', 'genixcore'),
                'type' => Controls_Manager::NUMBER,
                'default' => '3',
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => esc_html__('Include Categories', 'genixcore'),
                'description' => esc_html__('Select a category to include or leave blank for all.', 'genixcore'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => genix_get_categories($taxonomy),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'exclude_category',
            [
                'label' => esc_html__('Exclude Categories', 'genixcore'),
                'description' => esc_html__('Select a category to exclude', 'genixcore'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => genix_get_categories($taxonomy),
                'label_block' => true
            ]
        );

        $this->add_control(
            'post__not_in',
            [
                'label' => esc_html__('Exclude Item', 'genixcore'),
                'type' => Controls_Manager::SELECT2,
                'options' => genix_get_all_types_post($post_type),
                'multiple' => true,
                'label_block' => true
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => esc_html__('Offset', 'genixcore'),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'ID' => 'Post ID',
                    'author' => 'Post Author',
                    'title' => 'Title',
                    'date' => 'Date',
                    'modified' => 'Last Modified Date',
                    'parent' => 'Parent Id',
                    'rand' => 'Random',
                    'comment_count' => 'Comment Count',
                    'menu_order' => 'Menu Order',
                ),
                'default' => 'date',
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc'     => esc_html__('Ascending', 'genixcore'),
                    'desc'     => esc_html__('Descending', 'genixcore')
                ],
                'default' => 'desc',

            ]
        );

        $this->add_control(
            'ignore_sticky_posts',
            [
                'label' => esc_html__('Ignore Sticky Posts', 'genixcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'genixcore'),
                'label_off' => esc_html__('No', 'genixcore'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'genix_blog_title_word',
            [
                'label' => esc_html__('Title Word Count', 'genixcore'),
                'description' => esc_html__('Set how many word you want to display!', 'genixcore'),
                'type' => Controls_Manager::NUMBER,
                'default' => '6',
            ]
        );

        $this->add_control(
            'genix_post_content',
            [
                'label' => esc_html__('Content', 'genixcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'genixcore'),
                'label_off' => esc_html__('Hide', 'genixcore'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'genix_post_content_limit',
            [
                'label' => esc_html__('Content Limit', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '12',
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'genix_post_content' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'exclude' => ['custom'],
                'default' => 'full',
            ]
        );

        $this->end_controls_section();

        // style control
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

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } else if (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        // include_categories
        $category_list = '';
        if (!empty($settings['category'])) {
            $category_list = implode(", ", $settings['category']);
        }
        $category_list_value = explode(" ", $category_list);

        // exclude_categories
        $exclude_categories = '';
        if (!empty($settings['exclude_category'])) {
            $exclude_categories = implode(", ", $settings['exclude_category']);
        }
        $exclude_category_list_value = explode(" ", $exclude_categories);

        $post__not_in = '';
        if (!empty($settings['post__not_in'])) {
            $post__not_in = $settings['post__not_in'];
            $args['post__not_in'] = $post__not_in;
        }
        $posts_per_page = (!empty($settings['posts_per_page'])) ? $settings['posts_per_page'] : '-1';
        $orderby = (!empty($settings['orderby'])) ? $settings['orderby'] : 'post_date';
        $order = (!empty($settings['order'])) ? $settings['order'] : 'desc';
        $offset_value = (!empty($settings['offset'])) ? $settings['offset'] : '0';
        $ignore_sticky_posts = (!empty($settings['ignore_sticky_posts']) && 'yes' == $settings['ignore_sticky_posts']) ? true : false;


        // number
        $off = (!empty($offset_value)) ? $offset_value : 0;
        $offset = $off + (($paged - 1) * $posts_per_page);
        $p_ids = array();

        // build up the array
        if (!empty($settings['post__not_in'])) {
            foreach ($settings['post__not_in'] as $p_idsn) {
                $p_ids[] = $p_idsn;
            }
        }

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset,
            'paged' => $paged,
            'post__not_in' => $p_ids,
            'ignore_sticky_posts' => $ignore_sticky_posts
        );

        // exclude_categories
        if (!empty($settings['exclude_category'])) {

            // Exclude the correct cats from tax_query
            $args['tax_query'] = array(
                array(
                    'taxonomy'    => 'category',
                    'field'         => 'slug',
                    'terms'        => $exclude_category_list_value,
                    'operator'    => 'NOT IN'
                )
            );

            // Include the correct cats in tax_query
            if (!empty($settings['category'])) {
                $args['tax_query']['relation'] = 'AND';
                $args['tax_query'][] = array(
                    'taxonomy'    => 'category',
                    'field'        => 'slug',
                    'terms'        => $category_list_value,
                    'operator'    => 'IN'
                );
            }
        } else {
            // Include the cats from $cat_slugs in tax_query
            if (!empty($settings['category'])) {
                $args['tax_query'][] = [
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category_list_value,
                ];
            }
        }

        $filter_list = $settings['category'];

        // The Query
        $query = new \WP_Query($args); ?>


        <?php if ($settings['tg_design_style'] == 'layout-2') : ?>

            <?php if ($query->have_posts()) : ?>

                <div class="row justify-content-center">
                    <?php while ($query->have_posts()) :
                        $query->the_post();
                        global $post;

                        $categories = get_the_category($post->ID);
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="blog-post-item-two">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="blog-post-thumb-two">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail($post->ID, $settings['thumbnail_size']); ?>
                                        </a>
                                        <?php if (!empty($categories[0]->name)) : ?>
                                            <a href="<?php print esc_url(get_category_link($categories[0]->term_id)); ?>" class="tag tag-two"><?php echo esc_html($categories[0]->name); ?></a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="blog-post-content-two">
                                    <h2 class="title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['genix_blog_title_word'], ''); ?></a></h2>

                                    <?php if (!empty($settings['genix_post_content'])) :
                                        $genix_post_content_limit = (!empty($settings['genix_post_content_limit'])) ? $settings['genix_post_content_limit'] : '';
                                    ?>
                                        <p><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $genix_post_content_limit, ''); ?></p>
                                    <?php endif; ?>

                                    <div class="blog-meta">
                                        <ul class="list-wrap">
                                            <li>
                                                <a href="<?php print esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><img src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'), ['size' => '40'])); ?>" alt="<?php the_author(); ?>"><?php print get_the_author(); ?></a>
                                            </li>
                                            <li><i class="far fa-calendar"></i><?php the_time(get_option('date_format')); ?></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>

            <?php endif; ?>


        <?php elseif ($settings['tg_design_style'] == 'layout-3') : ?>

            <?php if ($query->have_posts()) : ?>

                <div class="row justify-content-center">
                    <?php while ($query->have_posts()) :
                        $query->the_post();
                        global $post;

                        $categories = get_the_category($post->ID);
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="blog-post-item-four">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="blog-post-thumb-four">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail($post->ID, $settings['thumbnail_size']); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="blog-post-content-four">
                                    <?php if (!empty($categories[0]->name)) : ?>
                                        <a href="<?php print esc_url(get_category_link($categories[0]->term_id)); ?>" class="tag tag-two"><?php echo esc_html($categories[0]->name); ?></a>
                                    <?php endif; ?>
                                    <div class="blog-meta-two">
                                        <ul class="list-wrap">
                                            <li><i class="far fa-calendar"></i><?php the_time(get_option('date_format')); ?></li>
                                            <li><i class="far fa-user"></i>by <a href="<?php print esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php print get_the_author(); ?></a></li>
                                        </ul>
                                    </div>
                                    <h4 class="title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['genix_blog_title_word'], ''); ?></a></h4>
                                    <a href="<?php the_permalink(); ?>" class="link-btn"><?php echo esc_html__('Read More', 'genixcore') ?> <i class="flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>

            <?php endif; ?>


        <?php elseif ($settings['tg_design_style'] == 'layout-4') : ?>

            <?php if ($query->have_posts()) : ?>

                <div class="row justify-content-center">
                    <?php while ($query->have_posts()) :
                        $query->the_post();
                        global $post;

                        $categories = get_the_category($post->ID);
                    ?>

                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="blog-post-item">

                                <div class="blog-post-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail($post->ID, $settings['thumbnail_size']); ?>
                                    </a>
                                    <span class="date"><strong><?php the_time('j'); ?></strong><?php the_time('M'); ?></span>
                                </div>

                                <div class="blog-post-content">
                                    <?php if (!empty($categories[0]->name)) : ?>
                                        <a href="<?php print esc_url(get_category_link($categories[0]->term_id)); ?>" class="tag"><?php echo esc_html($categories[0]->name); ?></a>
                                    <?php endif; ?>

                                    <h2 class="title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['genix_blog_title_word'], ''); ?></a></h2>

                                    <?php if (!empty($settings['genix_post_content'])) :
                                        $genix_post_content_limit = (!empty($settings['genix_post_content_limit'])) ? $settings['genix_post_content_limit'] : '';
                                    ?>
                                        <p><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $genix_post_content_limit, ''); ?></p>
                                    <?php endif; ?>

                                    <a href="<?php the_permalink(); ?>" class="link-btn"><?php echo esc_html__('Read More', 'genixcore') ?> <i class="flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>

            <?php endif; ?>


        <?php else : ?>

            <?php if ($query->have_posts()) : ?>

                <div class="row justify-content-center home-one-post">
                    <?php while ($query->have_posts()) :
                        $query->the_post();
                        global $post;

                        $categories = get_the_category($post->ID);

                        $no_thumbnail = (has_post_thumbnail()) ? 'has-thumb' : 'no-thumb';
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="blog-post-item-two">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="blog-post-thumb-two">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail($post->ID, $settings['thumbnail_size']); ?>
                                        </a>
                                        <?php if (!empty($categories[0]->name)) : ?>
                                            <a href="<?php print esc_url(get_category_link($categories[0]->term_id)); ?>" class="tag"><?php echo esc_html($categories[0]->name); ?></a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="blog-post-content-two">
                                    <h2 class="title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['genix_blog_title_word'], ''); ?></a></h2>

                                    <?php if (!empty($settings['genix_post_content'])) :
                                        $genix_post_content_limit = (!empty($settings['genix_post_content_limit'])) ? $settings['genix_post_content_limit'] : '';
                                    ?>
                                        <p><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $genix_post_content_limit, ''); ?></p>
                                    <?php endif; ?>

                                    <div class="blog-meta">
                                        <ul class="list-wrap">
                                            <li>
                                                <a href="<?php print esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><img src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'), ['size' => '40'])); ?>" alt="<?php the_author(); ?>"><?php print get_the_author(); ?></a>
                                            </li>
                                            <li><i class="far fa-calendar"></i><?php the_time(get_option('date_format')); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>

            <?php endif; ?>

        <?php endif; ?>

<?php
    }
}

$widgets_manager->register(new Genix_Blog_Post());
