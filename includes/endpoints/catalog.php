<?php

function mn_parse_duration($duration) 
{
    if (empty($duration)) return null;
    preg_match('/(?:(\d+) *h[^\d]*)?(\d+) *m[^\d]*(?:(\d+) *s)?/', $duration, $matches);
  if (empty($matches)) return -1;
        
   $houres = (int) $matches[1];
   $minutes = (int) $matches[2];
   if (!isset($matches[3])) { 
         $seconds = 0;
   } else{
    $seconds = (int) $matches[3]; 
   } 
    

    return $houres * 3600 + $minutes * 60 + $seconds;
}

function mn_filter_rich_text($text)
{
    if (empty($text)) return $text;

    return preg_replace('/(\n|\r|&nbsp;)+/', ' ', strip_tags($text));
}

function mn_encode_languages($languages){
    $split_langs =  preg_split("/\,/", $languages);
    foreach ($split_langs as $key => $split_lang){
        $split_langs[$key] = trim($split_lang);
        switch ($split_langs[$key]){
            case "Castellano":
            case "Español":
            case "castellano":
            case "Castellà":
            case "castellà":
            case "Espanyol":
            case "Spanish":
                $split_langs[$key] = "spa";
                break;
            case "català":
            case "catalán":
            case "Catalan":
                $split_langs[$key] = "cat";
                break;
            case "italià":
            case "italiano":
            case "Italian":
                $split_langs[$key] = "ita";
                break;
            case "polonès":
            case "polaco":
                break;
            case "Shipibo":
                $split_langs[$key] = "shp";
                break;
            case "Nasa":
            case "Nasa yuwe":
                $split_langs[$key] = "pbb";
                break;
            case "Guna":
            case "Dulegaya":
            case "kuna":
                $split_langs[$key] = "cuk";
                break;
            case "wayuunaiki":
            case "Wayuunaiki":    
                $split_langs[$key] = "guc";
                break;
            case "Taushiro":
                $split_langs[$key] = "trr";
                break;
            case "Bora":
                $split_langs[$key] = "boa";
                break;
            case "Zoque":
                $split_langs[$key] = "zos";
                break;
            case "Tseltal":
            case "tseltal": 
                $split_langs[$key] = "tzh";
                break;
            case "chol": 
                $split_langs[$key] = "ctu";
                break;
            case "nahua": 
                $split_langs[$key] = "nlv";
                break;
            case "otomí": 
                $split_langs[$key] = "otm";
                break;
            case "Quechua":
            case "Kichwa":
            case "Quítxua":
                $split_langs[$key] = "qvc";
                break;
            case "Kichwa amazónico":
            case "Kichwa-amazónico":
            case "Kichwa amazònic":
            case "Kichwa-amazònic":
                $split_langs[$key] = "qvo";
                break;
            case "mixteco":
            case "Mixteco":
                $split_langs[$key] = "mig";
                break;
            case "neerlandés":
            case "neerlandès":
                $split_langs[$key] = "ndl";
                break;
            case "aimara":
            case "Aymara":
            case "aymara":
                $split_langs[$key] = "aym";
                break;
            case "Woun Meu":
                $split_langs[$key] = "noa";
                break;
            case "Javanés":
            case "Javanès":
                $split_langs[$key] = "jav";
                break;
            case "purépecha":
                $split_langs[$key] = "tsz";
                break;
            case "yagankuta":
                $split_langs[$key] = "yag";
                break;
            case "qom":
            case "Qom":
                $split_langs[$key] = "tob";
                break;
            case "Mapuzugun":
            case "Mapuzungun":
            case "Mapudungun":
            case "Mapundungun":
            case "Mapuzugún":
            case "Mapuzugun":
            case "Mapuzungún":
            case "Lafkenmapu Ñi Dungun":
            case "mapudungun":
                $split_langs[$key] = "arn";
                break;
            case "Sikuani":
            case "Sikuani":
                $split_langs[$key] = "guh";
                break;
            case "Inglés":
            case "inglés":
            case "Anglès":
            case "anglès":
            case "anlgès":
            case "English":
                $split_langs[$key] = "eng";
                break;
            case "Inuktitut":
                $split_langs[$key] = "iku";
                break;

            case "Emberá":
            case "Emberà":
            case "emberà":
            case "emberá":
            case "Embera":
            case "Embere":
                $split_langs[$key] = "emp";
                break;

            case "Innu-aimun":
                $split_langs[$key] = "moe";
                break;

            case "francés":
            case "francès":
            case "French":
                $split_langs[$key] = "fra";
                break;
            case "Xavante":
                $split_langs[$key] = "xav";
                break;
            case "Wichi":
                $split_langs[$key] = "mtp";
                break;
            case "Tikuna":
                $split_langs[$key] = "tca";
                break;
            case "portugués":
            case "Portugués":
            case "portuguès":
            case "Português":
            case "Portuguès":
            case "Portuguese":
                
                $split_langs[$key] = "por";
                break;
            case "Shuar":
                $split_langs[$key] = "jiv";
                break;
            case "Maya Q’eqchi‘":
                $split_langs[$key] = "kek";
                break;
            case "Guarani":
            case "guaraní":  
            case "Guaraní":
                $split_langs[$key] = "grn";
                break;
            case "ayoreo":  
                $split_langs[$key] = "ayo";
                break;
            case "kawesqar":  
                $split_langs[$key] = "alc";
                break;
            case "Yuqui":  
                $split_langs[$key] = "yuq";
                break;
            case "Movima":  
                $split_langs[$key] = "mzp";
                break;
            case "Guarayo":  
                $split_langs[$key] = "gyr";
                break;
            case "Me'phaa":  
                $split_langs[$key] = "tcf";
                break;
            case "maya":  
                $split_langs[$key] = "quc";
                break;
            case "Tnu'usavi":  
                $split_langs[$key] = "mvg";
                break;
            case "Ese Eja":  
                $split_langs[$key] = "ese";
                break;
            case "Ese Eja":  
                $split_langs[$key] = "yag";
                break;
            default:
                $split_langs[$key] = "none";
        }
    }
 
    return $split_langs;
}

