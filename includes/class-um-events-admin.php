<?php

class UM_Events_Admin {
	/**
	 * Settings page ID.
	 *
	 * @var string
	 */
	public $settings_url = 'um_events_settings';
	/**
	 * License Key.
	 *
	 * @var string
	 */
	public $um_license_key = 'um_license_key';
	/**
	 * License Status.
	 *
	 * @var string
	 */
	public $um_license_status = 'um_license_status';

	/**
	 * License Key.
	 *
	 * @var    string
	 * @since  1.0.5
	 */
	public $license_key = 'learndash_activity_license_key';

	/**
	 * License Status.
	 *
	 * @var    string
	 * @since  1.0.5
	 */
	public $license_status = 'learndash_activity_license_status';

	/**
	 * Option key, and option page slug.
	 *
	 * @var    string
	 * @since  1.0.5
	 */
	protected $key = 'um_events_settings';

	/**
	 * Options page metabox ID.
	 *
	 * @var    string
	 * @since  1.0.5
	 */
	protected $metabox_id = 'um_events_admin_metabox';

	/**
	 * Options Page title.
	 *
	 * @var    string
	 * @since  1.0.5
	 */
	protected $title = '';

	/**
	 * Options Page hook.
	 *
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Active Tab
	 *
	 * @var string
	 */
	public $active_tab = '';

	public function __construct() {
		$this->active_tab = ( isset( $_GET['tab'] ) && ! empty( $_GET['tab'] ) ? esc_attr( $_GET['tab'] ) : 'setup' );
		// Set our title.
		$this->title = esc_attr__( 'Events', 'um-events' );

		add_action( 'admin_menu', array( $this, 'setup_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_settings_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
		add_action( 'cmb2_admin_init', array( $this, 'metaboxes' ) );
	}

	public function metaboxes() {
		add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );

		$prefix = 'um_events_';
		$cmb = new_cmb2_box( array(
			'id'		 => $this->metabox_id,
			'hookup'	 => false,
			'cmb_styles' => true,
			'show_on'	=> array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key ),
			),
		) );

		$cmb->add_field( array(
			'name'       => __( 'Show Event Image', 'um-events' ),
			'desc'       => __( 'Show event featured image', 'um-events' ),
			'id'         => $prefix . 'show_image',
			'type'       => 'checkbox',
		) );

		$cmb->add_field( array(
			'name'       => __( 'Allow Description', 'um-events' ),
			'desc'       => __( 'Allow event description in form', 'um-events' ),
			'id'         => $prefix . 'form_description',
			'type'       => 'checkbox',
		) );

		$cmb->add_field( array(
			'name'       => __( 'Allow Ticket URL', 'um-events' ),
			'desc'       => __( 'Allow ticket URL in form', 'um-events' ),
			'id'         => $prefix . 'form_tickets',
			'type'       => 'checkbox',
		) );

		$cmb->add_field( array(
			'name'       => __( 'Restrict frontend file upload', 'um-events' ),
			'desc'       => __( 'Restrict users from adding events from their profile', 'um-events' ),
			'id'         => $prefix . 'allow_upload',
			'type'       => 'checkbox',
		) );
	}
	public function admin_assets() {
		wp_enqueue_style( 'um_events_style', um_events()->plugin_url . 'assets/css/um-events.css' );
		wp_enqueue_style( 'um-events-chosen', um_events()->plugin_url . 'assets/css/chosen.min.css' );
		wp_enqueue_style( 'um-events-admin', um_events()->plugin_url . 'assets/css/um-events-admin.css' );
		wp_enqueue_script( 'um-events-chosen', um_events()->plugin_url . 'assets/js/chosen.jquery.min.js', array( 'jquery' ) );
		wp_register_script( 'um_events', UM_EVENTS_URL . 'assets/js/um-events.js', array( 'jquery' ) );
		// Localize the script with new data
		$localization = array(
			'site_url'       => site_url(),
			'nonce'          => wp_create_nonce( 'um-event-nonce' ),
			'ajax_url'       => admin_url( 'admin-ajax.php' ),
			'no_events_txt'  => __( 'No events found.','um-events' ),
		);
		wp_localize_script( 'um_events', 'um_event_config', $localization );
		wp_enqueue_script( 'um_events' );
	}
	public function setup_menu() {
		add_submenu_page(
			'edit.php?post_type=um_events',
			__( 'Settings', 'um-events' ),
			__( 'Settings', 'um-events' ),
			'manage_options',
			$this->settings_url,
			array( $this, 'settings_display' )
		);
	}

	public function settings_display( $active_tab = '' ) {
		$post_type = um_events()->post_type;
		?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h2><?php esc_html_e( 'UM Events', 'um-events' ); ?></h2>
			<?php settings_errors(); ?>

			<?php
			$active_tab = 'general';
			?>
			<h2 class="nav-tab-wrapper">
				<a href="<?php echo admin_url( 'edit.php?post_type=' . $post_type . '&page=' . $this->settings_url . '&tab=general' ); ?>" class="nav-tab <?php echo 'general' === $active_tab ? 'nav-tab-active' : ''; ?>">General</a>
			</h2>

			<form method="post" action="options.php">
				<?php //wp_nonce_field('update-options') ?>
				<?php
				$this->general_fields();
				?>
				<?php submit_button( 'Save all changes', 'primary','submit', true ); ?>
			</form>

		</div><!-- /.wrap -->
	<?php
	}

	public function general_fields() {
		$post_type = um_events()->post_type;
		settings_fields( 'um_events_general' );
		$form_page = get_option( 'um_events_form_page' );
		?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Show Event Image','um-events' ); ?>
					</th>
					<td>
						<input type="checkbox" name="um_events_show_image" id="um_events_show_image" value="1" <?php checked( um_events_show_image(), '1', true ); ?> />
						<label class="description" for="um_events_show_image"><?php esc_html_e( 'Show event featured image','um-events' ); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Allow Description','um-events' ); ?>
					</th>
					<td>
						<input type="checkbox" name="um_events_form_description" id="um_events_form_description" value="1" <?php checked( get_option( 'um_events_form_description' ), '1', true ); ?> />
						<label class="description" for="um_events_form_description"><?php esc_html_e( 'Allow event description in form','um-events' ); ?></label>
					</td>
				</tr>
				<?php do_action( 'um_events_general_admin_settings' ); ?>
			 </tbody>
		</table>
		<?php
	}


	public function admin_settings_init() {
		register_setting( 'um_events_general', 'um_events_show_image' );
		register_setting( 'um_events_general', 'um_events_form_description' );
	}
}
$um_events_admin = new UM_Events_Admin();
