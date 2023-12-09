<?php

add_action('acf/include_fields', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_6574ae2624f37',
        'title' => 'Blog',
        'fields' => array(
            array(
                'key' => 'field_6574ae27c720d',
                'label' => 'Subtítulo',
                'name' => 'subtitle',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => 'Este es el subtítulo de las entradas del blog',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_6574ae34c720e',
                'label' => 'Autor 1',
                'name' => 'author_1',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => 'Nombre del autor/a del post',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_6574ae63c720f',
                'label' => 'Autor 2',
                'name' => 'author_2',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => 'Nombre del/la segunda autora del post (opcional)',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_6574aed1c7210',
                'label' => 'Película',
                'name' => 'film',
                'aria-label' => '',
                'type' => 'post_object',
                'instructions' => 'En caso de ser una recomendación, selecciona la película asociada a este post',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'film',
                ),
                'post_status' => array(
                    0 => 'publish',
                ),
                'taxonomy' => '',
                'return_format' => 'id',
                'multiple' => 0,
                'allow_null' => 0,
                'bidirectional' => 0,
                'ui' => 1,
                'bidirectional_target' => array(),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'blog',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
});
