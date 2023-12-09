<?php

/**
 * Template for rendering singular festivals
 *
 * @package WordPress
 * @subpackage MiradaNativa
 */
?>

<script>
	const style = document.createElement('style');
	style.appendChild(document.createTextNode(`.festival .entry-content{
  background-color: "<?php the_field('secondary_color'); ?>";
  font-size: 16px;
}

p, h1, h2, h3, h4, h5, h6, pre, label, button {
  color: "<?php the_field('text_color'); ?>";
}`));

	document.head.appendChild(style);

	document.addEventListener("DOMContentLoaded", () => {
		var backgroundColor = lightOrDark(data.backgroundColor);
		const image = document.getElementById("variableimage");
		if (backgroundColor === 'light') {
			image.src = "/wp-content/themes/miradanativa/assets/images/ninot_negro_97.png";
		} else {
			image.src = "/wp-content/themes/miradanativa/assets/images/ninot_blanco_72.png";
		}
	})
</script>

<div class="festival__hero-section" style="background-image: url('<?php the_field('poster'); ?>')">
	<img class="festival__logo" src='<?php the_field('logo'); ?>'>
</div>
<div class="tabs">
	<button role="tab" aria-selected="true" aria-controls="peliculas-content" id="peliculas-button">
		<?= pll__('Películas'); ?>
	</button>
	<button role="tab" aria-selected="false" aria-controls="nosotras-content" id="nosotras-button">
		<?= pll__('Sobre nosotros'); ?>
	</button>
	<button role="tab" aria-selected="false" aria-controls="contacto-content" id="contacto-button">
		<?= pll__('Contacto'); ?>
	</button>
	<?php if (get_field('programming')) : ?>
		<button id="descarga-button" style="background-color:<?php the_field('primary_color'); ?>;">
			<a href="<?php the_field('programming'); ?>" target="_blank" download style="color: <?php the_field('text_color'); ?>;" rel="noopener"><?= pll__('Descarga la programación'); ?></a>
		</button>
	<?php endif; ?>
</div>

<div class="festival__content" id="peliculas-content" role="tabpanel" labelledby="peliculas-button">
	<?= do_shortcode('[mn_fest_cataleg]'); ?>
