<?php
/**
 * Template Name: User Profie
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

<main id="site-content">
  <?= do_shortcode('[um_loggedin][ultimatemember form_id="237"][/um_loggedin]') ?>
  <div class="post-inner thin">
    <div class="entry-content">
        <h4 class="wp-block-heading has-text-color has-link-color" style="color: #ffffff"><?= __('Favourites', 'miradanativa') ?></h4>
        <div class="wp-block-group archive-content archive-film is-layout-constrained wp-block-group-is-layout-constrained">
        <?= do_shortcode('[mn_filmmark_list]') ?>
        </div>
    </div>
  </div>
</main>

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();
