<?php
/**
 * Template to render the event in the event list.
 *
 * @author LaStudio
 * @category Core
 * @package LaStudioEvents/Admin
 * @version 1.0.0
 */
?>
<div class="<?php echo esc_attr( $classes );  ?>" itemscope itemtype="http://schema.org/Event">
	<?php
		/**
		 * le_event_list_item_start hook
		 */
		do_action( 'le_event_list_item_start' );
	?>
	<meta itemprop="name" content="<?php echo esc_attr( $name ); ?>">
	<meta itemprop="url" content="<?php echo esc_url( $permalink ); ?>">
	<?php if ( $thumbnail_url ) : ?>
		<meta itemprop="image" content="<?php echo esc_url( $thumbnail_url ); ?>">
	<?php endif; ?>
	<meta itemprop="description" content="<?php echo esc_attr( $description ); ?>">
	<div class="le-table-cell le-date" itemprop="startDate" content="<?php echo esc_attr( $raw_start_date ); ?>">
		<?php if ( $formatted_start_date ) : ?>
			<?php echo le_sanitize_date( $formatted_start_date ); ?>
		<?php endif; ?>
	</div><!-- .le-date -->
	<div class="le-table-cell le-location" itemprop="location" itemscope itemtype="http://schema.org/Place">
		<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
			<?php if ( $city ) : ?>
				<meta itemprop="addressLocality" content="<?php echo esc_attr( $city ); ?>">
			<?php endif; ?>

			<?php if ( $address ) : ?>
				<meta itemprop="streetAddress" content="<?php echo esc_attr( $address ); ?>">
			<?php endif; ?>

			<?php if ( $state ) : ?>
				<meta itemprop="addressRegion" content="<?php echo esc_attr( $state ); ?>">
			<?php endif; ?>

			<?php if ( $zipcode ) : ?>
				<meta itemprop="postalCode" content="<?php echo esc_attr( $zipcode ); ?>">
			<?php endif; ?>
		</span>

		<?php if ( $link ) : ?>
			<a rel="bookmark" class="entry-link" href="<?php the_permalink(); ?>">
		<?php endif; ?>
			<span itemprop="name" class="le-venue"><?php echo sanitize_text_field( $venue ); ?></span>

			<span class="le-display-location"><?php echo sanitize_text_field( $display_location ); ?></span>

		<?php if ( $link ) : ?>
			</a>
		<?php endif; ?>
	</div><!-- .le-location -->
	<div class="le-table-cell le-action">
		<?php if ( $action ) : ?>
			<?php echo le_sanitize_action( $action ); ?>
		<?php endif; ?>
	</div><!-- .le-action -->
	<?php
		/**
		 * le_event_list_item_end hook
		 */
		do_action( 'le_event_list_item_end' );
	?>
</div><!-- .le-list-event -->
