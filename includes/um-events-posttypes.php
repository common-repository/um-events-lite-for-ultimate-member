<?php
add_action( 'init', 'um_events_register_post_type' );
function um_events_register_post_type() {
	$labels = array(
		'name'               => _x( 'Events', 'post type general name', 'um-events' ),
		'singular_name'      => _x( 'Event', 'post type singular name', 'um-events' ),
		'menu_name'          => _x( 'Events', 'admin menu', 'um-events' ),
		'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'um-events' ),
		'add_new'            => _x( 'Add New', 'event', 'um-events' ),
		'add_new_item'       => __( 'Add New Event', 'um-events' ),
		'new_item'           => __( 'New Event', 'um-events' ),
		'edit_item'          => __( 'Edit Event', 'um-events' ),
		'view_item'          => __( 'View Event', 'um-events' ),
		'all_items'          => __( 'All Events', 'um-events' ),
		'search_items'       => __( 'Search Events', 'um-events' ),
		'parent_item_colon'  => __( 'Parent Events:', 'um-events' ),
		'not_found'          => __( 'No events found.', 'um-events' ),
		'not_found_in_trash' => __( 'No events found in Trash.', 'um-events' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Events.', 'um-events' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array(
								'slug' => 'um_events',
							),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title','thumbnail','author' ),
	);

	register_post_type( um_events_post_type(), $args );
}

/*
*	um_events_metabox
*
*	Register Metabox
*/
function um_events_metabox() {
	add_meta_box(
		'um_events_meta',
		__( 'Event Details','um-events' ),
		'um_events_metabox_display',
		um_events()->post_type,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'um_events_metabox' );
/*
*	um_events_metabox_display
*
*	Metabox Display
*/
function um_events_metabox_display() {
	global $post;
	$post_id           = $post->ID;
	//print_r($post);
	$privacy           = get_post_meta( $post->ID, '_um_events_privacy', true );
	$um_events_profile = get_post_meta( $post->ID, '_um_events_profile', true );
	$event_start       = get_post_meta( $post_id, '_um_event_date_start', true );
	$event_end         = get_post_meta( $post_id, '_um_event_date_end', true );
	$event_time_start  = get_post_meta( $post_id, '_um_event_time_start', true );
	$event_time_end    = get_post_meta( $post_id, '_um_event_time_end', true );
	$event_description = get_post_meta( $post_id, '_um_event_description', true );
	$event_location    = get_post_meta( $post_id, '_um_event_location', true );
	?>
	<div class="um_events_meta_area">s
	<div class="um-event-form-field">
		<label><?php esc_html_e( 'Start Date','um-events' ); ?></label>
		<div class="um-event-date-options">
		<input type="text" name="event_date_start" id="event_date" class="um-event-date-input" value="<?php echo $event_start; ?>" />
		<input type="text" name="event_time_start" id="event_time" class="um-event-time"  value="<?php echo $event_time_start; ?>" />
		<a href="#" id="um-event-add-end" <?php echo $event_time_end || $event_end ? 'style="display: none;"' : ''; ?>><?php esc_html_e( '+ End Time','um-events' ); ?></a>
		</div>
	</div>
	<div class="um-event-form-field um-event-end-date" <?php echo ($event_time_end || $event_end ? 'style="display: block;"' : ''); ?>>
		<label><?php esc_html_e( 'End Date','um-events' ); ?></label>
		<div class="um-event-date-options">
		<input type="text" name="event_date_end" id="event_date" class="um-event-date-input" value="<?php echo $event_end; ?>" />
		<input type="text" name="event_time_end" id="event_time"  class="um-event-time" value="<?php echo $event_time_end; ?>" />
		<a href="#" id="um-event-remove-end"><?php esc_html_e( '- End Time','um-events' ); ?></a>
		</div>
	</div>
	<div class="um-event-form-field">
		<label><?php esc_html_e( 'Event Locaton','um-events' ); ?></label>
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
	<?php wp_nonce_field( 'um_events_meta_action', 'um_events_meta_nonce' ); ?>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.um-event-users').attr("multiple", "multiple");
		$(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
	});
	</script>
	<?php
}

add_action( 'save_post', 'um_events_meta_save', 1, 2 );

function um_events_meta_save( $post_id = 0, $post = array() ) {
	if ( ! isset( $_POST['um_events_meta_nonce'] )
		|| ! wp_verify_nonce( $_POST['um_events_meta_nonce'], 'um_events_meta_action' )
	) {
		return $post_id;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// call controller.
	$post_controller = new WP_Post_Controller( $post_id );

	//begin meta data saving.
	//privacy

	//update_post_meta($post_id, '_um_events_profile', sanitize_text_field($_POST['um_events_profile']));

	$metas = array(
			'_um_event_date_start'  => ! empty( $_POST['event_date_start'] ) ? sanitize_text_field( $_POST['event_date_start'] ) : '',
			'_um_event_time_start'  => ! empty( $_POST['event_time_start'] ) ? sanitize_text_field( $_POST['event_time_start'] ) : '',
			'_um_event_date_end'    => ! empty( $_POST['event_date_end'] ) ? sanitize_text_field( $_POST['event_date_end'] ) : '',
			'_um_event_time_end'    => ! empty( $_POST['event_time_end'] ) ? sanitize_text_field( $_POST['event_time_end'] ) : '',
			'_um_event_location'    => ! empty( $_POST['event_location'] ) ? esc_html( $_POST['event_location'] ) : '',
			'_um_event_description' => ! empty( $_POST['event_description'] ) ? esc_html( $_POST['event_description'] ) : '',
	);
	if ( ! empty( $metas ) ) {
		foreach ( $metas as $meta_key => $meta_value ) {
			if ( ! empty( $meta_value ) ) {
				update_post_meta( $post_id, $meta_key, $meta_value );
			} else {
				delete_post_meta( $post_id, $meta_key );
			}
		}
		if ( ! empty( $metas['_um_event_date_start'] ) && ! empty( $metas['_um_event_time_start'] ) ) {
			$start_time = $metas['_um_event_date_start'] . ' ' . $metas['_um_event_time_start'];
			$start_time = date( 'Y-m-d H:i:s', strtotime( $start_time ) );
			update_post_meta( $post_id, '_um_event_start', $start_time );
		}
		if ( ! empty( $metas['_um_event_date_end'] ) && ! empty( $metas['_um_event_time_end'] ) ) {
			$end_time = $metas['_um_event_date_end'] . ' ' . $metas['_um_event_time_end'];
			$end_time = date( 'Y-m-d H:i:s', strtotime( $end_time ) );
			update_post_meta( $post_id, '_um_event_end', $end_time );
		}
	}
}

//add_action( 'post_edit_form_tag' , 'um_events_post_edit_form_tag' );
function um_events_post_edit_form_tag() {
	echo ' enctype="multipart/form-data"';
}
