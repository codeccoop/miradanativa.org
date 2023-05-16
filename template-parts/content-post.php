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
			<p class="<?php echo $cat[0]->slug; ?>"><?php echo $cat[0]->name; ?></p>
		</div>
		<div class="post-heading__post-title">
			<h1><?php the_title(); ?></h1>
			<?php $mypod = pods();
			echo '<p>' . $mypod->display('subtitulo') . '</p>';
			?>
		</div>
		<div class="post-heading__post-details">
			<p class="bold"><?php the_date(); ?> </p>
			<p> per </p>
			<p class="bold"><?php echo $mypod->display('autor_1');
							if ($mypod->display('autor_2') !== '') echo ', ' . $mypod->display('autor_2'); ?>
			</p>
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
	<?php
	if ($cat[0]->slug == 'resena' || $cat[0]->slug == 'resenya') {
		$filmID = $mypod->display('film_selector');
		if (!empty($filmID)) {
			$filmparams = array(
				'titulo' => $filmID,
				'where'   => "t.post_title = '$filmID'"
			);
			$pelicula = pods('pelicula', $filmparams); ?>


			<div class="related-film__section">
				<div class="related-film__content">
					<h2 class="section-title"><?php pll_e("Ver película"); ?></h2>

					<div class="related-film__film">
						<div class="details__player">

							<!-- <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/play-button-1.png'; ?>" alt=""> -->


							<?php if ($cat[0]->slug == 'resena') { ?>
								<a href="https://www.miradanativa.org/pelicula/<?php echo $pelicula->display('slug'); ?>">
									<div class="indi_play_img" onclick="togglePlayer(777030158); return true;"></div>
								</a>
								<img class="film-cover" src="<?php echo $pelicula->display('cartel_en_ficha'); ?>" alt="">
							<?php } elseif ($cat[0]->slug == 'resenya') { ?>
								<a href="https://www.miradanativa.org/ca/pelicula/<?php echo $pelicula->display('slug'); ?>">
									<div class="indi_play_img" onclick="togglePlayer(777030158); return true;"></div>
								</a>
								<img class="film-cover" src="<?php echo $pelicula->display('cartel_en_ficha'); ?>" alt="">

							<?php } ?>
						</div>
						<div class="details__details">
							<p class="bold"> <?php echo $pelicula->display('titulo'); ?> </p>
							<p> <?php if ($pelicula->display('pueblo_indigena') !== '') echo $pelicula->display('pueblo_indigena'); ?>
								<?php if ($pelicula->display('zona_geografica') !== '') echo ' | ' . $pelicula->display('zona_geografica'); ?> </p>
							<p> <?php if ($pelicula->display('duracion') !== '') echo $pelicula->display('duracion'); ?> </p>
						</div>
					</div>
				</div>

			</div>
	<?php }
	} ?>

	<div class="related-posts__section">
		<?php
		$related_query = new WP_Query(array(
			'post_type'    => 'post',
			'category__in' => wp_get_post_categories(get_the_ID()),
			'post__not_in' => array(get_the_ID()),
			'posts_per_page'  => 3,
			'post_status'  => 'publish',
			'orderby' => 'date',
		));
		?>
		<?php if ($related_query->have_posts()) : ?>
			<h2 class="section-title"><?php pll_e("Te puede interesar"); ?> </h2>
			<div class="related-posts">
				<div class="related-posts__grid">
					<?php while ($related_query->have_posts()) { ?>
						<?php $related_query->the_post(); ?>
						<div class="grid-item">
							<div class="veiled <?php echo $cat[0]->slug; ?>"></div>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-thumb-small'); ?></a>
							<h5><a class="<?php echo $cat[0]->slug; ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							<div class="post-details">
								<p><?php $date = get_the_date();
									echo $date; ?></p>
								<span>|</span>
								<p><?php $tags = get_the_tags();
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
		<div class="wp-block-buttons is-content-justification-center">
			<div class="wp-block-button inverted is-style-outline">
				<a class="news_archive_button wp-block-button__link" href="/<?php pll_e("noticias"); ?>" target="_blank"> <?php pll_e("Ver más publicaciones") ?> </a>
			</div>
		</div>


	</div>






</article><!-- .post -->