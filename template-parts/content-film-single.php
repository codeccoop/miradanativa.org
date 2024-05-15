<?php
if (!function_exists('mn_film_render_terms')) {
    function mn_film_render_terms($terms)
    {
        return implode(',', array_map(function ($term) {
            $link = get_term_link($term);
            $name = $term->name;
            return "<a href='{$link}'>{$name}</a>";
        }, $terms));
    }
}
?>

<div class="indi_ficha_visuals player_placeholder wp-block-cover alignfull has-background-dim-30 has-primary-background-color has-background-dim" style="background: -moz-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 8%, rgba(0, 0, 0, 1) 100%), url('<?php the_field('poster'); ?>') no-repeat; background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0, 0, 0, 0)), color-stop(8%, rgba(0, 0, 0, 0)), color-stop(100%, rgba(0, 0, 0, 1))), url('<?php the_field('poster'); ?>') no-repeat; background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 8%, rgba(0, 0, 0, 1) 100%), url('<?php the_field('poster'); ?>') no-repeat; background: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 8%, rgba(0, 0, 0, 1) 100%), url('<?php the_field('poster'); ?>') no-repeat; background: -ms-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 8%, rgba(0, 0, 0, 1) 100%), url('<?php the_field('poster'); ?>') no-repeat; background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 8%, rgba(0, 0, 0, 1) 100%), url('<?php the_field('poster'); ?>') no-repeat;background-size: cover; min-height:600px; background-position:100%">
  <?php if (get_field('vimeo_id')) : ?>
    <div onclick="togglePlayer(<?php the_field('vimeo_id'); ?>); return true;" class="indi_play_img">
      <img src="https://www.miradanativa.org/wp-content/uploads/2021/07/playButton.png">
      <!-- <img class="indi_show_on_hover" src="https://www.miradanativa.org/wp-content/uploads/2021/07/hoverPlay.png"> -->
    </div>
  <?php else : ?>
    <div class="indi_film_not_available_message">
      <h7><?= pll__('Película no disponible actualmente'); ?></h7>
    </div>
  <?php endif; ?>
  <div class="wp-block-cover__inner-container">
    <div class="indi_ficha_overview alignfull">
      <h1><?php the_title(); ?></h1>
      <p><span class="indi_overview_sinopsis"><?php the_field('description'); ?></span></p>
      <p><?php the_field('duration');
$tematicas = get_the_terms(get_the_ID(), 'mn_tematica');
if ($tematicas && sizeof($tematicas) > 0) : ?>
          <span class="indi_text_separator">|</span>
          <?= mn_film_render_terms($tematicas); ?>
        <?php endif; ?>
        <span class="indi_text_separator">|</span>
        <?php the_field('year'); ?>
      </p>
    </div>
    <div class="wp-block-button alignfull">
      <div class="indi-wp-block-button-left">
        <?= do_shortcode('[yasr_visitor_votes size="small"]'); ?>
      </div>
      <div class="indi-wp-block-button-right is-style-fill">
        <a class="wp-block-button__link" href="/aportar"><?= pll__('Aportar') ?></a>
      </div>
      <div class="indi-wp-block-button-right is-style-fill">
        <?= do_shortcode('[wpct_bm_bookmark post_id="' . get_the_ID() . '"]') ?>
      </div>
    </div>
  </div>
</div>
<div class="indi_ficha_detail alignfull player_placeholder">
  <div class="wp-block-columns alignfull">
    <div class="wp-block-column">
      <div class="wp-block-group">
        <div class="wp-block-group__inner-container">
          <h2><?= pll__('Sinopsis'); ?></h2>
          <div>
            <span class="indi_ficha_sinopsis">
              <?php if (get_field('long_description')) {
                  the_field('long_description');
              } ?>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="wp-block-column">
      <div class="wp-block-group">
        <div class="wp-block-group__inner-container">
          <h2><?= pll__('Ficha artística y técnica'); ?></h2>
          <?php if (get_field('year')) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Año'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?php the_field('year'); ?></span>
            </div>
          <?php endif;
if (get_field('duration')) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Duración'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?php the_field('duration'); ?></span>
            </div>
          <?php endif;
$realizacion = get_the_terms(get_the_ID(), 'mn_realizacion');
if ($realizacion && sizeof($realizacion)) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Realización'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?= mn_film_render_terms($realizacion); ?></span>
            </div>
          <?php endif;
$produccion = get_the_terms(get_the_ID(), 'mn_produccion');
if ($produccion && sizeof($produccion)) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Producción'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?= mn_film_render_terms($produccion); ?></span>
            </div>
          <?php endif;
