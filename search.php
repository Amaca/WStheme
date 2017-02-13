<?php get_header(); ?>

<!-- Grid Search -->
<section class="grid portfolio-grid">
    <div class="container">

        <div class="row">

            <?php while ( have_posts() ) : the_post();  ?>

            <?php the_title(); ?>

            <?php endwhile;  ?>

        </div>

        <?php pagination(); ?>

    </div>
</section>
<!-- /Grid Search -->

<?php get_footer(); ?>
