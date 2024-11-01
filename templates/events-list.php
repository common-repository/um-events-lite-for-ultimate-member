<?php if ( ! um_events_restrict_uploads() ) : ?>
<a href="#um-event-modal" class="um-event-form"><?php _e( 'Add Event', 'um-events' ); ?></a>
<?php endif; ?>
<div class="um-events-list-wrapper">
	<ul class="um-events-list" id="um-events-list">
		<?php
		if ( $events->have_posts() ) :
		?>
		<?php while ( $events->have_posts() ) : $events->the_post(); ?>
			<?php 
			$event_id          = get_the_ID();
			$template_args = array(
				'id'                => $event_id,
				'post_id'           => $event_id,
				'event_id'          => $event_id,
				'event_title'       => $event_id ? get_the_title( $event_id ) : '',
				'event_start'       => get_post_meta( $event_id, '_um_event_date_start', true ),
				'event_end'         => get_post_meta( $event_id, '_um_event_date_end', true ),
				'event_time_start'  => get_post_meta( $event_id, '_um_event_time_start', true ),
				'event_time_end'    => get_post_meta( $event_id, '_um_event_time_end', true ),
				'event_description' => get_post_meta( $event_id, '_um_event_description', true ),
				'event_location'    => get_post_meta( $event_id, '_um_event_location', true ),
				'event_ticket_url'  => get_post_meta( $event_id, '_um_event_ticket_url', true ),
			);
			?>
			<?php get_um_events_template( 'event-list-item.php', $template_args ); ?>
		<?php endwhile; ?>

		<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No events found.','um-events' ); ?></p>
		<?php endif; ?>
	</ul>
</div>