function mn_encode_geographic_area($zona_geografica){
    switch ($zona_geografica[0]->name){
        case "Argentina":
            $zona_geografica = array(
                'AR' => $zona_geografica[0]->name
            );
            break;
        case "Bolivia":
        case "Bolívia":
            $zona_geografica = array(
                'BO' => $zona_geografica[0]->name
            );
            break;
        case "Brasil":
        case "Brazil":
            $zona_geografica = array(
                'BR' => $zona_geografica[0]->name
            );
            break;
        case "Canadá":
        case "Canadà":
        case "Canada":
            $zona_geografica = array(
                'CA' => $zona_geografica[0]->name
            );
            break;
        case "Chile":
        case "Xile":
            $zona_geografica = array(
                'CL' => $zona_geografica[0]->name
            );
            break;
        case "Colombia":
        case "Colòmbia":
            $zona_geografica = array(
                'CO' => $zona_geografica[0]->name
            );
            break;
        case "Equador":
        case "Ecuador":
            $zona_geografica = array(
                'EC' => $zona_geografica[0]->name
            );
            break;
        case "España":
        case "Espanya":
        case "Spain": 
            $zona_geografica = array(
                'ES' => $zona_geografica[0]->name
            );
            break;
        case "Estados Unidos de América":
        case "Estats Units d'Amèrica":
        case "United States of America":
            $zona_geografica = array(
                'US' => $zona_geografica[0]->name
            );
            break;
        case "Filipinas":
        case "Filipines":
        case "Philippines":
            $zona_geografica = array(
                'PH' => $zona_geografica[0]->name
            );
            break;
        case "Guatemala":
            $zona_geografica = array(
                'GT' => $zona_geografica[0]->name
            );
            break;
        case "Honduras":
        case "Hondures":
            $zona_geografica = array(
                'HN' => $zona_geografica[0]->name
            );
            break;
        case "Indonesia":
        case "Indonèsia":
            $zona_geografica = array(
                'ID' => $zona_geografica[0]->name
            );
            break;
        case "Malasia":
        case "Malàisia":
        case "Malaysia":
            $zona_geografica = array(
                'MY' => $zona_geografica[0]->name
            );
            break;
        case "Marruecos":
        case "Marroc":
        case "Morocco":
            $zona_geografica = array(
                'MA' => $zona_geografica[0]->name
            );
            break;
        case "México":
        case "Mèxic":
        case  "Mexico":
            $zona_geografica = array(
                'MX' => $zona_geografica[0]->name
            );
            break;
        case "Panamá":
        case "Panamà":
        case "Panama":
            $zona_geografica = array(
                'PA' => $zona_geografica[0]->name
            );
            break;
        case "Paraguay":
        case "Paraguai":
            $zona_geografica = array(
                'PY' => $zona_geografica[0]->name
            );
            break;
        case "Perú":
        case "Peru":
            $zona_geografica = array(
                'PE' => $zona_geografica[0]->name
            );
            break;
        case "Portugal":
            $zona_geografica = array(
                'PT' => $zona_geografica[0]->name
            );
            break;
        case "Sahara Occidental":
        case "Sàhara Occidental":
        case "Western Sahara":
            $zona_geografica = array(
                'EH' => $zona_geografica[0]->name
            );
            break;
        case "Venezuela":
        case "Veneçuela":
            $zona_geografica = array(
                'VE' => $zona_geografica[0]->name
            );
            break;
        case "Wallmapu":
            $zona_geografica = array(
                'Wallmapu' => $zona_geografica[0]->name
            );
            break;
        default:
        $zona_geografica = array(
            'none' => 'none'
        );
    }
return $zona_geografica;
}

