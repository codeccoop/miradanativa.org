<?php

function mn_get_post_by_slug($slug, $post_type)
{
    $posts = get_posts([
        'name' => $slug,
        'post_type' => $post_type,
        'numberposts' => 1,
        'post_status' => [
            'publish',
            'pending',
            'draft',
            'auto-draft',
            'future',
            'private',
            'inherit',
            'trash'
        ]
    ]);
    if (sizeof($posts) === 0) return null;
    return $posts[0];
}

function mn_get_taxonomies($post_type = null)
{
    $pelicula_taxonomies = [
        'etiqueta',
        'genero',
        'metraje',
        'produccion',
        'pueblo_indigena',
        'realizacion',
        'tematica',
        'zona_geografica',
        'cataleg',
    ];

    $festival_taxonomies = [];

    $post_taxonomies = [
        'post_tag',
        'category',
    ];

    if ($post_type === 'pelicula') return $pelicula_taxonomies;
    else if ($post_type === 'festival') return $festival_taxonomies;
    else if ($post_type === 'post') return $post_taxonomies;
    else return array_merge($pelicula_taxonomies, $festival_taxonomies, $post_taxonomies);
}

function mn_get_custom_fields($post_type = null)
{
    $pelicula_fields = [
        'titulo',
        'vimeo_id',
        'cartel_en_carrousels',
        'cartel_en_ficha',
        'sinopsis',
        'sinopsis_larga',
        'duracion',
        'ano_produccion',
        'idioma',
        'subtitulos',
        'reparto',
        'premios',
        'enlaces',
    ];

    $festival_fields = [
        'cartel_festival',
        'logo_festival',
        'sobre_nosotras',
        'color_del_festival',
        'color_del_fondo',
        'color_de_fuente',
        'link_twitter',
        'link_instagram',
        'link_facebook',
        'link_youtube',
        'web_festival',
        'mail_contacto',
        'direccion_contacto',
        'logos_colaboradores',
        'logos_impulsores',
        'programacion'
    ];

    $post_fields = [
        'subtitulo',
        'autor_1',
        'autor_2',
        'film_selector',
    ];

    if ($post_type === 'pelicula') return $pelicula_fields;
    else if ($post_type === 'festival') return $festival_fields;
    else if ($post_type === 'post') return $post_fields;
    else return array_merge($pelicula_fields, $festival_fields, $post_fields);
}

function mn_get_post_types()
{
    return [
        'pelicula',
        'festival',
        'post',
    ];
}

function mn_get_field_key($field)
{
    $map = [
        'vimeo_id' => 'vimeo_id',
        'cartel_en_carrousels' => 'thumbnail',
        'cartel_en_ficha' => 'poster',
        'sinopsis' => 'description',
        'sinopsis_larga' => 'long_description',
        'duracion' => 'duration',
        'ano_produccion' => 'year',
        'idioma' => 'language',
        'subtitulos' => 'subtitles',
        'reparto' => 'casting',
        'premios' => 'awards',
        'enlaces' => 'related_links',
        'cartel_festival' => 'poster',
        'logo_festival' => 'logo',
        'sobre_nosotras' => 'description',
        'color_del_festival' => 'primary_color',
        'color_del_fondo' => 'secondary_color',
        'color_de_fuente' => 'text_color',
        'link_twitter' => 'twitter',
        'link_instagram' => 'instagram',
        'link_facebook' => 'facebook',
        'link_youtube' => 'youtube',
        'web_festival' => 'web',
        'mail_contacto' => 'email',
        'direccion_contacto' => 'address',
        'logos_colaboradores' => 'partners_logos',
        'logos_impulsores' => 'founders_logos',
        'programacion' => 'program',
        'subtitulo' => 'subtitle',
        'autor_1' => 'author_1',
        'autor_2' => 'author_2',
        'film_selector' => 'film',
    ];

    if (isset($map[$field])) return $map[$field];
    return $field;
}

function mn_get_field_value($field, $value)
{
    if (!$value) return null;
    try {
        $is_image = in_array($field, ['cartel_en_ficha', 'cartel_en_carrousels', 'cartel_festival', 'logo_festival']);

        if ($field === 'film_selector') {
            $pelicula = get_post((int) $value['ID']);
            $film = mn_get_post_by_slug($pelicula->post_name, 'film');
            return $film->ID;
        } else if ($is_image) return (int) $value['ID'];
        if (sizeof($value) > 0) return reset($value);
        return "";
    } catch (Exception) {
        return null;
    }
}

