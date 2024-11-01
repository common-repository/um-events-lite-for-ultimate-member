<?php
class UM_Events_Ajax {
	public function __construct() {
		$this->hooks();
	}

	public function hooks() {
		add_action( 'wp_ajax_um_events_save', array( $this, 'um_events_save_ajax' ) );
		add_action( 'wp_ajax_um_event_get_form', array( $this, 'um_event_get_form' ) );
		add_action( 'wp_ajax_um_event_get_view', array( $this, 'um_event_get_view' ) );
		add_action( 'wp_ajax_nopriv_um_event_get_view', array( $this, 'um_event_get_view' ) );
		add_action( 'wp_ajax_um_event_delete', array( $this, 'um_event_delete' ) );
	}

	public function um_events_save_ajax() {
		$result = array();
		$error  = false;
		if ( empty( $_POST['event_title'] ) ) {
			$result['error_message'][] = __( 'Event name missing.','um-events' );
		}
		if ( empty( $_POST['event_date_start'] ) ) {
			$result['error_message'][] = __( 'Event start date missing.','um-events' );
		}
		if ( empty( $_POST['event_time_start'] ) ) {
			$result['error_message'][] = __( 'Event start time missing.','um-events' );
		}
		if ( ! empty( $result['error_message'] ) ) {
			$result['error_message'] = implode( "<br />", $result['error_message'] );
			wp_send_json($result);
		}
		$user_id = get_current_user_id();

		$event_data = array (
			'ID'           => ! empty($_POST['event_id']) ? absint( $_POST['event_id'] ) : '',
			'post_title'   => ! empty( $_POST['event_title'] ) ? sanitize_text_field( $_POST['event_title'] ) : '',
			'post_type'    => um_events()->post_type,
			'post_author'  => $user_id,
			'post_status'  => 'publish',
			'meta'         => array(
				'_um_event_date_start'  => ! empty( $_POST['event_date_start'] ) ? sanitize_text_field( $_POST['event_date_start'] ) : '',
				'_um_event_time_start'  => ! empty( $_POST['event_time_start'] ) ? sanitize_text_field( $_POST['event_time_start'] ) : '',
				'_um_event_date_end'    => ! empty( $_POST['event_date_end'] ) ? sanitize_text_field( $_POST['event_date_end'] ) : '',
				'_um_event_time_end'    => ! empty( $_POST['event_time_end'] ) ? sanitize_text_field( $_POST['event_time_end'] ) : '',
				'_um_event_location'    => ! empty( $_POST['event_location'] ) ? esc_html( $_POST['event_location'] ) : '',
				'_um_event_description' => ! empty( $_POST['event_description'] ) ? esc_html( $_POST['event_description'] ) : '',
			)
		);
		$event_data = apply_filters( 'um_events_save_data', $event_data );
		$result     = um_events_insert( $event_data );
		wp_send_json( $result );
	}

	public function um_event_get_form() {
		$id                = isset( $_GET ) && isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
		$post_id           = $id;
		$event_title       = $id ? get_the_title( $id ) : '';
		$event_start       = get_post_meta( $post_id, '_um_event_date_start', true );
		$event_end         = get_post_meta( $post_id, '_um_event_date_end', true );
		$event_time_start  = get_post_meta( $post_id, '_um_event_time_start', true );
		$event_time_end    = get_post_meta( $post_id, '_um_event_time_end', true );
		$event_description = get_post_meta( $post_id, '_um_event_description', true );
		$event_location    = get_post_meta( $post_id, '_um_event_location', true );
		$event_ticket_url  = get_post_meta( $post_id, '_um_event_ticket_url', true );
		if ( ! $id ) {
			$form_title = __( 'Create Event', 'um-events' );
		} else {
			$form_title = __( 'Update Event', 'um-events' );
		}
		$bg_url = '';
		$image  = um_event_get_featured_image( $id );
		if ( $image ) {
			$bg_url = ' style="background-image: url(' . $image[0] . ')"';
		}
		?>
		<div class="um-event-header"><?php echo $form_title; ?></div>
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
			<div class="um-event-form-field">
				<label><?php esc_html_e( 'Start Date','um-events' ); ?></label>
				<div class="um-event-date-options">
				<input type="text" name="event_date_start" id="event_date" class="um-event-date-input" value="<?php echo $event_start; ?>" />
				<input type="text" name="event_time_start" id="event_time" class="um-event-time"  value="<?php echo $event_time_start; ?>" />
				<a href="#" id="um-event-add-end"><?php esc_html_e( '+ End Time','um-events' ); ?></a>
				</div>
			</div>
			<div class="um-event-form-field um-event-end-date">
				<label><?php esc_html_e( 'End Date','um-events' ); ?></label>
				<div class="um-event-date-options">
				<input type="text" name="event_date_end" id="event_date" class="um-event-date-input" value="<?php echo $event_end; ?>" />
				<input type="text" name="event_time_end" id="event_time"  class="um-event-time" value="<?php echo $event_time_end; ?>" />
				<a href="#" id="um-event-remove-end"><?php esc_html_e( '- End Time','um-events' ); ?></a>
				</div>
			</div>
			<div class="um-event-form-field">
				<label><?php esc_html_e( 'Event Locaton', 'um-events' ); ?></label>
				<textarea name="event_location" id="event_location"><?php echo $event_location; ?></textarea>
			</div>
			</div>
			<div class="um-event-form-section">
				<?php if ( um_events_allow_description() ) : ?>
				 <div class="um-event-form-field">
					<label><?php esc_html_e( 'Description','um-events' ); ?></label>
					<textarea name="event_description" id="event_description"><?php echo $event_description; ?></textarea>
				</div>
				<?php endif; ?>
			</div>
			<div class="um-event-form-field">
				<input type="submit" name="submit_event" id="submit_event" value="<?php esc_html_e( 'Submit Event','um-events' ); ?>" />
			</div>
			<input type="hidden" name="event_id" id="um_event_id" value="<?php echo absint( $id ); ?>" />
			</form>
		<?php
		exit;
	}

	public function um_event_get_view() {
		global $event_id;
		$event_id = $post_id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : '';
		if ( ! $event_id ) {
			exit;
		}
		um_events()->load_template( 'event-view' );
		exit;
	}

	public function um_event_delete() {
		check_ajax_referer( 'um-event-nonce', 'security' );
		$event_id = $_POST['id'];
		$result = array();
		$result['success'] = false;
		if ( wp_delete_post( $event_id, true ) ) {
			$result['success'] = true;
			do_action( 'um_event_deleted', $event_id );
		}
		wp_send_json( $result );
	}
}