function mn_get_catalog($data)
{

    $params = $data->get_url_params();

    $args = [
        'post_type' => 'film',
        'posts_per_page' => -1,
        'meta_query' => [
            'relation' => 'AND',
            [
              'key' => 'vimeo_id',
              'compare' => 'EXISTS',
            ],
            [
              'key' => 'vimeo_id',
              'compare' => '!=',
              'value' => ''
            ],
            [
                'key' => 'vimeo_id',
                'compare' => '!=',
                'value' => 0,
            ],
            [
                'key' => 'export',
                'compare' => '=',
                'value' => 'yes',
            ],
        
        ],
        'tax_query' => array(
        array (
            'taxonomy' => 'mn_metraje',
            'field' => 'slug',
            'terms' => array ('serie', 'serie-ca'),
            'operator' => 'NOT IN',
        )
    ),
    ];

    if(!empty($params['lang'])) {
        $args['lang'] = $params['lang'];
    }

    $films = get_posts($args);

    if (empty($films)) {
        return null;
    };

    $data = array();
    foreach ($films as $film) {
        // $lang = pll_get_post_language($film->ID);
        $keywords = [];
        $filmmaking = [];

        $custom_fields = get_post_meta($film->ID);
        $zona_geografica = mn_encode_geographic_area(get_the_terms($film, 'mn_zona_geografica'));
        $pueblo_indigena = get_the_terms($film, 'mn_pueblo_indigena');
        $tematicas = get_the_terms($film, 'mn_tematica');

        if (!empty($tematicas)) {
            foreach ($tematicas as $tematica) {
                $name_tematica = $tematica->name;
                array_push($keywords, $name_tematica);

            }
        };

        $genero = get_the_terms($film, 'mn_genero');
        $metraje = get_the_terms($film, 'mn_metraje');
        $produccion = get_the_terms($film, 'mn_produccion');
        $realizacion = get_the_terms($film, 'mn_realizacion');

        if (!empty($realizacion)) {
            foreach ($realizacion as $value) {
                $name = $value->name;
                array_push($filmmaking, $name);
            }
        };

        
        $encoded_langs = mn_encode_languages($custom_fields['language'][0]);
        $encoded_subs = mn_encode_languages($custom_fields['subtitles'][0]);
        $data[] = [
            'id' => $film->ID,
            'url' => get_the_permalink($film),
            'title' => $film->post_title,
            'slug' => $film->post_name,
            'creation_date' => $film->post_date,
            'modified_date' => $film->post_modified,
            'vimeo_id' => $custom_fields['vimeo_id'][0],
            'excerpt' => mn_filter_rich_text($custom_fields['description'][0]),
            'featured_media' => isset($custom_fields['poster'][0]) ? wp_get_attachment_image_url($custom_fields['poster'][0], '') : null,
            'featured_cover' => isset($custom_fields['cover'][0]) ? wp_get_attachment_image_url($custom_fields['cover'][0], '') : null,
            'sinopsis' => mn_filter_rich_text($custom_fields['long_description'][0]),
            'language' => $encoded_langs,
            'subtitles' => $encoded_subs,
            'year' => (int) $custom_fields['year'][0],
            'duration' => mn_parse_duration($custom_fields['duration'][0]),
            'age' => $custom_fields['age'][0],
            'geographic_area' => $zona_geografica,
            'indigenous_group' => $pueblo_indigena[0]->name,
            'keywords' => $keywords,
            'genre' => $genero[0]->name,
            'film_type' => $metraje[0]->name,
            'producer' => $produccion[0]->name,
            'filmmaking' => $filmmaking,
        ];
       
    }
    return rest_ensure_response($data);
}


add_action('rest_api_init', function () {
    register_rest_route('miradanativa/v1/', '/catalog/(?P<lang>\w+)', array(
      'methods' => 'GET',
      'callback' => 'mn_get_catalog',
    ));

    register_rest_route('miradanativa/v1/', '/catalog', array(
      'methods' => 'GET',
      'callback' => 'mn_get_catalog',
    ));

});