function mn_create_posts($post_type, $lng = 'es')
{
    if (!in_array($post_type, mn_get_post_types())) {
        throw new Exception('Invalid post type');
    }

    $posts = get_posts([
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'post_status' => [
            'publish',
            'pending',
            'draft',
            'auto-draft',
            'future',
            'private',
            'inherit',
            'trash'
        ]
    ]);

    if (in_array($post_type, ['festival', 'post'])) {
        $posts = array_values(array_filter($posts, function ($post) use ($lng) {
            return pll_get_post_language($post->ID) === $lng;
        }));
    }

    foreach ($posts as $post) {
        $post_meta = mn_get_post_meta($post_type, $post->ID, $lng);
        $post_terms = mn_get_post_terms($post_type, $post->ID, $lng);
        $post_thumbnail = get_post_thumbnail_id($post->ID);

        $postarr = wp_slash(get_object_vars($post));
        unset($postarr['ID']);
        $postarr['post_type'] = $post_type === 'pelicula'
            ? 'film' : ($post_type === 'festival'
                ? 'fest' :
                'blog');

        if (isset($post_meta['titulo']) && sizeof($post_meta['titulo'])) {
            $postarr['title'] = $post_meta['titulo'][0];
        }

        if ($lng === 'ca' && !in_array($post_type, ['festival', 'post'])) {
            $postarr['post_name'] = $postarr['post_name'] . '-ca';
        }

        $new_id = wp_insert_post($postarr);
        pll_set_post_language($new_id, $lng);
        if ($post_thumbnail) {
            set_post_thumbnail($new_id, $post_thumbnail);
        }

        foreach ($post_terms as $taxonomy => $terms) {
            $ns_tax = in_array($taxonomy, ['post_tag', 'category']) ? $taxonomy : 'mn_' . $taxonomy;
            wp_set_post_terms($new_id, implode(',', array_map(function ($term) use ($lng, $taxonomy) {
                if ($lng !== 'ca') return $term;
                if (in_array($taxonomy, ['cataleg', 'post_tag', 'category'])) return $term;
                return $term . '-ca';
            }, $terms)), $ns_tax);
        }

        foreach ($post_meta as $field => $value) {
            $key = mn_get_field_key($field);
            $value = mn_get_field_value($key, $value);
            update_field($key, $value, $new_id);
        }
    }
}

function mn_get_post_terms($post_type, $post_id, $lng = 'es')
{
    $taxonomies = mn_get_taxonomies($post_type);

    $terms = [];
    foreach ($taxonomies as $taxonomy) {
        if ($taxonomy === 'cataleg') {
            $tax_terms = get_the_terms($post_id, $taxonomy);
            if (!$tax_terms) continue;
            $tax_terms = array_map(function ($term) {
                return get_object_vars($term);
            }, array_values(array_filter($tax_terms, function ($term) use ($lng) {
                $post = mn_get_post_by_slug($term->slug, 'festival');
                if (!$post) return false;
                return pll_get_post_language($post->ID) === $lng;
            })));
        } else {
            $tax_terms = pods_field($post_type, $post_id, $taxonomy);
        }
        if (!$tax_terms) continue;
        $terms[$taxonomy] = array_values(array_map(function ($term) {
            return $term['slug'];
        }, $tax_terms));
    }

    return $terms;
}

function mn_get_post_meta($post_type, $post_id, $lng = 'es')
{
    $fields = mn_get_custom_fields($post_type);

    $meta = [];
    foreach ($fields as $field) {
        $key = $field;
        $values = pods_field($post_type, $post_id, $field);
        if ($lng === 'ca') {
            $trans = pods_field($post_type, $post_id, $field . '_cat');
            if ($trans && sizeof($trans) > 0) {
                $values = $trans;
            }
        }
        $meta[$key] = $values;
    }

    return $meta;
}

