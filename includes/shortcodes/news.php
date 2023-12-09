<?php

function miradanativa_getposts_function()
{
    $posts = get_posts([
        'post_type' => 'post',
        'numberposts' => 3,
        'post_status' => 'publish'
    ]);

    ob_start(); ?>
    <h5 class="frontpage_news_section_title">Blog</h5>
    <div class="frontpage_news">
        <?php foreach ($posts as $key => $post) : ?>
            <div class="<?= $post->ID ?>">
                <?php if (has_post_thumbnail($post->ID)) : ?>
                    <a class="thumbnail-img" href="<?= get_permalink($post->ID) ?>" target="_blank"><?= get_the_post_thumbnail($post->ID) ?></a>
                <?php endif; ?>
                <a class="frontpage_title" href="<?= get_permalink($post->ID) ?>" target="_blank">
                    <h5><?= $post->post_title ?></h5>
                </a>
                <?php
                $category = get_the_category($post->ID);
                $category = $category[0];
                $date = get_the_date('j \d\e F \d\e Y', $post->ID);
                ?>
                <p class="news_meta"><?= $date ?> | <?= $category->name; ?></p>
                <p class="news_excerpt has-small-font-size"><?= $post->post_excerpt ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="wp-block-buttons is-content-justification-center">
        <div class="wp-block-button inverted is-style-outline">
            <a class="news_archive_button wp-block-button__link" href="<?= site_url() . '/noticias'; ?>" target="_blank"><?= pll__("Ver más publicaciones") ?></a>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('miradanativa_getposts', 'miradanativa_getposts_function');
