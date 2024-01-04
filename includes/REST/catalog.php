<?php

namespace MN\REST\catalog;

function get_film_custom_fields($post_id)
{
    $fields = [
        'vimeo_id',
        'thumbnail',
        'poster',
        'description',
        'long_description',
        'duration',
        'year',
        'language',
        'subtitles',
        'casting',
        'awards',
        'related_links',
    ];
    $meta = [];
    foreach ($fields as $field) {
        $key = $field;
        $value = get_field($field, $post_id);
        $meta[$key] = $value;
    }

    return $meta;
}

function get_film_taxonomies($post_id)
{
    $taxonomies = [
        'mn_etiqueta',
        'mn_genero',
        'mn_metraje',
        'mn_produccion',
        'mn_pueblo_indigena',
        'mn_realizacion',
        'mn_tematica',
        'mn_zona_geografica',
    ];

    $terms = [];
    foreach ($taxonomies as $taxonomy) {
        $tax_terms = get_the_terms($post_id, $taxonomy);
        if (!$tax_terms) continue;
        $terms[$taxonomy] = array_values(array_map(function ($term) {
            return  $term->name;
        }, $tax_terms));
    }

    return $terms;
}



function export_catalog($request)
{

    $args = array(
        'post_type' => 'film',
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
    );
    if (isset($request['id'])) {
        $args['p'] = (int) $request['id'];
    }
    if (isset($request['lang'])) {
        $args['lang'] = $request['lang'];
    }

    // return $args;
    $posts = get_posts($args);
    $catalog = [];
    foreach ($posts as $post) {

        $custom_fields = get_film_custom_fields($post->ID);
        $taxonomies = get_film_taxonomies($post->ID);
        $title = $post->post_title;
        $url = get_permalink($post->ID);
        $record = array(
            'title' => $title,
            'slug' => $post->post_name,
            'url' => $url,
            'authors' => $taxonomies['mn_produccion'],
            'description' => $custom_fields['description'],

        );
        array_push($catalog, $record);
    }
    return $catalog;
}
