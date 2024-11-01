<?php
/**
 * Gets and includes template files.
 *
 * @since 1.0.0
 * @param mixed  $template_name
 * @param array  $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 */
function get_um_events_template( $template_name, $args = array(), $template_path = 'um_events', $default_path = '' ) {
	if ( $args && is_array( $args ) ) {
		extract( $args );
	}
	include( locate_um_events_template( $template_name, $template_path, $default_path ) );
}

/**
 * Locates a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @since 1.0.0
 * @param string      $template_name
 * @param string      $template_path (default: 'um_events')
 * @param string|bool $default_path (default: '') False to not load a default
 * @return string
 */
function locate_um_events_template( $template_name, $template_path = 'um_events', $default_path = '' ) {
	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template && $default_path !== false ) {
		$default_path = $default_path ? $default_path : UM_EVENTS_PATH . 'templates/';
		if ( file_exists( trailingslashit( $default_path ) . $template_name ) ) {
			$template = trailingslashit( $default_path ) . $template_name;
		}
	}
	// Return what we found
	return apply_filters( 'um_events_locate_template', $template, $template_name, $template_path );
}

/**
 * Get the current view on the page.
 * 
 * @return [type] [description]
 */
function um_events_current_view() {
	if ( ! isset( $_GET['v'] ) ) {
		return 'upcoming';
	}

	$view = 'upcoming';
	switch( $_GET['v'] ) {
		case 'upcoming':
			$view = 'upcoming';
		break;
		case 'past':
			$view = 'past';
		break;
		case 'invites':
			$view = 'invites';
		break;
	}

	return $view;
}
