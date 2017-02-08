<?php get_header(); ?>

<!-- Grid Search -->
<section class="grid portfolio-grid">
    <div class="container">

        <div class="row">

            <?php while ( have_posts() ) : the_post();  ?>

            <?php $is_research = (get_field('research_thumb', $post->ID)); ?>

            <div class="col-md-6 grid-item project <?php if ($is_research) { echo 'project-research'; }  ?>">
                <a href="<?php the_permalink(); ?>">
                    <?php 
                    if (get_field('proj_thumb', $post->ID)) {
                        $thumbnail = get_field('proj_thumb', $post->ID);
                    } else if (get_field('research_thumb', $post->ID)) {
                        $thumbnail = get_field('research_thumb', $post->ID);
                    }
                    ?>
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAJAQAAAAATUZGfAAAAAnRSTlMAAQGU/a4AAAANSURBVHgBY/j/HxcCAPIoEe+JMKgiAAAAAElFTkSuQmCC" data-lazy="<?php echo $thumbnail ?>" alt="<?php the_title(); ?>" class="project-img" />
                    <h2 class="project-tit">
                        <?php the_title(); ?>
                    </h2>
                    <?php
                      if ($is_research) {
                          echo '<h3>Research Project</h3>';
                      }
                    ?>
                </a>
            </div>

            <?php endwhile;  ?>

        </div>

        <?php pagination(); ?>

    </div>
</section>
<!-- /Grid Search -->

<?php get_footer(); ?>
