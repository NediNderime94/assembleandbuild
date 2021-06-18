<?php
/**
 * Display the release inside the shortcode loop
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
		<h2 class="entry-title release-title" itemprop="name">
			<a itemprop="url" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'lastudio-discography' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		<?php ld_release_buttons(); ?>
	</div><!-- .entry-thumbnail -->
</article><!-- article.lastudio-release -->