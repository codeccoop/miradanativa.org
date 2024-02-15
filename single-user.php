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
      <?= do_shortcode('[mn_filmmarks_list]') ?>
    </div>
  </div>
</main>

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();