function mn_create_terms($taxonomy, $lng = 'es')
{
    if (!in_array($taxonomy, mn_get_taxonomies())) {
        throw new Exception('Invalid taxonomy');
    } else if (in_array($taxonomy, ['post_tag', 'category'])) {
        return;
    }

    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ]);

    if ($taxonomy === 'cataleg') {
        $terms = array_values(array_filter($terms, function ($term) use ($lng) {
            $post = mn_get_post_by_slug($term->slug, 'festival');
            if (!$post) return false;
            return pll_get_post_language($post->ID) === $lng;
        }));
    }

    foreach ($terms as $term) {
        if ($taxonomy === 'cataleg') {
            $meta = [];
        } else {
            $meta = get_term_meta($term->term_id);
        }

        if (isset($meta['nombre']) && sizeof($meta['nombre'])) {
            $name = $meta['nombre'][0];
        } else {
            $name = $term->name;
        }

        $slug = $term->slug;

        if ($lng === 'ca') {
            if (isset($meta['nombre_cat']) && sizeof($meta['nombre_cat'])) {
                $name = $meta['nombre_cat'][0];
            }
            if ($taxonomy !== 'cataleg') {
                $slug = $slug . '-ca';
            }
        }

        $term = wp_insert_term($name, 'mn_' . $taxonomy, [
            'description' => $term->description,
            'slug' => $slug,
        ]);

        pll_set_term_language($term['term_id'], $lng);
    }
}

function mn_translate_terms($taxonomy)
{
    if (in_array($taxonomy, ['post_tag', 'category'])) return;

    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ]);

    foreach ($terms as $term) {
        if ($taxonomy === 'cataleg') {
            $post = mn_get_post_by_slug($term->slug, 'festival');
            if (!$post) continue;
            $trans = pll_get_post_translations($post->ID);
            $post_es = get_post($trans['es']);
            $post_ca = get_post($trans['ca']);
            $term_es = get_term_by('slug', $post_es->post_name, $taxonomy);
            $term_ca = get_term_by('slug', $post_ca->post_name, $taxonomy);
            pll_save_term_translations([
                'es' => $term_es->term_id,
                'ca' => $term_ca->term_id,
            ]);
        } else {
            if (preg_match('/-ca$/', $term->slug)) continue;
            $trans = get_term_by('slug', $term->slug . '-ca', $taxonomy);
            if (!$trans) continue;
            pll_save_term_translations([
                'es' => $term->term_id,
                'ca' => $trans->term_id,
            ]);
        }
    }
}

function mn_translate_posts($post_type)
{
    $posts = get_posts([
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'post_status' => [
            'publish',
            'pending',
            'draft',
            'auto-draft',
            'future',
            'private',
            'inherit',
            'trash'
        ],
    ]);

    foreach ($posts as $post) {
        $lng = pll_get_post_language($post->ID);
        if ($lng === 'ca') continue;

        if ($post_type === 'film') {
            $trans = mn_get_post_by_slug($post->post_name . '-ca', $post_type);
            if (!$trans) continue;
        } else {
            $source_type = $post_type === 'fest' ? 'festival' : 'post';
            $_post = mn_get_post_by_slug($post->post_name, $source_type);
            $trans = pll_get_post_translations($_post->ID);
            if (!$trans) continue;
            $trans = get_post($trans['ca']);
            $trans = mn_get_post_by_slug($trans->post_name, $post_type);
        }

        pll_save_post_translations([
            'es' => $post->ID,
            'ca' => $trans->ID,
        ]);
    }
}

function mn_migrate_db()
{
    foreach (mn_get_taxonomies() as $taxonomy) {
        mn_create_terms($taxonomy);
        mn_create_terms($taxonomy, 'ca');
        if (in_array($taxonomy, ['post_tag', 'category'])) continue;
        mn_translate_terms('mn_' . $taxonomy);
    }

    foreach (mn_get_post_types() as $post_type) {
        mn_create_posts($post_type);
        mn_create_posts($post_type, 'ca');
        $post_type = $post_type === 'pelicula' ? 'film' : ($post_type === 'post' ? 'blog' : 'fest');
        mn_translate_posts($post_type);
    }
}

add_action('init', 'mn_do_migration');
function mn_do_migration()
{
    if (!isset($_GET['mn-db-migration'])) return;

    mn_migrate_db();
    if (ob_get_contents()) ob_get_clean();
    echo '{"success":true}';
    die();
}
