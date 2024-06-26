<figure <?php post_class("blog-item"); ?>>
	<a href="<?php the_permalink() ?>">
		<div class="img-container">
			<img src="<?= get_the_post_thumbnail_url(); ?>" title="<?php the_title(); ?>">
		</div>
		<figcaption class="small">
			<h5 class="archive-posts__figcaption title <?= get_the_category()[0]->slug; ?>"><?php the_title(); ?></h5><br>
			<div class="archive-posts__figcaption meta">
				<?php
				$tags = get_the_tags();
				if ($tags) {
					echo implode(', ', array_map(function ($tag) {
						return $tag->name;
					}, $tags));
				}
				?>
			</div>
			<div class="archive-posts__figcaption excerpt"><?php the_excerpt(); ?></div>
		</figcaption>
	</a>
</figure>
