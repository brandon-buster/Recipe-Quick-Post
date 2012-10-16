<?php get_header(); ?>

	<div id="contentright">	

		<div class="postarea">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
			
			

            <h1><?php the_title(); ?></h1>

            <div class="postauthor">            
                <p><?php _e("Posted by", 'organicthemes'); ?> <?php the_author_posts_link(); ?> on <?php the_time('l, F j, Y'); ?> &middot; <a href="<?php the_permalink(); ?>#comments"><?php comments_number('Leave a Comment', '1 Comment', '% Comments'); ?></a>&nbsp;<?php edit_post_link('(Edit)', '', ''); ?></p>
            </div>
            
            <div id="recipe-meta">
            	
	            	<?php 
	            	if($ingredients = get_post_meta(get_the_ID(), 'ingredients', true)) {
	            		echo '<table>';
	            		echo '<tr colspan="2"><h4>Ingedients:</h4></tr>';
	            		foreach($ingredients as $ingredient => $qty) {
	            			?>
	            			<tr>
	            				<td><?php echo "$qty: "; ?></td>
	            				<td><?php echo " &nbsp; $ingredient"; ?></td>
	            			</tr>
	            			<?php 
	            		}
	            		echo '</table>';
	            	}
	            	echo '<p>';
	            	if($servings = get_post_meta(get_the_ID(), 'serving_size', true)) {
	            		echo '<strong>Serves:</strong> ' . $servings;
	            	}
	            	
	            	if($prep = get_post_meta(get_the_ID(), 'prep_time', true)) {
	            		echo '<br /><strong>Prep Time:</strong> ' . $prep;
	            	}
	            	
	            	if($bake = get_post_meta(get_the_ID(), 'bake_time', true)) {
	            		echo '<br /><strong>Bake Time:</strong> ' . $bake;
	            	}
	            	echo '</p>';
	            	?>
	            
	            
	            <?php echo get_the_term_list(get_the_ID(), 'course_type', '<ul><strong>Course Type:</strong> <li>', '</li><li>', '</li></ul>'); ?>
	            <?php echo get_the_term_list(get_the_ID(), 'cuisine', '<ul><strong>Cuisine:</strong> <li>', '</li><li>', '</li></ul>');  ?> 
	            <?php echo get_the_term_list(get_the_ID(), 'ingredients', '<ul><strong>Ingredients:</strong> <li>', '</li><li>', '</li></ul>');  ?>
            </div>

			<?php the_content();?>
            <div style="clear:both;"></div>
			<?php trackback_rdf(); ?>

			<div class="postmeta">
				<p><?php _e("Filed under", 'organicthemes'); ?> <?php the_category(', ') ?> &middot; <?php _e("Tagged with", 'organicthemes'); ?> <?php the_tags('') ?></p>
			</div>

            <div class="postcomments">
                <?php comments_template('',true); ?>
            </div>
    
            <?php endwhile; else: ?>
            <p><?php _e("Sorry, no posts matched your criteria.", 'organicthemes'); ?></p>
            <?php endif; ?>
        
        </div>

	</div>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>
