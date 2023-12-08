<?php

/**
 * Allow Pods Templates to use shortcodes
 *
 * NOTE: Will only work if the constant PODS_SHORTCODE_ALLOW_SUB_SHORTCODES is defined and set to
true, which by default it IS NOT.
 */
add_filter('pods_shortcode', function ($tags) {
    $tags['shortcodes'] = true;

    return $tags;
});

// define the pods_content callback
function filter_pods_content($content, $pods_page)
{
    $slug1 = pods_v(0, 'url');
    $slug2 = pods_v(1, 'url');
    if ($slug1 === 'pelicula') {
        $template = "Ficha Pelicula";
    }
    if ($slug2 === 'pelicula') {
        $template = "Ficha Pelicula " . pods_v(0, 'url');
    }
    $slug = pods_v('last', 'url');
    return do_shortcode('[pods name=”pelicula” slug="' . $slug . '" template="' . $template . '"]');
};

// add the filter
add_filter('pods_content', 'filter_pods_content', 10, 2);


/**
 * Validator
 **/
function validatePods($validate, $value, $field, $object_fields, $fields, $pod, $params)
{


    // Don't do anything if it is not the pod we want to check.
    if (
        'tematica' === $pod['name']
        or 'premio' === $pod['name']
        or 'genero' === $pod['name']
        or 'etiqueta' === $pod['etiqueta']
        or 'realizacion' === $pod['name']
        or 'produccion' === $pod['name']
        or 'pueblo_indigena' === $pod['name']
    ) {
        if ('name' === $field and strpos($value, ',') !== false) {
            return 'El campo <b>name</b> no puede contener <b>commas</b>, es un identificador en su CMS !';
        }
    }

    return $validate;
}

add_filter('pods_api_field_validation', 'validatePods', 10, 7);

function makeCarroussels($_taxonomia, $_template, $_lang)
{
    $out = "";


    $params_taxonomia = array(
        'orderby' => 'nombre ASC'
    );
    if ($_taxonomia == 'tematica') { //in case ot tematicas, except destacados
        $params_taxonomia = array(
            'orderby' => 'nombre ASC',
            'where' => "slug != 'destacados'"
        );
    }
    $taxonomia = pods($_taxonomia, $params_taxonomia);

    //check that total values (given limit) returned is greater than zero
    if ($taxonomia->total() > 0) {
        //loop through items pods:fetch acts like the_post()
        while ($taxonomia->fetch()) {
            $out = $out . _makeCarrousselForTaxonomy($taxonomia, $_template, $_lang);
        }
    }

    return $out;
}

/**
 *Shortcodes
 **/
function makeCarroussel($_taxonomia, $_slug, $_template, $_lang)
{
    $out = "";

    $params_taxonomia = array(
        'orderby' => 'nombre ASC',
        'where' => "slug = '" . $_slug . "'"
    );
    $taxonomia = pods($_taxonomia, $params_taxonomia);

    //check that total values (given limit) returned is greater than zero
    if ($taxonomia->total() > 0) {
        //loop through items pods:fetch acts like the_post()
        while ($taxonomia->fetch()) {
            $out = $out . _makeCarrousselForTaxonomy($taxonomia, $_template, $_lang);
        }
    }

    return $out;
}

/**
 *Shortcodes
 **/
function makeMoreLikeThisCarroussel($_pelicula_id, $_template, $_lang)
{
    //it selects the 20 latest peliculas that share at least 1 tematica or 1 pueblo or 1 geografic zone with the current pelicula
    //set language
    $_lang = pll_current_language();
    //set up pods::find peliculas parameters
    $mypod = pods('pelicula', $_pelicula_id);

    $relatedTematicas = relation_in('tematica', $mypod);
    $relatedPueblos = relation_in('pueblo_indigena', $mypod);
    $zonaGeograficas = relation_in('zona_geografica', $mypod);
    if (empty($relatedTematicas) && empty($relatedPueblos) && empty($zonaGeograficas)) {
        $relatedTematicas = "'destacados'";
    }

    $params_pelicula = array(
        'limit' => 20,
        'where' => "(id != $_pelicula_id ) and (tematica.slug in ($relatedTematicas) or pueblo_indigena.slug in ($relatedPueblos) or zona_geografica.slug in ($zonaGeograficas))",
        'orderby' => 'date DESC'
    );
    $peliculas = pods('pelicula', $params_pelicula);

    if ($peliculas->total() > 0) {
        $title = "Películas relacionadas";
        $template = $_template;
        if (!empty($_lang) and $_lang === 'ca') {
            $title = "Pel·lícules relacionades";
            $template = $_template . " ca";
        }
        return _printCarroussel($peliculas, $template, $title);
    }
    return "";
}

function relation_in($_taxonomia, $_pod)
{
    $out = "";

    if (!empty($_pod->field($_taxonomia))) {
        foreach ($_pod->field($_taxonomia . ".slug") as $key => $value) {
            if ($key > 0) {
                $out = $out . ",";
            }
            $out = $out . "'" . $value . "'";
        }
    }

    return $out;
}

function _makeCarrousselForTaxonomy($_taxonomia, $_template, $_lang)
{
    //set up pods::find peliculas parameters
    $params_pelicula = array(
        'limit' => 40,
        'where' => $_taxonomia->field('taxonomy') . ".slug = '" . $_taxonomia->field('slug') . "'",
        'orderby' => 'date DESC'
    );
    $peliculas = pods('pelicula', $params_pelicula);

    if ($peliculas->total() > 0) {
        $title = $_taxonomia->field('nombre');
        $template = $_template;
        if (!empty($_lang) and $_lang === 'ca') {
            $title = $_taxonomia->field('nombre_cat');
            $template = $_template . " ca";
        }
        return _printCarroussel($peliculas, $template, $title);
    }

    return "";
}

function _printCarroussel($_peliculas, $_template, $_carrousel_title)
{
    $out = "<div class='indi_carousel_wrapper'>";
    if (isset($_carrousel_title) and !empty($_carrousel_title)) {
        $out = $out . '<h2>' . $_carrousel_title . '</h2>';
    }
    $out = $out . "<div class='jcarousel-wrapper'>";
    $out = $out . '<div class="jcarousel">
            <div>';
    $out = $out . $_peliculas->template($_template);
    $out = $out . '</div>
        </div>';
    $out = $out . '<a href="#" class="jcarousel-control-prev" data-jcarouselcontrol="true">‹</a><a href="#" class="jcarousel-control-next" data-jcarouselcontrol="true">›</a>';
    $out = $out . '</div>
</div>';

    return $out;
}

add_shortcode('carrousels_tematicas', function ($atts) {
    return makeCarroussels('tematica', "InCarrousel Pelicula", $atts['lang']);
});
add_shortcode('carrousels_generos', function ($atts) {
    return makeCarroussels('genero', "InCarrousel Pelicula", $atts['lang']);
});
add_shortcode('carrousel_more_like_this', function ($atts) {
    return makeMoreLikeThisCarroussel($atts['pelicula_id'], "InCarrousel Pelicula", $atts['lang']);
});
add_shortcode('carrousel_for_tematica', function ($atts) {
    return makeCarroussel('tematica', $atts['slug'], "InCarrousel Pelicula", $atts['lang']);
});
add_shortcode('carrousel_for_genero', function ($atts) {
    return makeCarroussel('genero', $atts['slug'], "InCarrousel Pelicula", $atts['lang']);
});

