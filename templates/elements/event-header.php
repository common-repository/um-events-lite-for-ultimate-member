<div class="um-events-header-wrapper">
	<div class="um-events-pull-left" id="um-events-list-options-wrapper">
		<ul class="um-events-list-options" id="um-events-list-options">
			<li><a href="<?php echo um_get_events_view_link( 'upcoming' ); ?>" class="<?php echo 'upcoming' == $view ? 'um-event-active-item' : ''; ?>" ><?php _e( 'Upcoming', 'um-events' ); ?></a></li>
			<li><a href="<?php echo um_get_events_view_link( 'past' ); ?>" class="<?php echo 'past' == $view ? 'um-event-active-item' : ''; ?>"><?php _e( 'Past', 'um-events' ); ?></a></li>
		</ul>
	</div>
	<div class="um-events-pull-right" id="um-events-list-actions">
		<?php if ( ! um_events_restrict_uploads() ) : ?>
			<a href="<?php echo um_get_events_edit_link(); ?>" class="um-event-form-link"><?php _e( '+ Add Event', 'um-events' ); ?></a>
		<?php endif; ?>
	</div>
</div>