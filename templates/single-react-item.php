<?php
get_header();
echo '<h1>This is single file post file.</h1>';
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                ?>
                <h1><?php the_title(); ?></h1>
                <div><?php the_content(); ?></div>
                <?php
            endwhile;
        else :
            echo '<p>No content found</p>';
        endif;
        ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
