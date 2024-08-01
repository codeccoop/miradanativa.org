<?php

/**
 * Template Name: Member Profie
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

$lang = pll_current_language();
$um_user_id = get_query_var('um_user');
$profile_user = get_user_by('ID', $um_user_id);
if (empty($profile_user)) {
    if ($lang === 'ca') {
        $site_url = site_url();
        wp_redirect($site_url . '/ca/profile?lang=ca');
        exit;
    }
    if($lang === 'en'){
        $site_url = site_url();
        wp_redirect($site_url . '/en/profile?lang=en');
        exit;
    }
    require_once get_404_template();
    exit;
}

$session_user = wp_get_current_user();
$is_owner = $session_user->ID === $profile_user->ID;

$nonce = wp_create_nonce('form-bookmarks');

get_header();
?>

<main id="site-content">
    <?= do_shortcode('[ultimatemember form_id="237" photosize="original"]') ?>
    <nav class="mn-profile-tabs">
        <ul>
            <li data-section="lists"><a href="#lists"><?= pll__('Lists', 'miradanativa') ?></a></li>
            <li data-section="ratings"><a href="#ratings"><?= pll__('Ratings', 'miradanativa') ?></a></li>
        </ul>
    </nav>
    <script>
    (() => {
        document.addEventListener("DOMContentLoaded", () => {
            if (window.location.hash === "") {
                window.location.hash = "lists";
            }
        });

        let initialScroll, wait;
        function onScroll(initial) {
            clearTimeout(wait);
            window.scrollTo({y: initialScroll});
            wait = setTimeout(() => window.removeEventListener("scroll", onScroll), 100);
        }

        window.addEventListener("popstate", (ev) => {
            initialScroll = window.scrollY;
            window.addEventListener("scroll",  onScroll);
        });
    })();
    </script>
    <div class="post-inner thin">
        <div class="entry-content">
            <section class="wp-block-group alignwide mn-profile-section" id="lists">
                <div class="mn-profile-section__title">
                    <h4><?= pll__('My lists', 'miradanativa') ?></h4>
                    <?php if ($is_owner) : ?>
                    <a href="#new-list" style="margin-left:auto">
                        <button class="wp-block-button__link wp-element-button" action="new-list"><?= pll__('New list', 'miradanativa') ?></button>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="archive-content archive-film">
                    <?= do_shortcode('[wpct_bm_user_lists user_id="' . $profile_user->ID . '"]') ?>
                </div>
            </section>
            <?php foreach (apply_filters('wpct_bm_user_lists', [], $profile_user->ID) as $list) : ?>
                <section class="wp-block-group alignwide mn-profile-section" id="list-<?= $list->id ?>">
                    <form class="mn-profile-form" method="GET">
                        <input type="text" name="_ajax_nonce" value="<?= $nonce ?>" style="display:none" />
                        <input type="text" name="action" value="wpct_bm_drop_list" style="display:none" />
                        <input type="text" name="list_id" value="<?= $list->id ?>" style="display:none" />
                        <div class="mn-profile-section__title">
                            <h4><?= $list->title ?></h4>
                            <button style="margin-left:auto" class="wp-block-button__link wp-element-button is-style-icon" action="share">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 24 24">
                                    <path fill="#7bcc91" d="M 18 2 A 3 3 0 0 0 15 5 A 3 3 0 0 0 15.054688 5.5605469 L 7.9394531 9.7109375 A 3 3 0 0 0 6 9 A 3 3 0 0 0 3 12 A 3 3 0 0 0 6 15 A 3 3 0 0 0 7.9355469 14.287109 L 15.054688 18.439453 A 3 3 0 0 0 15 19 A 3 3 0 0 0 18 22 A 3 3 0 0 0 21 19 A 3 3 0 0 0 18 16 A 3 3 0 0 0 16.0625 16.712891 L 8.9453125 12.560547 A 3 3 0 0 0 9 12 A 3 3 0 0 0 8.9453125 11.439453 L 16.060547 7.2890625 A 3 3 0 0 0 18 8 A 3 3 0 0 0 21 5 A 3 3 0 0 0 18 2 z"></path>
                                </svg>
                            </button>
                            <?php if ($list->name !== 'favorites' && $is_owner) : ?>
                            <button class="wp-block-button__link wp-element-button is-style-icon" action="drop">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 24 24">
                                    <path fill="#7bcc91" d="M 10.806641 2 C 10.289641 2 9.7956875 2.2043125 9.4296875 2.5703125 L 9 3 L 4 3 A 1.0001 1.0001 0 1 0 4 5 L 20 5 A 1.0001 1.0001 0 1 0 20 3 L 15 3 L 14.570312 2.5703125 C 14.205312 2.2043125 13.710359 2 13.193359 2 L 10.806641 2 z M 4.3652344 7 L 5.8925781 20.263672 C 6.0245781 21.253672 6.877 22 7.875 22 L 16.123047 22 C 17.121047 22 17.974422 21.254859 18.107422 20.255859 L 19.634766 7 L 4.3652344 7 z"></path>
                                </svg>
                            </button>
                            <?php endif; ?>
                        </div>
                    </form>
                    <div class="archive-content archive-film">
                        <?= do_shortcode('[wpct_bm_bookmarks list_id="' . $list->id . '" user_id="' . $profile_user->ID . '"]<h4>' . __('The list is empty', 'miradnativa') . '</h4>[/wpct_bm_bookmarks]') ?>
                    </div>
                </section>
            <?php endforeach; ?>
            <section class="wp-block-group alignwide mn-profile-section" id="ratings">
                <div class="mn-profile-section__title">
                    <h4><?= pll__('Valoraciones', "miradanativa")  ?></h4>
                </div>
                <?php wp_set_current_user($profile_user->ID); ?>
                <?= do_shortcode('[yasr_user_rate_history]'); ?>
                <?php wp_set_current_user($session_user->ID); ?>
            </section>
            <section class="wp-block-group alignwide mn-profile-section" id="new-list">
                <form class="mn-profile-form mn-new-list-form" method="GET">
                    <input type="text" name="_ajax_nonce" value="<?= $nonce ?>" style="display:none" />
                    <input type="text" name="action" value="wpct_bm_add_list" style="display:none" />
                    <input type="text" name="user_id" value="<?= $profile_user->ID ?>" style="display:none" />
                    <label><?= pll__('List name', 'miradanativa') ?>
                    <input name="list_name" type="text" /></label>
                    <input type="submit" value="<?= pll__('Submit', 'miradanativa') ?>" />
                </form>
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
    for (const button of document.querySelectorAll(".wpct-bm-bookmark")) {
        button.addEventListener("ajax:change", (ev) => {
            if (ev.detail.action === "wpct_bm_drop_bookmark") {
                const filmWrapper = ev.target.closest("article.film.type-film");
                filmWrapper.classList.add("fade-out");
                setTimeout(() => {
                     filmWrapper.parentElement.removeChild(filmWrapper);
                }, 400)
            }
        })
    }

    const forms = document.querySelectorAll(".mn-profile-form");
    Array.from(forms).forEach((form) => {
        form.addEventListener("submit", (ev) => {
            ev.preventDefault();
            const submitter = ev.submitter;
            if (submitter.getAttribute("action") === "share") {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert("<?= pll__('Link coppied to the clipboard', 'miradanativa'); ?>");
                });
                return;
            }

            const formData = new FormData(form);
            const query = new URLSearchParams();
            Array.from(formData.entries()).forEach(([key, val]) => {
                query.set(key, val);
            });

            fetch("<?= admin_url('admin-ajax.php') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded; charset=utf-8",
                    Accept: "application/json; charset=utf-8",
                },
                body: query.toString(),
            }).then(res => {
                    if (!res.ok) {
                        throw new Error(res); 
                    }
                    return res.json();
                })
                .then(() => {
                    window.location = window.location.pathname;
                }).catch(err => {
                    console.error(err);
                });
        });
    });
    </script>
</main>

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();
