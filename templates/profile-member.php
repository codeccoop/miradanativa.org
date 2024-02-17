<?php

/**
 * Template Name: Member Profie
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

$um_user = get_query_var('um_user');
$profile_user = get_user_by('slug', $um_user);
if (empty($profile_user)) {
    require_once get_404_template();
    exit;
}

$session_user = wp_get_current_user();

get_header();
?>

<main id="site-content">
    <?= do_shortcode('[ultimatemember form_id="237" photosize="original"]') ?>
    <nav class="mn-profile-tabs">
        <ul>
            <li data-section="filmmarks"><?= __('Listas', 'miradanativa') ?></li>
            <li data-section="ratings"><?= __('Valoraciones', 'miradanativa') ?></li>
        </ul>
    </nav>
    <script>
    (() => {
        const showCurrentTab = (ev) => {
            const targetSection = ev.currentTarget.dataset.section;
            for (const section of document.querySelectorAll(".mn-profile-section")) {
                if (section.getAttribute("name") === targetSection) {
                    section.removeAttribute("hidden");
                } else {
                    section.setAttribute("hidden", true);
                }
            }
        }

        for (const tab of document.querySelectorAll('.mn-profile-tabs li')) {
            tab.addEventListener("click", showCurrentTab);
        }
    })();
    </script>
    <div class="post-inner thin">
        <div class="entry-content">
            <section class="wp-block-group alignwide mn-profile-section" name="filmmarks">
                <h4 class="mn-filmmarks__list-title" style="color: #ffffff"><?= __('Favoritos', "miradanativa")  ?></h4>
                <div class="archive-content archive-film mn-filmmarks__list">
                <?= do_shortcode('[mn_filmmarks_list user_id="' . $profile_user->ID . '" list_name="favourites"]') ?>
                </div>
            </section>
            <section class="wp-block-group alignwide mn-profile-section" name="ratings" hidden>
                <h4 class="mn-filmmarks__list-title" style="color: #ffffff"><?= __('Valoraciones', "miradanativa")  ?></h4>
                <?php
                wp_set_current_user($profile_user->ID);
echo do_shortcode('[yasr_user_rate_history]');
wp_set_current_user($session_user->ID);
?>
            </section>
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
