<article>
	<a href="<?php the_permalink() ?>">
		<img src="<?php the_field('thumbnail'); ?>" title="<?php the_title(); ?>">

		<div class="indi_film_details">
			<h7><span id="indi_film_title"><?php the_title(); ?> </span></h7>
			<span class="indi_film_details_value">
				<?php
				$pueblos = get_the_terms(get_the_ID(), 'mn_pueblo_indigena');
				if ($pueblos && sizeof($pueblos)) {
					echo implode(', ', array_map(function ($term) {
						return $term->name;
					}, $pueblos));
				}
				$zonas = get_the_terms(get_the_ID(), 'mn_zona_geografica');
				if ($zonas && sizeof($zonas)) {
					echo '&nbsp;|&nbsp;';
					echo implode(', ', array_map(function ($term) {
						return $term->name;
					}, $zonas));
				}
				?>
			</span>
			<span class="indi_film_details_value"><?php the_field('duration'); ?></span>
			<?php if (!get_field('vimeo_id')) : ?>
				<p class="indi_film_not_available"><?= pll__('No Disponible'); ?></p>
			<?php endif; ?>
		</div>
	</a>
</article>
