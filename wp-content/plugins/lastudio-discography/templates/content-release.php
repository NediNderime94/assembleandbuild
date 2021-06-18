<?php
/**
 * Display the release inside the loop
 *
 * @author LaStudio
 * @package LaStudioDiscography/Templates
 * @version 1.0.0
 * @since 1.0.2
 */
?>
<article itemscope itemtype="http://schema.org/MusicAlbum" id="post-<?php the_ID(); ?>" <?php post_class( array( 'lastudio-release', 'clearfix' ) ); ?>>
	<?php 
		/**
		 * lastudio_release_start_hook
		 */
		do_action( 'lastudio_release_start' );
	?>
	<div class="entry-thumbnail release-thumbnail">
		<?php ld_release_thumbnail(); ?>
	</div><!-- .entry-thumbnail -->
	
	<div class="entry-content release-content">
		<h2 class="entry-title release-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'lastudio-discography' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		<div class="lastudio-release-meta">
			<?php ld_release_meta(); ?>
		</div>
		<?php
			/**
			 * Content with read more button
			 */
			global $more;
			$more = 0;
			the_content( __( 'View Details', 'lastudio-discography' ) );
		?>
	</div><!-- .entry-content -->
	<div class="clear"></div>
</article><!-- article.lastudio-release -->