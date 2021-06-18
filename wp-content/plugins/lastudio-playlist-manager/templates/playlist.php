<?php
/**
 * Template to render the player and playlist.
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioPlaylistManager/Admin
 * @version 1.0.0
 */
?>
<div class="<?php echo esc_attr( $classes ); ?>" id="lpm-playlist-<?php echo absint( $args['post_id'] ); ?>" itemscope itemtype="http://schema.org/MusicPlaylist">

	<?php do_action( 'lpm_playlist_top', $post_id, $tracks, $args ); ?>

	<meta itemprop="numTracks" content="<?php echo count( $tracks ); ?>">

	<audio src="<?php echo esc_url( $tracks[0]['audioUrl'] ); ?>" controls preload="none" class="lpm-audio" style="width: 100%; height: auto"></audio>

	<ol class="lpm-tracks">
		<?php foreach ( $tracks as $track ) : ?>
			<li class="lpm-track" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">
				<?php do_action( 'lpm_playlist_track_top', $track, $post_id, $args ); ?>

				<span class="lpm-track-details lpm-track-cell">
					<span class="lpm-track-text">
						<span class="lpm-track-title" itemprop="name"><?php echo esc_html( $track['title'] ); ?></span>
						<span class="lpm-track-artist" itemprop="byArtist"><?php echo esc_html( $track['artist'] ); ?></span>
					</span>
				</span>

				<span class="lpm-track-links lpm-track-cell">
					<span class="lpm-track-buy-links">
						<?php if ( $track['itunesUrl'] ) : ?>
							<a title="<?php esc_html_e( 'Buy on iTunes', 'lastudio-playlist-manager' ); ?>" class="lpm-track-itunes lpm-track-icon lpm-icon-itunes" href="<?php echo esc_url( $track['itunesUrl'] ); ?>" target="_blank"></a>
						<?php endif; ?>
						<?php if ( $track['amazonUrl'] ) : ?>
							<a title="<?php esc_html_e( 'Buy on amazon', 'lastudio-playlist-manager' ); ?>" class="lpm-track-amazon lpm-track-icon lpm-icon-amazon" href="<?php echo esc_url( $track['amazonUrl'] ); ?>" target="_blank"></a>
						<?php endif; ?>
						<?php if ( $track['googleplayUrl'] ) : ?>
							<a title="<?php esc_html_e( 'Buy on Google Play', 'lastudio-playlist-manager' ); ?>" class="lpm-track-googleplay lpm-track-icon lpm-icon-googleplay" href="<?php echo esc_url( $track['googleplayUrl'] ); ?>" target="_blank"></a>
						<?php endif; ?>
						<?php if ( $track['buyUrl'] ) : ?>
							<a title="<?php esc_html_e( 'Buy now', 'lastudio-playlist-manager' ); ?>" class="lpm-track-buy lpm-track-icon lpm-icon-cart" href="<?php echo esc_url( $track['buyUrl'] ); ?>" target="_blank"></a>
						<?php endif; ?>

						<?php if ( $track['wcProductId'] && class_exists( 'WooCommerce' ) ) {

							$product_id = absint( $track['wcProductId'] );
							echo lpm_add_to_cart( $product_id, 'lpm-add-to-cart-button lpm-track-icon', '<span class="lpm-add-to-cart-button-title" title="' . esc_html__( 'Add to cart', 'lastudio-playlist-manager' ) . '"></span><i class="lpm-icon-add-to-cart"></i>' ); ?>
						<?php } ?>
					</span>
				</span>

				<?php do_action( 'lpm_playlist_track_details_after', $track, $post_id, $args ); ?>

				<span class="lpm-track-length lpm-track-cell"><?php echo esc_html( $track['length'] ); ?></span>

				<?php do_action( 'lpm_playlist_track_bottom', $track, $post_id, $args ); ?>
			</li>
		<?php endforeach; ?>
	</ol>

	<?php do_action( 'lpm_playlist_bottom', $post_id, $tracks, $args ); ?>
</div>