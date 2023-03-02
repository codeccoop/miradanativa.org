<?php

/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage www.miradanativa.org
 * 
 */

?>

<article class="single-post" <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php

	get_template_part('template-parts/entry-header'); ?>

	<div class="post-heading">
		<div class="post-heading__category">
			<p><?php $cat = get_the_category();
				echo $cat[0]->name; ?></p>
		</div>
		<div class="post-heading__post-title">
			<h1><?php the_title(); ?></h1>
			<?php $mypod = pods();
			echo '<p>' . $mypod->display('subttulo') . '</p>';
			?>
		</div>
		<div class="post-heading__post-details">
			<p class="bold"><?php the_date(); ?> </p>
			<p> per </p>
			<p class="bold"><?php the_author(); ?></p>
		</div>
		<div class="post-heading__feat-img">
			<p><?php the_post_thumbnail('full'); ?></p>
		</div>
		<?php


		if (!is_search()) {
			// get_template_part( 'template-parts/featured-image' );
		}

		?>

	</div>

	<div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">

		<div class="entry-content">

			<?php
			if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
				the_excerpt();
			} else {

				the_content(__('', 'miradanativa'));
			}
			?>

		</div><!-- .entry-content -->

	</div><!-- .post-inner -->

	<div class="related-posts__section">
		<?php
		$related_query = new WP_Query(array(
			'post_type'    => 'post',
			// 'category__in' => wp_get_post_categories(get_the_ID()),
			'post__not_in' => array(get_the_ID()),
			'posts_per_page'  => 3,
			'post_status'  => 'publish',
			'orderby' => 'date',
		));
		?>
		<h2 class="section-title"> Posts relacionados </h2>
		<div class="related-posts">
			<?php if ($related_query->have_posts()) { ?>
				<div class="related-posts__grid">
					<?php while ($related_query->have_posts()) { ?>
						<?php $related_query->the_post(); ?>
						<div class="grid-item">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-thumb-small'); ?></a>
							<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							<p><?php the_excerpt(); ?></p>
						</div>
					<?php } ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php } ?>
		</div>


	</div>






</article><!-- .post -->