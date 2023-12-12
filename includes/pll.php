<?php
add_action('init', 'mn_register_pll_strings');
function mn_register_pll_strings()
{
    if (!function_exists('pll_register_string')) return;

    $ns = 'miradanativa';
    /* film */
    pll_register_string($ns, 'Película no disponible actualmente', $ns);
    pll_register_string($ns, 'Aportar', $ns);
    pll_register_string($ns, 'Sinopsis', $ns);
    pll_register_string($ns, 'Ficha artística y técnica', $ns);
    pll_register_string($ns, 'Año', $ns);
    pll_register_string($ns, 'Duración', $ns);
    pll_register_string($ns, 'Realización', $ns);
    pll_register_string($ns, 'Producción', $ns);
    pll_register_string($ns, 'Reparto', $ns);
    pll_register_string($ns, 'Premios', $ns);
    pll_register_string($ns, 'Pueblo', $ns);
    pll_register_string($ns, 'Zona Geográfica', $ns);
    pll_register_string($ns, 'Idioma', $ns);
    pll_register_string($ns, 'Subtítulos', $ns);
    pll_register_string($ns, 'Temática', $ns);
    pll_register_string($ns, 'Género(s)', $ns);
    pll_register_string($ns, 'Etiquetas', $ns);
    pll_register_string($ns, 'Enlaces de interés', $ns);
    pll_register_string($ns, 'Catálogo', $ns);
    pll_register_string($ns, 'No Disponible', $ns);

    /* festival */
    pll_register_string($ns, 'Películas', $ns);
    pll_register_string($ns, 'Sobre nosotros', $ns);
    pll_register_string($ns, 'Contacto', $ns);
    pll_register_string($ns, 'Descarga la programación', $ns);
    pll_register_string($ns, 'Más información en', $ns);
    pll_register_string($ns, 'Impulsan', $ns);
    pll_register_string($ns, 'Siguenos en las redes sociales', $ns);
    pll_register_string($ns, 'Con el soporte de', $ns);
    pll_register_string($ns, 'MiradaNativa no se hace responsable de los contenidos ni del tratamiento de los datos que se hagan desde los festivales alojados en esta plataforma. Toda la responsabilidad es del festival anfitrión. En caso de duda, pueden ponerse en contacto con nosotros.', $ns);
    pll_register_string($ns, 'Página web del festival', $ns);

    /* blog */
    pll_register_string($ns, 'TODO', $ns);
    pll_register_string($ns, 'RECOMENDACIONES', $ns);
    pll_register_string($ns, 'NOTICIAS', $ns);
    pll_register_string($ns, 'Ver película', $ns);
    pll_register_string($ns, 'Te puede interesar', $ns);
    pll_register_string($ns, 'noticias', $ns);
    pll_register_string($ns, 'Ver más publicaciones', $ns);
    pll_register_string($ns, 'all', $ns);
    pll_register_string($ns, 'resena', $ns);
    pll_register_string($ns, 'noticia', $ns);

    /* archive */
    pll_register_string($ns, 'No se ha encontrado contenido relacionado', $ns);
}
