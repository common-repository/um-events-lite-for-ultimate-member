<?php
global $event_id;
$id                = $post_id = $event_id;
$event_title       = ($id ? get_the_title($id) : '');
$event_start       = get_post_meta( $post_id, '_um_event_date_start', true );
$event_end         = get_post_meta( $post_id, '_um_event_date_end', true );
$event_time_start  = get_post_meta( $post_id, '_um_event_time_start', true );
$event_time_end    = get_post_meta( $post_id, '_um_event_time_end', true );
$event_description = get_post_meta( $post_id, '_um_event_description', true );
$event_location    = get_post_meta( $post_id, '_um_event_location', true );
$bg_url            = '';
$image             = um_event_get_featured_image($id);
if ( $image ) {
	$bg_url = ' style="background-image: url(' . $image[0] . ')"';
}
?>
<div class="um-events-list-wrapper">
  <h3><?php echo esc_html( $event_title ); ?></h3>
  <?php if ( um_events_show_image() && $bg_url ) : ?>
  <div class="um-event-image" <?php echo $bg_url; ?>></div>
  <?php endif; ?>
  <ul class="um-events-list" id="um-events-list">
    <li id="um-event-<?php echo $post_id; ?>">
      <?php do_action( 'um_event_before_list_row', $event_id ); ?>
      <div class="um-event-date">
        <div class="um-event-date-block"> <span class="um-event-month"><?php echo date('M', strtotime($event_start)); ?></span> <span class="um-event-day"><?php echo date('d', strtotime($event_start)); ?></span> </div>
      </div>
      <div class="um-event-date-details">
        <div class="um-event-time"><?php echo ( $event_start ? date( 'dS M, Y', strtotime( $event_start ) ) : '' ); ?> <?php echo ( $event_time_start ? date('h:i A', strtotime( $event_time_start ) ) : '' ); ?>
          <?php if($event_end || $event_time_end ): ?>
          - <?php echo ($event_end ? date( 'dS M, Y', strtotime( $event_end ) ) : '' ); ?> <?php echo ( $event_time_end ? date( 'h:i A', strtotime( $event_time_end ) ) : '' ); ?>
          <?php endif; ?>
        </div>
        <?php if( $event_location ): ?>
        <div class="um-event-location"><strong>
          <?php _e('Location:', 'um-events'); ?>
          </strong> <?php echo esc_html( $event_location ); ?></div>
        <?php endif; ?>
      </div>
      <?php if ( um_events_allow_description() && $event_description ) : ?>
        <div class="um-event-description"><strong>
          <p><?php _e('Description', 'um-events'); ?></p>
          </strong> <?php echo wp_kses_post( $event_description ); ?></div>
        <?php endif; ?>
        <?php do_action( 'um_event_after_list_row', $event_id ); ?>
    </li>
  </ul>
</div>
<button title="Close (Esc)" type="button" class="mfp-close">×</button>