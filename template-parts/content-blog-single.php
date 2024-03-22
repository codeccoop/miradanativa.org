<?php

/**
 * Blog entry content
 *
 * @package WordPress
 * @subpackage MiradaNativa
 * 
 */

?>

<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Habibi&display=swap" rel="stylesheet">
</head>
<article class="single-post" <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<?php
	get_template_part('template-parts/entry-header');
	$cat = get_the_category(); ?>

	<div class="post-heading">
		<div class="post-heading__category ">
			<p class="<?= $cat[0]->slug; ?>"><?= $cat[0]->name; ?></p>
		</div>
		<div class="post-heading__post-title">
			<h1><?php the_title(); ?></h1>
			<p><?php the_field('subtitle'); ?></p>
		</div>
		<div class="post-heading__post-details">
			<p class="bold"><?php the_date(); ?> </p>
			<p> per </p>
			<p class="bold">
				<?php the_field('author_1');
				if (get_field('author_2')) {
					echo ', ' . get_field('author_2');
				} ?>
			</p>
		</div>
	</div>
	<div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">
		<div class="entry-content">
			<?php
			if (is_search() || !is_singular() && 'summary' === get_theme_mod('blog_content', 'full')) {
				the_excerpt();
			} else {
				the_content(__(''));
			}
			?>
		</div><!-- .entry-content -->
	</div><!-- .post-inner -->
	<?php
	$cat_name = $cat[0]->slug;
	if (!empty(get_field('film'))) :
		$film = get_post(get_field('film')); ?>
		<div class="related-film__section">
			<div class="related-film__content">
				<h2 class="section-title"><?= pll__("Ver película"); ?></h2>
				<div class="related-film__film">
					<div class="details__player">
						<a href="<?= get_permalink($film->ID); ?>">
							<div class="indi_play_img" onclick="togglePlayer(777030158); return true;"></div>
						</a>
						<img class="film-cover" src="<?php the_field('poster', $film->ID); ?>" alt="Poster de <?php the_field('title', $film->ID) ?>">
					</div>
					<div class="details__details">
						<h3 class="bold"><?= get_the_title($film->ID); ?></h3>
						<p>
							<?php
							$pueblos = get_the_terms($film->ID, 'mn_pueblo_indigena');
							if ($pueblos && sizeof($pueblos)) {
								echo implode(', ', array_map(function ($term) {
									return $term->name;
								}, $pueblos));
							}
							$zonas = get_the_terms($film->ID, 'mn_zona_geografica');
							if ($zonas && sizeof($zonas)) {
								echo ' | ' . implode(', ', array_map(function ($term) {
									return $term->name;
								}, $zonas));
							}
							if (get_field('duration', $film->ID)) {
								echo ' | ' . get_field('duration', $film->ID);
							}
							?>
						</p>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="related-posts__section">
		<?php
		$related_query = new WP_Query([
			'post_type' => 'blog',
			'category__in' => [$cat[0]->term_id],
			'post__not_in' => [get_the_ID()],
			'posts_per_page' => 3,
			'post_status'  => 'publish',
			'orderby' => 'date',
		]);
		?>
		<?php if ($related_query->have_posts()) : ?>
			<h2 class="section-title"><?= pll__("Te puede interesar"); ?> </h2>
			<div class="related-posts">
				<div class="related-posts__grid">
					<?php while ($related_query->have_posts()) { ?>
						<?php $related_query->the_post(); ?>
						<div class="grid-item">
							<div class="veiled <?php echo $cat[0]->slug; ?>"></div>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-thumb-small'); ?></a>
							<h5><a class="<?= $cat[0]->slug; ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							<div class="post-details">
								<p><?= get_the_date(); ?></p>
								<span>|</span>
								<p>
									<?php
									$tags = get_the_tags();
									foreach ($tags as $key => $tag) {
										echo $tag->name;
										if ($key !== array_key_last($tags)) {
											echo str_repeat(',&nbsp;', 1);
										} else {
											echo str_repeat('&nbsp;', 1);
										}
									} ?>
								</p>
							</div>
							<div class="post-excerpt"><?php the_excerpt(); ?></div>
						</div>
					<?php } ?>
				</div>
				<?php wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>
		<div class="wp-block-buttons is-horizontal is-content-justification-center is-layout-flex wp-container-core-buttons-layout-3 wp-block-buttons-is-layout-flex">
			<div class="wp-block-button inverted is-style-outline">
				<?php $blog_url = pll_current_language() === 'es' ? '/blog' : '/ca/blog'; ?>
				<a class="wp-block-button__link wp-element-button" href="<?= $blog_url; ?>" style="border-radius:5px"><?= __('Ver más publicaciones') ?></a>
			</div>
		</div>
	</div>
</article><!-- .post -->
