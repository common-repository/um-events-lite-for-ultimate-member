<?php
class UM_Events_Template {
	public function __construct() {
		add_action( 'wp_footer', array( $this, 'um_events_form_modal' ) );
		add_action( 'um_events_tab_header', array( $this, 'um_events_tab_header' ) );
		add_action( 'um_event_loop_view_content', array( $this, 'um_events_list_details' ), 8, 2 );
		
	}

	public function um_events_tab_header() {
		$args = array(
			'view' => um_events_current_view(),
		);
		get_um_events_template( 'elements/event-header.php', $args );
	}
	public function um_events_form_modal() {
		?>
	    <div id="um-event-modal" class="um-event-popup mfp-hide"></div>
	    <?php
	}

	public function um_events_list_details( $event_id = 0, $template_args = array() ) {
		get_um_events_template( 'elements/event-list-details.php', $template_args );
	} 
}
new UM_Events_Template();

