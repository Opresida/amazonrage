<?php

/**
 * The main template file
 *
 * @package  WordPress
 * @subpackage  genixcore
 */

get_header();

?>

<?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
        <!-- project-details-area -->
        <section class="project-details-area pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- project-details-area-end -->

    <?php endwhile; wp_reset_query();
endif;
?>


<?php get_footer();  ?>