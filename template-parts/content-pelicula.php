<?php

/**
 * Displays the content when the post type is 'pelicula'
 *
 * Used for index
 * 
 * @package WordPress
 * @subpackage MiradaNativa
 */
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div class="post-inner <?php echo is_page_template('templates/template-full-width.php') ? '' : 'thin'; ?> ">
        <div class="entry-content">
            <?php echo pods('pelicula', get_the_id())->template('Search Película');  ?>
        </div><!-- .entry-content -->
    </div><!-- .post-inner -->
</article>
