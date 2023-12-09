<?php

add_shortcode('mn_blog_feed', 'mn_blog_feed');
function mn_blog_feed()
{
    $posts = get_posts([
        'post_type' => 'blog',
        'numberposts' => 3,
        'post_status' => 'publish'
    ]);

    ob_start(); ?>
    <h5 class="wp-block-heading has-primary-color has-text-color has-link-color">Blog</h5>
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
    <div class="wp-block-buttons is-content-justification-center is-layout-flex wp-container-core-buttons-layout-4 wp-block-buttons-is-layout-flex">
        <div class="wp-block-button is-style-outline">
            <?php
            $lng = pll_current_language();
            $blog_url = $lng === 'es' ? site_url() . '/blog' : site_url() . '/' . $lng . '/blog';
            ?>
            <a href="<?= $blog_url; ?>" class="wp-block-button__link wp-element-button"><?= pll__('Ver más publicaciones'); ?></a>
        </div>
    </div>
<?php
    return ob_get_clean();
}
