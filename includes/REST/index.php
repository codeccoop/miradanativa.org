<?php
require_once('catalog.php');

use MN\REST\catalog\export_catalog;

add_action('rest_api_init', function () {
    register_rest_route('mn/v1', '/catalog/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function ($request) {
            return MN\REST\catalog\export_catalog($request);
        },
        'permission_callback' => '__return_true',
        'args' => array(
            'id' => array(
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            )
        )
    ));
    register_rest_route('mn/v1', '/catalog', array(
        'methods' => 'GET',
        'callback' => function ($request) {
            return MN\REST\catalog\export_catalog($request);
        },
        'permission_callback' => '__return_true',
        'args' => array(
            'lang' => array(
                'description' => 'This parameter is used to query films by language',
                'type' => 'string',
                'required' => true,
            )
        )

    ));
});
