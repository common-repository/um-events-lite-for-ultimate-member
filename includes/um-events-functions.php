<?php
/**
 * Returns the Post Type.
 * 
 * @return string
 */
function um_events_post_type() {
	return apply_filters( 'um_events_post_type', 'um_events' );
}

function um_events_restrict_uploads() {
	// Restrict event adding if user is a guest.
	if ( ! is_user_logged_in() ) {
		return true;
	}

	// Check if user is on their own profile.
	if ( um_is_user_himself() ) {
		// Check if the options allow adding event.
		$allow_event_add = get_option( 'um_events_allow_upload' );
		if ( $allow_event_add || empty( $allow_event_add ) ) {
			return false;
		}
	}
	return true;
}

function um_get_events_profile_link( $user_id = 0 ) {
	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	$url = um_user_profile_url( $user_id );
	$url = remove_query_arg( 'profiletab', $url );
	$url = remove_query_arg( 'subnav', $url );
	$url = add_query_arg( 'profiletab', 'events', $url );
	return $url;
}
/**
 * [um_get_document_edit_link description]
 * @param  string $id [description]
 *
 * @since  1.0.5
 * 
 * @return [type]     [description]
 */
function um_get_events_edit_link( $id = '' ) {
	$url = um_user_profile_url();
	$url = remove_query_arg( 'profiletab', $url );
	$url = remove_query_arg( 'subnav', $url );
	$url = add_query_arg( 'profiletab', 'events', $url );
	$url = add_query_arg( 'event_action',  'edit_event', $url );
	if ( $id ) {
		$url = add_query_arg( 'id',  $id, $url );
	}
	return $url;
}

/**
 * [um_get_document_edit_link description]
 * @param  string $id [description]
 *
 * @since  1.0.5
 * 
 * @return [type]     [description]
 */
function um_get_events_view_link( $view = 'upcoming' ) {
	$url = um_user_profile_url();
	$url = remove_query_arg( 'profiletab', $url );
	$url = remove_query_arg( 'subnav', $url );
	$url = remove_query_arg( 'v', $url );
	$url = add_query_arg( 'profiletab', 'events', $url );
	$url = add_query_arg( 'v',  $view, $url );
	return $url;
}

function um_events_allow_tickets() {
	return (bool) get_option( 'um_events_form_tickets' );
}

function um_events_show_image() {
	return (bool) get_option( 'um_events_show_image', 1 );
}
function um_events_allow_description() {
	return (bool) get_option( 'um_events_form_description' );
}

function um_events_insert( $events_data = array() ) {
	$user_id = get_current_user_id();
	$defaults = array(
		'post_type' => um_events()->post_type,
		'post_author'   => $user_id,
		'post_status' => 'publish',
	);
	$results = array();
	$id = 0;
	$args = wp_parse_args( $events_data, $defaults );

	$message = '';
	if ( empty( $args['ID'] ) ) {
		$id      = wp_insert_post( $args );
		$message = __( 'Your event has been added. Click <a href="#" class="um-event-link" data-eventid="' . $id . '">here</a> to view it.','um-events' );
		//$message = sprintf($message, get_permalink($id) );
		$results['message'] = apply_filters( 'um_event_message_added', $message );
		do_action( 'um_after_event_added', $id, $args );
	} else {
		$args['ID'] = $events_data['ID'];
		$id         = wp_update_post( $args );
		$message    = __( 'Your event has been updated. Click <a href="#" class="um-event-link"  data-eventid="' . $id . '">here</a> to view it.','um-events' );
		//$message = sprintf($message, get_permalink($id) );
		$results['message'] = apply_filters( 'um_event_message_updated', $message );
		do_action( 'um_after_event_updated', $id, $args );
	}

	if ( ! is_wp_error( $id ) ) {
		$results['id'] = $id;
		$file          = um_event_upload_media( 'files', $id );
		if ( ! empty( $file ) ) {
			update_post_meta( $id, '_thumbnail_id', $file[0] );
		}
		$results['redirect_to'] = um_get_events_profile_link();
		do_action( 'um_after_event_saved', $id, $args );
	} else {
		$results['error_message'] = $id->get_error_message();
	}

	return $results;
}

function um_event_save_meta( $id = 0, $args = array() ) {
	if ( ! empty( $args['meta'] ) ) {
		foreach ( $args['meta'] as $meta_key => $meta_value ) {
			if ( ! empty( $meta_value ) ) {
				update_post_meta( $id, $meta_key, $meta_value );
			} else {
				delete_post_meta( $id, $meta_key );
			}
		}
		if ( ! empty( $args['_um_event_date_start'] ) && ! empty( $args['_um_event_time_start'] ) ) {
			$start_time = $args['_um_event_date_start'] . ' ' . $args['_um_event_time_start'];
			$start_time = date( 'Y-m-d H:i:s', strtotime( $start_time ) );
			update_post_meta( $id, '_um_event_start', $start_time );
		}
		if ( ! empty( $args['_um_event_date_end'] ) && ! empty( $args['_um_event_time_end'] ) ) {
			$end_time = $args['_um_event_date_end'] . ' ' . $args['_um_event_time_end'];
			$end_time = date( 'Y-m-d H:i:s', strtotime( $end_time ) );
			update_post_meta( $id, '_um_event_end', $end_time );
		}
	}
	do_action( 'um_event_after_meta_update', $id, $args );
}
add_action( 'um_after_event_saved', 'um_event_save_meta', 1, 2 );


