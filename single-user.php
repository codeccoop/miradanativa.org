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
    <style>
    article.film.type-film {
        transition: opacity 400ms ease;
    }
    article.film.type-film.fade-out {
        opacity: 0;
    }
    </style>
    <script>
    for (const button of document.querySelectorAll(".mn-filmmarks__ajax-button")) {
        button.addEventListener("ajax:change", (ev) => {
            if (ev.detail.action === "drop") {
                const filmWrapper = ev.target.closest("article.film.type-film");
                filmWrapper.classList.add("fade-out");
                setTimeout(() => {
                     filmWrapper.parentElement.removeChild(filmWrapper);
                }, 400)
            }
        })
    }
    </script>
</main>

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();
