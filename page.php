<?php get_header(); ?>

<?php while ( have_posts() ) : the_post();  ?>

<!-- Content -->
<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</section>
<!-- /Content -->

<?php endwhile;  ?>

<?php get_footer(); ?>