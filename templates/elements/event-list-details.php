<div class="um-event-date">
	<div class="um-event-date-block"> <span class="um-event-month"><?php echo date('M', strtotime($event_start)); ?></span> <span class="um-event-day"><?php echo date('d', strtotime($event_start)); ?></span> </div>
</div>
<div class="um-event-date-details">
	<div class="um-event-title">
		<h2><a href="#" data-eventid="<?php the_ID(); ?>" class="um-event-link" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
	</div>
	<div class="um-event-time"><?php echo ($event_start ? date('dS M, Y', strtotime($event_start)) : ''); ?> <?php echo ($event_time_start ? date('h:i A', strtotime($event_time_start)) : ''); ?>
	<?php if($event_end || $event_time_end ): ?>
		-
	<?php echo ($event_end ? date('dS M, Y', strtotime($event_end)) : ''); ?> <?php echo ($event_time_end ? date('h:i A', strtotime($event_time_end)) : ''); ?>    <?php endif; ?>
	</div>
	<?php if ( $event_location ) : ?>
		<div class="um-event-location"><strong><?php _e('Location:', 'um-events'); ?></strong> <?php echo $event_location; ?></div>
	<?php endif; ?>
	<?php if( um_events_can_edit() ) { ?>
	<div class="um-doc-action">
		<span class="um-event-edit">
			<a href="<?php echo um_get_events_edit_link( $post_id ); ?>" class="um-event-edit--link"  data-id="<?php echo $post_id; ?>"><i class="um-faicon-pencil"></i>
			<?php _e( 'Edit', 'um-events' ); ?>
		</a>
		</span> &nbsp;&nbsp; <span class="um-event-delete"> <a href="" data-id="<?php echo $post_id; ?>" target="_blank" class="um-event-delete-link"><i class="um-faicon-trash"></i>
		<?php _e( 'Delete', 'um-events' ); ?>
		</a>
	</span>
	</div>
	<?php } ?>
</div>