</div>
<div class="festival__content hidden" id="nosotras-content" role="tabpanel" labelledby="nosotras-button">
	<?php the_field('description'); ?>

	<div class="nosotras__footer">
		<div class="nosotras__left">
			<?php if (get_field('web')) : ?>
				<div class="left__web">
					<p class="contacto__titulo"><?= pll__('Más información en'); ?>:</p>
					<a href="<?php the_field('web'); ?>" target="_blank" style="color:<?php the_field('text_color'); ?>;" rel="noopener"><?php the_field('web') ?></a>
				</div>
			<?php endif; ?>
			<div class="left__collaborators">
				<?php if (get_field('partners_logos')) : ?>
					<div class="footer__logos">
						<p class="contacto__titulo"><?= pll__('Impulsan'); ?>:</p>
						<div class="logos__images">
							<?php $logos = get_field('partners_logos');
							foreach ($logos as $logo) : ?>
								<img src="<?= $logo ?>" />
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="nosotras__right">
			<div class="right__social">
				<p class="contacto__titulo"><?= pll__('Siguenos en las redes sociales'); ?>:</p>
				<div class="social__logos">
					<?php if (get_field('twitter')) : ?>
						<a id="twitter-link" class="child-link" href="<?php the_field('twitter'); ?>" target="_blank" rel="noopener"><svg viewBox="0 -2 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M32.8181 1.40002L33.317 1.36695C33.3037 1.16638 33.1716 0.993269 32.9817 0.927524C32.7917 0.86178 32.5809 0.916182 32.4464 1.06562L32.8181 1.40002ZM31.055 8.10687C31.055 7.83073 30.8311 7.60687 30.555 7.60687C30.2788 7.60687 30.055 7.83073 30.055 8.10687H31.055ZM16.976 8.29318H16.476V8.29318L16.976 8.29318ZM16.976 10.4667H17.476H16.976ZM1.13379 26.3334V25.8334C0.913521 25.8334 0.7192 25.9775 0.655295 26.1883C0.591389 26.3991 0.672956 26.6269 0.856142 26.7492L1.13379 26.3334ZM3.39696 1.40002L3.86521 1.2247C3.79544 1.03836 3.62183 0.911128 3.42314 0.90071C3.22444 0.890292 3.03848 0.998676 2.94961 1.17669L3.39696 1.40002ZM12.4496 21.8L12.8035 22.1533C12.9258 22.0308 12.9761 21.8536 12.9362 21.6851C12.8964 21.5165 12.7722 21.3806 12.608 21.3258L12.4496 21.8ZM28.8235 3.60635L28.4526 3.9417L28.6328 4.14094L28.8984 4.10072L28.8235 3.60635ZM32.3192 1.4331C32.4382 3.22795 32.3356 4.39982 32.0071 5.32582C31.6824 6.24137 31.1189 6.9672 30.209 7.83901L30.9009 8.56104C31.8612 7.64081 32.55 6.7866 32.9496 5.66015C33.3455 4.54414 33.4394 3.21205 33.317 1.36695L32.3192 1.4331ZM31.055 9.75834V8.10687H30.055V9.75834H31.055ZM16.476 8.29318L16.476 10.4667H17.476L17.476 8.29318L16.476 8.29318ZM16.476 10.4667L16.476 11.6L17.476 11.6L17.476 10.4667H16.476ZM23.8585 0.900024C19.7805 0.900024 16.476 4.21078 16.476 8.29318H17.476C17.476 4.76161 20.3342 1.90002 23.8585 1.90002V0.900024ZM30.055 9.75834C30.055 19.8889 21.8554 28.1 11.7424 28.1V29.1C22.4092 29.1 31.055 20.4397 31.055 9.75834H30.055ZM2.9287 1.57535C4.10443 4.71547 8.54807 10.9667 16.976 10.9667V9.96669C9.10905 9.96669 4.95265 4.12902 3.86521 1.2247L2.9287 1.57535ZM2.94961 1.17669C0.638168 5.80672 0.318804 10.2153 1.94905 13.9261C3.57756 17.633 7.10772 20.5438 12.2913 22.2743L12.608 21.3258C7.60728 19.6563 4.34794 16.9004 2.86459 13.5239C1.38298 10.1514 1.62941 6.06 3.84431 1.62336L2.94961 1.17669ZM12.0958 21.4467C10.6506 22.8942 6.3952 25.8334 1.13379 25.8334V26.8334C6.73559 26.8334 11.2312 23.728 12.8035 22.1533L12.0958 21.4467ZM29.1944 3.27101C27.8784 1.8156 25.9749 0.900024 23.8585 0.900024V1.90002C25.6803 1.90002 27.3181 2.68691 28.4526 3.9417L29.1944 3.27101ZM28.8984 4.10072C30.4716 3.86245 32.0223 3.03222 33.1899 1.73443L32.4464 1.06562C31.4277 2.19802 30.0841 2.90974 28.7486 3.11199L28.8984 4.10072ZM0.856142 26.7492C4.3939 29.1113 8.10184 29.1 11.7424 29.1V28.1C8.06879 28.1 4.66319 28.0887 1.41144 25.9175L0.856142 26.7492Z" fill="<?php the_field('primary_color'); ?>" />
							</svg></a>
					<?php endif;
					if (get_field('facebook')) : ?>
						<a id="facebook-link" class="child-link" href="<?php the_field('facebook'); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M17.0005 32.8667C8.23754 32.8667 1.13379 25.7629 1.13379 17C1.13379 8.23711 8.23754 1.13336 17.0005 1.13336C25.7634 1.13336 32.8671 8.23711 32.8671 17C32.8671 25.7629 25.7634 32.8667 17.0005 32.8667ZM17.0005 32.8667V14.7334C17.0005 12.2297 19.0301 10.2 21.5338 10.2H22.6671M11.3338 19.2667H22.6671" stroke="<?php the_field('primary_color'); ?>" />
							</svg></a>
					<?php endif;
					if (get_field('instagram')) : ?>
						<a id="instagram-link" class="child-link" href="<?php the_field('instagram'); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M24.9338 7.93336H27.2005M10.2005 1.13336H23.8005C28.8078 1.13336 32.8671 5.19265 32.8671 10.2V23.8C32.8671 28.8074 28.8078 32.8667 23.8005 32.8667H10.2005C5.19307 32.8667 1.13379 28.8074 1.13379 23.8V10.2C1.13379 5.19265 5.19307 1.13336 10.2005 1.13336ZM17.0005 23.8C13.2449 23.8 10.2005 20.7556 10.2005 17C10.2005 13.2445 13.2449 10.2 17.0005 10.2C20.756 10.2 23.8005 13.2445 23.8005 17C23.8005 20.7556 20.756 23.8 17.0005 23.8Z" stroke="<?php the_field('primary_color'); ?>" />
							</svg></a>
					<?php endif;
					if (get_field('youtube')) : ?>
						<a id="youtube-link" class="child-link" href="<?php the_field('youtube'); ?>" target="_blank" rel="noopener"><svg viewBox="0 -3 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M3.65176 25.8729L3.54699 26.3618H3.54699L3.65176 25.8729ZM30.3492 25.8729L30.4539 26.3618L30.3492 25.8729ZM30.3492 2.12712L30.4539 1.63822L30.3492 2.12712ZM3.65176 2.12712L3.75652 2.61602L3.65176 2.12712ZM14.7338 9.46668L15.0111 9.05066C14.8577 8.94837 14.6604 8.93883 14.4979 9.02584C14.3353 9.11285 14.2338 9.28228 14.2338 9.46668H14.7338ZM14.7338 18.5333H14.2338C14.2338 18.7177 14.3353 18.8872 14.4979 18.9742C14.6604 19.0612 14.8577 19.0517 15.0111 18.9494L14.7338 18.5333ZM21.5338 14L21.8111 14.416C21.9502 14.3233 22.0338 14.1672 22.0338 14C22.0338 13.8328 21.9502 13.6767 21.8111 13.584L21.5338 14ZM0.633789 5.24181V22.7582H1.63379V5.24181H0.633789ZM33.3671 22.7582V5.24181H32.3671V22.7582H33.3671ZM3.54699 26.3618C12.4153 28.2622 21.5856 28.2622 30.4539 26.3618L30.2444 25.384C21.5142 27.2548 12.4867 27.2548 3.75652 25.384L3.54699 26.3618ZM30.4539 1.63822C21.5856 -0.262136 12.4153 -0.262136 3.54699 1.63822L3.75652 2.61602C12.4867 0.745263 21.5142 0.745263 30.2444 2.61602L30.4539 1.63822ZM33.3671 5.24181C33.3671 3.50401 32.1531 2.00234 30.4539 1.63822L30.2444 2.61602C31.4825 2.88134 32.3671 3.97554 32.3671 5.24181H33.3671ZM32.3671 22.7582C32.3671 24.0245 31.4825 25.1187 30.2444 25.384L30.4539 26.3618C32.1531 25.9977 33.3671 24.496 33.3671 22.7582H32.3671ZM0.633789 22.7582C0.633789 24.496 1.84776 25.9977 3.54699 26.3618L3.75652 25.384C2.51836 25.1187 1.63379 24.0245 1.63379 22.7582H0.633789ZM1.63379 5.24181C1.63379 3.97554 2.51836 2.88134 3.75652 2.61602L3.54699 1.63822C1.84776 2.00234 0.633789 3.50401 0.633789 5.24181H1.63379ZM14.2338 9.46668V18.5333H15.2338V9.46668H14.2338ZM15.0111 18.9494L21.8111 14.416L21.2564 13.584L14.4564 18.1173L15.0111 18.9494ZM21.8111 13.584L15.0111 9.05066L14.4564 9.88271L21.2564 14.416L21.8111 13.584Z" fill="<?php the_field('primary_color'); ?>" />
							</svg></a>
					<?php endif; ?>
				</div>
			</div>
			<div class="right__support">
				<?php if (get_field('founders_logos')) : ?>
					<div class="footer__logos">
						<p class="contacto__titulo"><?= pll__('Con el soporte de'); ?>:</p>
						<div class="logos__images">
							<?php foreach (get_field('founders_logos') as $logo) : ?>
								<img src="<?= $logo; ?>" />
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="indi_separator">
		<div id="block-1" class="indi_content_column" "color:<?php the_field('primary_color'); ?>;"></div>
		<div id="block-2" class="indi_content_column">
			<img id="variableimage" class="indi_centered" src="https://www.miradanativa.org/wp-content/uploads/2021/04/ninot_blanco_72.png">
		</div>
		<div id="block-3" class="indi_content_column" "color:<?php the_field('primary_color'); ?>;"></div>
	</div>
	<p class="warning__text"><?= pll__('MiradaNativa no se hace responsable de los contenidos ni del tratamiento de los datos que se hagan desde los festivales alojados en esta plataforma. Toda la responsabilidad es del festival anfitrión. En caso de duda, pueden ponerse en contacto con nosotros.'); ?></p>
