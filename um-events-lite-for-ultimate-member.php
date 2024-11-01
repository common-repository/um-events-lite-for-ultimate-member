<?php
/*
 * Plugin Name: UM Events
 * Plugin URI: https://suiteplugins.com/downloads/um-events-pro/
 * Description: Manage events from Ultimate Member Profile
 * Version: 1.0.0
 * Author: SuitePlugins
 * Author URI: https://suiteplugins.com/
 * License:     GPLv2 or later.
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: um-events
 * Domain Path: /languages
 */

if ( ! defined( 'UM_EVENTS_PATH' ) ) {
	define( 'UM_EVENTS_URL', plugin_dir_url( __FILE__ ) );
	define( 'UM_EVENTS_PATH', plugin_dir_path( __FILE__ ) );
	define( 'UM_EVENTS_PLUGIN_PATH', __FILE__ );
	define( 'UM_EVENTS_PLUGIN', plugin_basename( __FILE__ ) );
	define( 'UM_EVENTS_PLUGIN_VERSION', '1.0.0' );
	define( 'UM_EVENTS_STORE_URL', 'https://suiteplugins.com' );
	define( 'UM_EVENTS_ITEM_NAME', 'Events Pro for UltimateMember' );
}
function um_events_lite_load_plugin_textdomain() {

	$domain = 'um-events';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	// wp-content/languages/um-events/plugin-name-de_DE.mo
	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

	// wp-content/plugins/um-events/languages/plugin-name-de_DE.mo
	load_plugin_textdomain( $domain, false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'um_events_lite_load_plugin_textdomain' );

if ( ! class_exists( 'UltimateMember_Lite_Events' ) ) :

	class UltimateMember_Lite_Events {
		/**
		 * @var UltimateMember_Lite_Events The single instance of the class
		 */
		protected static $_instance = null;
		/**
		 * Main UltimateMember_Stories Instance
		 *
		 * Ensures only one instance of UltimateMember_Stories is loaded or can be loaded.
		 *
		 * @static
		 * @return UltimateMember_Lite_Events - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self( );
			}
			return self::$_instance;
		}
		/*
		*    Initiate construct
		*/
		public function __construct() {
			/** Paths *************************************************************/

			// Setup some base path and URL information
			$this->file       = __FILE__;
			$this->basename   = apply_filters( 'um_events_plugin_basename', plugin_basename( $this->file ) );
			$this->plugin_dir = apply_filters( 'um_events_plugin_dir_path', plugin_dir_path( $this->file ) );
			$this->plugin_url = apply_filters( 'um_events_plugin_dir_url', plugin_dir_url( $this->file ) );

			$this->post_type = 'um_events';
			$this->init_hooks( );
			$this->includes( );
		}
		/*
		*    Include classes and files
		*/
		public function includes() {
			require_once( UM_EVENTS_PATH . 'includes/template-functions.php' );
			require_once( UM_EVENTS_PATH . 'classes/sp-postController-class.php' );
			require_once( UM_EVENTS_PATH . 'includes/class-um-events-shortcodes.php' );
			require_once( UM_EVENTS_PATH . 'includes/um-events-functions.php' );
			require_once( UM_EVENTS_PATH . 'includes/um-events-posttypes.php' );
			require_once( UM_EVENTS_PATH . 'includes/class-um-events-ajax.php' );
			require_once( UM_EVENTS_PATH . 'includes/class-um-events-admin.php' );
			require_once( UM_EVENTS_PATH . 'includes/um-events-template.php' );
			$this->shortcodes = new UM_Events_Shortcodes();
			$this->ajax       = new UM_Events_Ajax();
		}
		/*
		*    Initiate hooks
		*/
		public function init_hooks() {

			//Hook for creating Menu Items : um_user_profile_tabs
			add_filter( 'um_user_profile_tabs', array( $this, 'um_custom_tab' ), 12, 1 );
			//
			add_filter( 'um_profile_tabs', array( $this, 'add_um_profile_tabs' ), 12, 1 );

			//Hook: um_profile_content_$menu_key
			add_action( 'um_profile_content_events', array( $this, 'events_content_page' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
		}
		/*
		*    This function will return an array of tabs. Use this function to rename or add a new tab array
		*
		*/
		public function um_custom_tab( $tabs = array() ) {
			$tabs['events'] = array(
				'name' => __( 'Events', 'um-events' ),
				'icon' => 'um-faicon-calendar',
			);
			return $tabs;
		}

		/**
		 * This function will return an array of tabs. Use this function to rename or add a new tab array
		 * @param  array  $tabs
		 * @return array
		 */
		public function add_um_profile_tabs( $tabs = array() ) {
			$tabs['events'] = array(
				'name'           => __( 'Events', 'um-events' ),
				'icon'           => 'um-faicon-calendar',
				'custom'         => true,
				'subnav_default' => 0,
			);
			return $tabs;
		}
		/*
		*
		*/
		public function add_scripts() {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			wp_enqueue_style( 'um_events_ui_style', '//code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css' );
			wp_enqueue_style( 'um_events_style', UM_EVENTS_URL . 'assets/css/um-events' . $suffix . '.css' );
			wp_register_script( 'um_events', UM_EVENTS_URL . 'assets/js/um-events' . $suffix . '.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-tabs','jquery-ui-autocomplete' ), UM_EVENTS_PLUGIN_VERSION, true );
			// Localize the script with new data.
			$localization = array(
				'site_url'      => site_url(),
				'nonce'         => wp_create_nonce( 'um-event-nonce' ),
				'ajax_url'      => admin_url( 'admin-ajax.php' ),
				'get_users'     => site_url( '/?um_event_get_users=1' ),
				'events_feed'   => '',
				'no_events_txt' => __( 'No events found.','um-events' ),
			);
			wp_localize_script( 'um_events', 'um_event_config', $localization );
			wp_enqueue_script( 'um_events_monthly' );
			wp_enqueue_script( 'um_events' );
		}
		/*
		*    load_template
		*
		*    Load event template from plugin/theme
		*
		*/
		public function load_template( $tpl = '' ) {

			$file = UM_EVENTS_PATH . 'templates/' . $tpl . '.php';
			$theme_file = get_stylesheet_directory() . '/ultimate-member/templates/um-events/' . $tpl . '.php';

			if ( file_exists( $theme_file ) ) {
				$file = $theme_file;
			}

			if ( file_exists( $file ) ) {
				include( $file );
			}
		}
		/*
		*    Setup content page on profile
		*/
		public function events_content_page() {
			do_action( 'um_events_tab_header' );
			if ( isset( $_GET['event_action'] ) && 'edit_event' == $_GET['event_action'] ) : 
				$id                = isset( $_GET ) && isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
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
				$post_id = $id;
				$template_args = array(
					'id'                => $id,
					'post_id'           => $id,
					'event_id'          => $id,
					'event_title'       => $id ? get_the_title( $id ) : '',
					'event_start'       => get_post_meta( $post_id, '_um_event_date_start', true ),
					'event_end'         => get_post_meta( $post_id, '_um_event_date_end', true ),
					'event_time_start'  => get_post_meta( $post_id, '_um_event_time_start', true ),
					'event_time_end'    => get_post_meta( $post_id, '_um_event_time_end', true ),
					'event_description' => get_post_meta( $post_id, '_um_event_description', true ),
					'event_location'    => get_post_meta( $post_id, '_um_event_location', true ),
					'event_ticket_url'  => get_post_meta( $post_id, '_um_event_ticket_url', true ),
					'bg_url'            => $bg_url,
					'form_title'        => $form_title,
				);
				get_um_events_template( 'events-list-tab-form.php', $template_args );
			else:

				$view            = um_events_current_view();
				$upcoming        = '';
				$show_location   = '';
				$show_add_button = '';
				$limit           = '';
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

				if ( 'upcoming' == $view ) {
					$wp_query_args['meta_query'][] = array(
						'key'     => '_um_event_date_start',
						'compare' => '>=',
						'value'   => date( 'Y-m-d', strtotime( 'today UTC' ) ),
					);
					$wp_query_args['author'] = um_get_requested_user();
				} elseif( 'past' == $view ) {
					$wp_query_args['meta_query'][] = array(
						'key'     => '_um_event_date_start',
						'compare' => '<',
						'value'   => date( 'Y-m-d', strtotime( 'today UTC' ) ),
					);
					$wp_query_args['author'] = um_get_requested_user();
				} elseif( 'invites' == $view ){
					// Invites
					$invited_events = um_events()->guests->get_events_user_invited_to();
					$wp_query_args['post__in'] = $invited_events;
				}
				// exlude some users from list.
				$exclude_authors = ! empty( $excluded_users ) ?  array_map( 'trim', explode( ',', $excluded_users ) ) : null;
				if ( ! empty( $exclude_authors ) ) {
					$wp_query_args['author__not_in'] = $exclude_authors;
				}

				if ( 'invites' == $view ) {

				}
				$wp_query_args['posts_per_page'] = absint( $limit );
				$events = um_events_get_all( $wp_query_args );
				//print_r( $events );
				$template_args                    = array();
				$template_args['events']          = $events;
				$template_args['show_location']   = $show_location;
				$template_args['show_add_button'] = $show_add_button;
				get_um_events_template( 'events-list-tab.php', $template_args );
			endif;
			do_action( 'um_events_tab_footer' );
		}
	}
	if ( ! class_exists( 'UltimateMember_Events' ) && ! function_exists( 'um_events' ) ) {
		function um_events() {
			return UltimateMember_Lite_Events::instance( );
		}

		um_events();

		function um_events_install() {
			// Clear the permalinks after the post type has been registered
			flush_rewrite_rules();
		}
		register_activation_hook( __FILE__, 'um_events_install' );


		function um_events_deactivation() {
			// Clear the permalinks to remove our post type's rules
			flush_rewrite_rules();
		}
		register_deactivation_hook( __FILE__, 'um_events_deactivation' );
	}

endif;
