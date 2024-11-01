<h3><?php echo $form_title; ?></h3>
<form id="um_event_form" enctype="multipart/form-data">
	<div class="um-event-form-message"></div>
	<div class="um-event-form-section">
	<div class="um-event-form-field">
		<label><?php esc_html_e( 'Event Title','um-events' ); ?></label>
		<input type="text" name="event_title" id="event_title" value="<?php echo esc_attr( $event_title ); ?>" />
	</div>
	<?php if ( um_events_show_image() ) : ?>
	<div class="um-event-form-section" align="center">
		<div class="um-event-image-bg" <?php echo $bg_url; ?>>
			<input class="event__file" type="file" name="files" id="file"  />
			<label for="file">
			<i class="fa fa-upload" aria-hidden="true"></i>
			<?php esc_html_e( 'Add Event Photo','um-events' ); ?>
			</label>
		</div>
	</div>
	<?php endif; ?>
	<div class="um-event-date-time-fields">
		<div class="um-event-form-field">
			<label><?php esc_html_e( 'Start Date','um-events' ); ?></label>
			<div class="um-event-date-options">
			<input type="text" name="event_date_start" id="um_event_date_start" class="um-event-date-input" value="<?php echo esc_attr( $event_start ); ?>" />
			<input type="text" name="event_time_start" id="event_time" class="um-event-time"  value="<?php echo esc_attr( $event_time_start ); ?>" />
			<!--<a href="#" id="um-event-add-end"><?php esc_html_e( '+ End Time','um-events' ); ?></a>-->
			</div>
		</div>
		<div class="um-event-form-field um-event-end-date">
			<label><?php esc_html_e( 'End Date','um-events' ); ?></label>
			<div class="um-event-date-options">
			<input type="text" name="event_date_end" id="um_event_date_end" class="um-event-date-input" value="<?php echo esc_attr( $event_end ); ?>" />
			<input type="text" name="event_time_end" id="event_time"  class="um-event-time" value="<?php echo esc_attr( $event_time_end ); ?>" />
			<!-- <a href="#" id="um-event-remove-end"><?php esc_html_e( '- End Time','um-events' ); ?></a> -->
			</div>
		</div>
	</div>

	<div class="um-event-form-section" id="um-event-invites">
		<h3><?php echo esc_html__( 'Event Details', 'um-events' ); ?></h3>
		<div class="um-event-form-field">
			<label><?php esc_html_e( 'Event Locaton', 'um-events' ); ?></label>
			<textarea name="event_location" id="event_location"><?php echo wp_kses_post( $event_location ); ?></textarea>
		</div>
		</div>
		<div class="um-event-form-section">
			<?php if ( um_events_allow_description() ) : ?>
			 <div class="um-event-form-field">
				<label><?php esc_html_e( 'Description','um-events' ); ?></label>
				<textarea name="event_description" id="event_description"><?php echo wp_kses_post( $event_description ); ?></textarea>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="um-event-form-field">
		<input type="submit" name="submit_event" id="submit_event" value="<?php esc_attr_e( 'Submit Event','um-events' ); ?>" />
	</div>
	<input type="hidden" name="event_id" id="um_event_id" value="<?php echo absint( $id ); ?>" />
</form>