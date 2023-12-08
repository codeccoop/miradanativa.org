<?php

function adjust_vimeography_privacy_filter()
{
    return 'none';
}

add_filter('vimeography.request.privacy.filter', 'adjust_vimeography_privacy_filter');
add_filter('vimeography.privacy.enable_referrer', '__return_true');

// global $indiCategories, $indiTemas, $indiCatalogOrder, $indiHomeOrder, $indiTemaOrder;
$indiCategories = [
    "indifest2020" => [
        "titulo" => "Estrenos del IndiFEST 2020",
        "shortGalleryId" => "6",
        "detailledGalleryId" => "6"
    ],
    "documentales" => [
        "titulo" => "Reportajes y Documentales",
        "shortGalleryId" => "9",
        "detailledGalleryId" => "9"
    ],
    "peliculas" => [
        "titulo" => "Peliculas",
        "shortGalleryId" => "4",
        "detailledGalleryId" => "4"
    ],
    "cortometrajes" => [
        "titulo" => "Cortometrajes",
        "shortGalleryId" => "5",
        "detailledGalleryId" => "5"
    ],
    "anime" => [
        "titulo" => "Animé y Animación",
        "shortGalleryId" => "2",
        "detailledGalleryId" => "2"
    ],
    "familiar" => [
        "titulo" => "Familiar y Infantil",
        "shortGalleryId" => "1",
        "detailledGalleryId" => "1"
    ],
    "musica" => [
        "titulo" => "Musicales, VideoClips, Conciertos",
        "shortGalleryId" => "7",
        "detailledGalleryId" => "7"
    ],
    "destacados" => [
        "titulo" => "Destacados",
        "shortGalleryId" => "8",
        "detailledGalleryId" => "8"
    ]
];

$indiTemas = [
    "Identidad y Pandemia" => [
        "titulo" => "Identidad y pandemia. Alternativas desde el buen vivir de los pueblos",
        "shortGalleryId" => "14",
        "detailledGalleryId" => "14"
    ],
    "Agua es Vida" => [
        "titulo" => "Agua es Vida. Territorio y Transnacionales",
        "shortGalleryId" => "13",
        "detailledGalleryId" => "13"
    ],
    "Defensoras de Derechos" => [
        "titulo" => "Defensoras de Derechos. Criminalización y judicialización",
        "shortGalleryId" => "12",
        "detailledGalleryId" => "12"
    ],
    "Communicacion derechos" => [
        "titulo" => "Comunicación por la Defensa de Derechos",
        "shortGalleryId" => "11",
        "detailledGalleryId" => "11"
    ],
    "Resistencias Indígenas" => [
        "titulo" => "Resistencias Indígenas",
        "shortGalleryId" => "10",
        "detailledGalleryId" => "10"
    ],
];

$indiCatalogOrder = [
    "indifest2020",
    "documentales",
    "cortometrajes",
    "anime",
    "familiar",
    "musica",
    "peliculas"
];

$indiTemaOrder = [
    "Identidad y Pandemia",
    "Agua es Vida",
    "Defensoras de Derechos",
    "Communicacion derechos",
    "Resistencias Indígenas"
];

$indiHomeOrder = ["destacados"];

function catalogTemplate($categoryName)
{
    global $indiCategories;
    return "<h2>" . $indiCategories[$categoryName]['titulo'] . "</h2>" . do_shortcode('[vimeography id="' . $indiCategories[$categoryName]['shortGalleryId'] . '"]');
};

function homeTemplate($categoryName)
{
    global $indiCategories;
    return "<h2>" . $indiCategories[$categoryName]['titulo'] . "</h2>" . do_shortcode('[vimeography id="' . $indiCategories[$categoryName]['shortGalleryId'] . '"]');
};

function temaTemplate($categoryName)
{
    global $indiTemas;
    return "<h2>" . $indiTemas[$categoryName]['titulo'] . "</h2>" . do_shortcode('[vimeography id="' . $indiTemas[$categoryName]['shortGalleryId'] . '"]');
};

add_shortcode('printCatalogCaroussels', function () {
    global $indiCatalogOrder;
    $out = "";
    foreach ($indiCatalogOrder as &$category) {
        $out = $out . catalogTemplate($category);
    }
    return $out;
});

add_shortcode('printHomeCaroussels', function () {
    global $indiHomeOrder;
    $out = "";
    foreach ($indiHomeOrder as &$category) {
        $out = $out . homeTemplate($category);
    }
    return $out;
});

add_shortcode('printTemaCaroussels', function () {
    global $indiTemaOrder;
    $out = "";
    foreach ($indiTemaOrder as &$category) {
        $out = $out . temaTemplate($category);
    }
    return $out;
});
