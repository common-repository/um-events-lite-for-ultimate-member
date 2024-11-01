<?php
class UM_Events_Shortcodes {

	/**
	 * __constructor.
	 *
	 * @since  1.0.4
	 *
	 * @return string
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Hooks.
	 *
	 * @since  1.0.4
	 *
	 * @return string
	 */
	public function hooks() {
		$shortcodes = array(
			'um_events_list',
		);
		foreach ( $shortcodes as $shortcode ) {
			add_shortcode( $shortcode, array( $this, $shortcode . '_handler' ) );
		}
	}

	/**
	 * List shortcode.
	 *
	 * @since  1.0.4
	 *
	 * @return string
	 */
	public function um_events_list_handler( $atts ) {
		ob_start();
		extract( $atts = shortcode_atts( array(
			'user_id'         => null,
			'limit'           => 10,
			'upcoming'        => true,
			'excluded_users'  => null,
			'id'              => null,
			'hide'            => null,

			// layout options
			'show_location'   => true,
			'show_add_button' => null,
		), $atts ) );

		$wp_query_args = array();

		// query by IDs.
		$ids = ! empty( $id ) ?  array_map( 'trim', explode( ',', $id ) ) : null;
		if ( ! empty( $ids ) ) {
			if ( 1 === count( $ids ) ) {
				$wp_query_args['p'] = $ids[0];
			} else {
				$wp_query_args['post__in'] = $ids;
			}
		}

		$hidden_ids = ! empty( $hide ) ?  array_map( 'trim', explode( ',', $hide ) ) : null;
		if ( ! empty( $hidden_ids ) ) {
			$wp_query_args['post__not_in'] = $hidden_ids;
		}

		// query the authors.
		$authors = ! empty( $user_id ) ?  array_map( 'trim', explode( ',', $user_id ) ) : null;
		if ( ! empty( $authors ) ) {
			if ( 1 === count( $authors ) ) {
				$wp_query_args['author'] = $authors[0];
			} else {
				$wp_query_args['author__in'] = $authors;
			}
		}

		if ( $upcoming ) {
			$wp_query_args['meta_query'][] = array(
				'key'     => '_um_event_date_start',
				'compare' => '>=',
				'value'   => strtotime( 'today UTC' ),
			);
		}
		// exlude some users from list.
		$exclude_authors = ! empty( $excluded_users ) ?  array_map( 'trim', explode( ',', $excluded_users ) ) : null;
		if ( ! empty( $exclude_authors ) ) {
			$wp_query_args['author__not_in'] = $exclude_authors;
		}
		$profile_id = um_get_requested_user();

		if ( $profile_id ) {
			//$args['author'] = $profile_id;
		}

		$wp_query_args['posts_per_page'] = absint( $limit );
		$events = um_events_get_all( $wp_query_args );
		//print_r( $events );
		$template_args                    = array();
		$template_args['events']          = $events;
		$template_args['show_location']   = $show_location;
		$template_args['show_add_button'] = $show_add_button;
		get_um_events_template( 'events-list.php', $template_args );
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}