function um_events_get_all( $args = array() ) {
	$defaults = array(
		'post_type' 	=> um_events()->post_type,
		'post_status' 	=> 'publish',
		'order'   		=> 'ASC',
		'orderby'   	=> '_um_event_date_start',
		'meta_key'  	=> '_um_event_date_start',
		'paged'         => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
	);
	$args = wp_parse_args( $args, $defaults );
	$custom_posts = new WP_Query( $args );
	$custom_posts->query( $args );
	return $custom_posts;
}

function um_events_user_events( $user_id = 0, $args = array() ) {
	$defaults = array(
		'post_type' 	=> um_events()->post_type,
		'post_status' 	=> 'publish',
		'author' 		=> $user_id,
		'order'   		=> 'DESC',
		'meta_key'  	=> '_um_event_date_start',
	);
	$args = wp_parse_args( $args, $defaults );
	if ( um_events_restrict_uploads() ) :
		if ( ! empty( $args['author'] ) ) {
			unset( $args['author'] );
		}
		$args['meta_query'][] = array(
			'key'     => '_um_events_pinned',
			'value'   => 1,
			'compare' => '=',
		);
	endif;
	$custom_posts = new WP_Query();
	$custom_posts->query( $args );
	return $custom_posts;
}
function um_events_is_owner() {
	global $post;
	$user_id = $post->post_author;
	$my_id = get_current_user_id();
	if ( $user_id && $user_id == $my_id ) :
		return true;
	else :
		return false;
	endif;
}
function um_events_can_edit() {
	if( um_events_restrict_uploads() ) {
		return false;
	}
	if ( um_events_is_owner() ) {
		return true;
	}
	return false;
}

function um_event_calendar_feed_url( $user_id = array() ){
	return site_url( '/?um_event_calendar=1' );
}

function um_event_build_calendar_data() {
	if ( isset( $_GET['um_event_calendar'] ) ) :
		global $wpdb;
		

		$start = ! empty( $_GET['start'] ) ? esc_attr( $_GET['start'] ) : '';
		$end   = ! empty( $_GET['end'] ) ? esc_attr( $_GET['end'] ) : '';
		
		$events = $wpdb->get_col( "SELECT p.ID FROM {$wpdb->posts} AS p LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID=pm.post_id WHERE pm.meta_key='_um_event_date_start' AND p.post_status='publish' AND CAST(pm.meta_value AS DATE) BETWEEN '{$start}' AND '{$end}' ");
		if ( ! empty( $events ) ) {
			foreach ($events as $event_id ) {
				$post_id           = $event_id;
				$event_start       = get_post_meta( $post_id, '_um_event_date_start', true );
				$event_end         = get_post_meta( $post_id, '_um_event_date_end', true );
				$event_time_start  = get_post_meta( $post_id, '_um_event_time_start', true );
				$event_time_end    = get_post_meta( $post_id, '_um_event_time_end', true );
				$response[] = array(
					'id'    => $post_id,
					'title' => get_the_title(),
					'start' => $event_start ? date( 'Y-m-d H:i:s', strtotime( $event_start ) ) : '',
					'end'   => $event_end ? date( 'Y-m-d H:i:s', strtotime( $event_end ) ) : ''
				);

			}
		}

				
		echo trim( json_encode( $response ) ); 
		exit;
	endif;
}

add_action( 'init', 'um_event_build_calendar_data' );

/*
 *	Upload files to Media folder
 */
function um_event_upload_media( $files_key = '', $id = 0, $insert_attachment = true, $overwrite = true ) {
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );
	if ( empty( $files_key ) ) {
		return false;
	}
	if ( empty( $_FILES[ $files_key ] ) ) {
		return false;
	}
	$result = array();
	$upload_overrides = array(
		'test_form' => false,
	);
	$attachment_id = media_handle_upload( $files_key, $id );
	if ( ! is_wp_error( $attachment_id ) ) {
		if ( $insert_attachment ) {
			if ( $overwrite ) {
				//$this->delete_post_media( $this->id );
			}
		}
		$result[] = $attachment_id;
	} else {
		$error_string = $attachment_id->get_error_message();
	}
	return $result;
}

function um_event_delete_post_media( $post_id ) {

	$attachments = get_posts( array(
			'post_type'      => 'attachment',
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'post_parent'    => $post_id,
		)
	);

	foreach ( $attachments as $attachment ) {
		if ( false === wp_delete_attachment( $attachment->ID ) ) {
			// Log failure to delete attachment.
		}
	}
}

function um_event_get_featured_image( $event_id ) {
	$image = array();
	$post_thumbnail_id = get_post_thumbnail_id( $event_id );
	if ( $post_thumbnail_id ) {
		$image = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
	}
	return $image;
}
