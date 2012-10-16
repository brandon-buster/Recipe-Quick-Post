<?php
/*
Template Name: Recipes Page
*/
?>

<?php get_header(); ?>

	<div id="contentrecipes">
	
		<div class="postarea">
			
			<?php $wp_query = new WP_Query(array('post_type'=>'recipes','showposts'=>10,'paged'=>$paged)); ?>
			<?php if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); ?>
            <?php global $more; $more = 0; ?>
            
            <div class="recipes">
            
            	<div class="recipesimg">
                    <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'recipe' ); ?></a>
                </div>
                
           		<div id="recipestitle">              
                    <h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                </div>
            
            	<div class="recipesexcerpt">
                    <?php the_excerpt(); ?>
                </div>
                            
            </div>
							
			<?php endwhile; ?>
            
            <div style="clear: both"></div>
            
            <div id="portfolio_nav">
                <div id="prevLink"><p><?php previous_posts_link(); ?></p></div>
                <div id="nextLink"><p><?php next_posts_link(); ?></p></div>
            </div>
            
            <?php else : // do not delete ?>

            <h3><?php _e("Page not Found"); ?></h3>
            <p><?php _e("We're sorry, but the page you're looking for isn't here."); ?></p>

			<?php endif; // do not delete ?>
		
		</div>
		
	</div>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>