if (get_field('casting')) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Reparto'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?php the_field('casting'); ?></span>
            </div>
          <?php endif;
if (get_field('awards')) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Premios'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?php the_field('awards'); ?></span>
            </div>
          <?php endif;
$pueblos = get_the_terms(get_the_ID(), 'mn_pueblo_indigena');
if ($pueblos && sizeof($pueblos)) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Pueblo'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?= mn_film_render_terms($pueblos); ?></span>
            </div>
          <?php endif;
$zonas = get_the_terms(get_the_ID(), 'mn_zona_geografica');
if ($zonas && sizeof($zonas)) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Zona Geográfica'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?= mn_film_render_terms($zonas); ?></span>
            </div>
          <?php endif;
if (get_field('language')) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Idioma'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?php the_field('language'); ?></span>
            </div>
          <?php endif;
if (get_field('subtitles')) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Subtítulos'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?php the_field('subtitles'); ?></span>
            </div>
          <?php endif;
$tematicas = get_the_terms(get_the_ID(), 'mn_tematica');
if ($tematicas && sizeof($tematicas)) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Temática'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?= mn_film_render_terms($tematicas); ?></span>
            </div>
          <?php endif;
$generos = get_the_terms(get_the_ID(), 'mn_genero');
if ($generos && sizeof($generos)) : ?>
            <div class="indi_ficha_tecnica_field">
              <span class="indi_ficha_label"><?= pll__('Género(s)'); ?>: </span>
              <span class="indi_ficha_tecnica_value"><?= mn_film_render_terms($generos); ?></span>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="wp-block-columns alignfull">
    <div class="wp-block-column">
      <div class="wp-block-group">
        <?php
        $etiquetas = get_the_terms(get_the_ID(), 'mn_etiqueta');
if ($etiquetas && sizeof($etiquetas)) : ?>
          <div class="wp-block-group__inner-container">
            <h2><?= pll__('Etiquetas'); ?></h2>
            <ul class="indi_etiqueta">
              <?php foreach ($etiquetas as $etiqueta) : ?>
                <li>
                  <a style="text-decoration: none;" href="<?= get_term_link($etiqueta); ?>"><?= $etiqueta->name; ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="wp-block-column">
      <div class="wp-block-group">
        <?php if (get_field('related_links')) : ?>
          <div class="wp-block-group__inner-container">
            <h2><?= pll__('Enlaces de interés'); ?></h2>
            <?php the_field('related_links'); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<div class="indi_ficha_more_like_this alignfull player_placeholder">
  <div class="wp-block-columns alignfull">
    <div class="wp-block-column">
      <div class="wp-block-group">
        <div class="wp-block-group__inner-container">
          <div class="more_like_this">
            <?= do_shortcode('[carousel_more_like_this pelicula_id="' . get_the_ID() . '"]'); ?>
          </div>
          <div class="wp-block-buttons is-horizontal is-content-justification-center is-layout-flex wp-container-core-buttons-layout-3 wp-block-buttons-is-layout-flex">
            <div class="wp-block-button inverted is-style-outline">
              <?php $cataleg_url = pll_current_language() === 'es' ? '/search' : '/ca/cercador'; ?>
              <a class="wp-block-button__link wp-element-button" href="<?= $cataleg_url; ?>" style="border-radius:5px"><?= pll__('Catálogo'); ?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="player_container" style="display:none;">
  <div style="display: inline-block;width: 100%;">
    <img onclick="togglePlayer(<?php the_field('vimeo_id'); ?>); return true;" class="indi_closePlayer" src="https://www.miradanativa.org/wp-content/uploads/2021/02/close.png" style="height:15px;float: right;" />
  </div>
  <div class="player_div alignfull" style="display:none;">
    <?= do_shortcode('[um_loggedin show_lock=yes]
		<div style="padding:55% 0 0 0;position:relative;">
			<iframe class="player_iframe" _src="https://player.vimeo.com/video/' . get_field('vimeo_id') . '" frameborder="0" style="display:none"></iframe>
			<iframe class="player_iframe" src="https://player.vimeo.com/video/' . get_field('vimeo_id') . '?autoplay=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="' . get_field('title') . '"></iframe>
		</div>
		[/um_loggedin]'); ?>
  </div>
  <div class="alignfull">
    <div class="indi-wp-block-button-left">
      <?= do_shortcode('[yasr_visitor_votes size="small"]'); ?>
    </div>
  </div>
</div>