</div>

<div class="festival__content hidden" id="contacto-content" role="tabpanel" labelledby="contacto-button">
	<?php if (get_field('web')) : ?>
		<div class="content__contacto web">
			<p class="contacto__titulo"><?= pll__('Página web del festival'); ?>:</p>
			<a href="<?php the_field('web'); ?>" target="_blank" style="color:<?php the_field('text_color'); ?>;" rel="noopener"><?php the_field('web'); ?></a>
		</div>
	<?php endif; ?>
	<div class="content__contacto mail">
		<p class="contacto__titulo"><?= pll__('Contacto'); ?>:</p>

		<p class="contacto__mail" style="color:<?php the_field('primary_color'); ?>;"><?php the_field('email'); ?></p>

		<?php if (get_field('address')) : ?>
			<div class="contacto__direccion" style="color:<?php the_field('primary_color'); ?>;"><?php the_field('address'); ?></div>
		<?php endif; ?>
	</div>
	<div class="content__contacto social">
		<p class="contacto__titulo"><?= pll__('Siguenos en las redes sociales'); ?>
		<div class="social__logos">
			<?php if (get_field('twitter')) : ?>
				<a id="twitter-link" class="child-link" href="<?php the_field('twitter'); ?>" target="_blank" rel="noopener"><svg viewBox="0 -2 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M32.8181 1.40002L33.317 1.36695C33.3037 1.16638 33.1716 0.993269 32.9817 0.927524C32.7917 0.86178 32.5809 0.916182 32.4464 1.06562L32.8181 1.40002ZM31.055 8.10687C31.055 7.83073 30.8311 7.60687 30.555 7.60687C30.2788 7.60687 30.055 7.83073 30.055 8.10687H31.055ZM16.976 8.29318H16.476V8.29318L16.976 8.29318ZM16.976 10.4667H17.476H16.976ZM1.13379 26.3334V25.8334C0.913521 25.8334 0.7192 25.9775 0.655295 26.1883C0.591389 26.3991 0.672956 26.6269 0.856142 26.7492L1.13379 26.3334ZM3.39696 1.40002L3.86521 1.2247C3.79544 1.03836 3.62183 0.911128 3.42314 0.90071C3.22444 0.890292 3.03848 0.998676 2.94961 1.17669L3.39696 1.40002ZM12.4496 21.8L12.8035 22.1533C12.9258 22.0308 12.9761 21.8536 12.9362 21.6851C12.8964 21.5165 12.7722 21.3806 12.608 21.3258L12.4496 21.8ZM28.8235 3.60635L28.4526 3.9417L28.6328 4.14094L28.8984 4.10072L28.8235 3.60635ZM32.3192 1.4331C32.4382 3.22795 32.3356 4.39982 32.0071 5.32582C31.6824 6.24137 31.1189 6.9672 30.209 7.83901L30.9009 8.56104C31.8612 7.64081 32.55 6.7866 32.9496 5.66015C33.3455 4.54414 33.4394 3.21205 33.317 1.36695L32.3192 1.4331ZM31.055 9.75834V8.10687H30.055V9.75834H31.055ZM16.476 8.29318L16.476 10.4667H17.476L17.476 8.29318L16.476 8.29318ZM16.476 10.4667L16.476 11.6L17.476 11.6L17.476 10.4667H16.476ZM23.8585 0.900024C19.7805 0.900024 16.476 4.21078 16.476 8.29318H17.476C17.476 4.76161 20.3342 1.90002 23.8585 1.90002V0.900024ZM30.055 9.75834C30.055 19.8889 21.8554 28.1 11.7424 28.1V29.1C22.4092 29.1 31.055 20.4397 31.055 9.75834H30.055ZM2.9287 1.57535C4.10443 4.71547 8.54807 10.9667 16.976 10.9667V9.96669C9.10905 9.96669 4.95265 4.12902 3.86521 1.2247L2.9287 1.57535ZM2.94961 1.17669C0.638168 5.80672 0.318804 10.2153 1.94905 13.9261C3.57756 17.633 7.10772 20.5438 12.2913 22.2743L12.608 21.3258C7.60728 19.6563 4.34794 16.9004 2.86459 13.5239C1.38298 10.1514 1.62941 6.06 3.84431 1.62336L2.94961 1.17669ZM12.0958 21.4467C10.6506 22.8942 6.3952 25.8334 1.13379 25.8334V26.8334C6.73559 26.8334 11.2312 23.728 12.8035 22.1533L12.0958 21.4467ZM29.1944 3.27101C27.8784 1.8156 25.9749 0.900024 23.8585 0.900024V1.90002C25.6803 1.90002 27.3181 2.68691 28.4526 3.9417L29.1944 3.27101ZM28.8984 4.10072C30.4716 3.86245 32.0223 3.03222 33.1899 1.73443L32.4464 1.06562C31.4277 2.19802 30.0841 2.90974 28.7486 3.11199L28.8984 4.10072ZM0.856142 26.7492C4.3939 29.1113 8.10184 29.1 11.7424 29.1V28.1C8.06879 28.1 4.66319 28.0887 1.41144 25.9175L0.856142 26.7492Z" fill="<?php the_field('primary_color'); ?>" />
					</svg></a>
			<?php endif;
			if (get_field('facebook')) : ?>
				<a id="facebook-link" class="child-link" href="<?php the_field('facebook'); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M17.0005 32.8667C8.23754 32.8667 1.13379 25.7629 1.13379 17C1.13379 8.23711 8.23754 1.13336 17.0005 1.13336C25.7634 1.13336 32.8671 8.23711 32.8671 17C32.8671 25.7629 25.7634 32.8667 17.0005 32.8667ZM17.0005 32.8667V14.7334C17.0005 12.2297 19.0301 10.2 21.5338 10.2H22.6671M11.3338 19.2667H22.6671" stroke="<?php the_field('primary_color'); ?>" />
					</svg></a>
			<?php endif;
			if (get_field('instagram')) : ?>
				<a id="instagram-link" class="child-link" href="<?php the_field('instagram'); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M24.9338 7.93336H27.2005M10.2005 1.13336H23.8005C28.8078 1.13336 32.8671 5.19265 32.8671 10.2V23.8C32.8671 28.8074 28.8078 32.8667 23.8005 32.8667H10.2005C5.19307 32.8667 1.13379 28.8074 1.13379 23.8V10.2C1.13379 5.19265 5.19307 1.13336 10.2005 1.13336ZM17.0005 23.8C13.2449 23.8 10.2005 20.7556 10.2005 17C10.2005 13.2445 13.2449 10.2 17.0005 10.2C20.756 10.2 23.8005 13.2445 23.8005 17C23.8005 20.7556 20.756 23.8 17.0005 23.8Z" stroke="<?php the_field('primary_color'); ?>" />
					</svg></a>
			<?php endif;
			if (get_field('youtube')) : ?>
				<a id="youtube-link" class="child-link" href="<?php the_field('youtube'); ?>" target="_blank" rel="noopener"><svg viewBox="0 -3 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M3.65176 25.8729L3.54699 26.3618H3.54699L3.65176 25.8729ZM30.3492 25.8729L30.4539 26.3618L30.3492 25.8729ZM30.3492 2.12712L30.4539 1.63822L30.3492 2.12712ZM3.65176 2.12712L3.75652 2.61602L3.65176 2.12712ZM14.7338 9.46668L15.0111 9.05066C14.8577 8.94837 14.6604 8.93883 14.4979 9.02584C14.3353 9.11285 14.2338 9.28228 14.2338 9.46668H14.7338ZM14.7338 18.5333H14.2338C14.2338 18.7177 14.3353 18.8872 14.4979 18.9742C14.6604 19.0612 14.8577 19.0517 15.0111 18.9494L14.7338 18.5333ZM21.5338 14L21.8111 14.416C21.9502 14.3233 22.0338 14.1672 22.0338 14C22.0338 13.8328 21.9502 13.6767 21.8111 13.584L21.5338 14ZM0.633789 5.24181V22.7582H1.63379V5.24181H0.633789ZM33.3671 22.7582V5.24181H32.3671V22.7582H33.3671ZM3.54699 26.3618C12.4153 28.2622 21.5856 28.2622 30.4539 26.3618L30.2444 25.384C21.5142 27.2548 12.4867 27.2548 3.75652 25.384L3.54699 26.3618ZM30.4539 1.63822C21.5856 -0.262136 12.4153 -0.262136 3.54699 1.63822L3.75652 2.61602C12.4867 0.745263 21.5142 0.745263 30.2444 2.61602L30.4539 1.63822ZM33.3671 5.24181C33.3671 3.50401 32.1531 2.00234 30.4539 1.63822L30.2444 2.61602C31.4825 2.88134 32.3671 3.97554 32.3671 5.24181H33.3671ZM32.3671 22.7582C32.3671 24.0245 31.4825 25.1187 30.2444 25.384L30.4539 26.3618C32.1531 25.9977 33.3671 24.496 33.3671 22.7582H32.3671ZM0.633789 22.7582C0.633789 24.496 1.84776 25.9977 3.54699 26.3618L3.75652 25.384C2.51836 25.1187 1.63379 24.0245 1.63379 22.7582H0.633789ZM1.63379 5.24181C1.63379 3.97554 2.51836 2.88134 3.75652 2.61602L3.54699 1.63822C1.84776 2.00234 0.633789 3.50401 0.633789 5.24181H1.63379ZM14.2338 9.46668V18.5333H15.2338V9.46668H14.2338ZM15.0111 18.9494L21.8111 14.416L21.2564 13.584L14.4564 18.1173L15.0111 18.9494ZM21.8111 13.584L15.0111 9.05066L14.4564 9.88271L21.2564 14.416L21.8111 13.584Z" fill="<?php the_field('primary_color'); ?>" />
					</svg></a>
			<?php endif; ?>
		</div>
	</div>
</div>
