<?php
$event = $view_model['event'];
$user = $view_model['user'];

$id = isset($event['id']) ? $event['id'] : "";
$display_name = isset($event['name']) ? $event['name'] : "";
$processed = isset($event['processed']) ? $event['processed'] : "";
$created = isset($event['created']) ? $event['created'] : "";
$initial_lat = isset($event['initialLat']) ? $event['initialLat'] : "";
$initial_long = isset($event['initialLong']) ? $event['initialLong'] : "";
$video_url = isset($event['videoUrl']) ? $event['videoUrl'] : "";
$image_url = isset($event['imageUrl']) ? $event['imageUrl'] : "";

$timezone = !empty($user->timezone)
    ? $user->timezone
    : (!empty(get_option('timezone_string'))
        ? get_option('timezone_string')
        : current(DateTimeZone::listIdentifiers(DateTimeZone::UTC)));
$date = new DateTime();
$date->setTimestamp($created);
$date->setTimezone(new DateTimeZone($timezone));

?>

<?php do_action('iwitness_print_notices'); ?>

<h2>Video</h2>
<a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_EVENT_LIST_ID); ?>">Latest Videos</a>
<hr>

<div class="row">
    <div id="events" class="view"
         data-id="<?php echo $id; ?>"
         data-width="<?php echo '100%' ?>"
         data-height="<?php echo 480 ?>"
         data-image-url="<?php echo $image_url; ?>"
         data-video-url="<?php echo $video_url; ?>"
         data-initial-lat="<?php echo $initial_lat; ?>"
         data-initial-long="<?php echo $initial_long; ?>">

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <form role="form" id="event-form" action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $id ?>" />

                <div class="form-group">
                    <label for="title" class="control-label">Title of Video: </label>
                    <input type="text" name="title" class="form-control" value="<?php echo $display_name ?>" id="title"
                           placeholder="Enter Title">
                </div>

                <div class="form-group">
                    <label class="control-label">Created: </label>
                    <?php echo $date->format("M d, Y") ?>
                </div>

                <div class="form-group">
                    <label class="control-label">Time: </label>
                    <?php echo $date->format("g:i:s A") ?> *
                </div>

                <div class="form-group">
                    <small>
                        * Date and time are shown for <strong><?php echo $timezone ?></strong> timezone.
                        <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_USER_PROFILE_EDIT_ID); ?>">Change timezone...</a>
                    </small>
                </div>

                <?php if (!$event): ?>
                    <div class="form-group">
                        Video wasn't uploaded
                    </div>
                <?php elseif (!$processed): ?>
                    <?php if (time() - $created > 15 * 60): ?>
                        <div class="form-group">
                            <p>Failed to process uploaded video</p>
                            <p>Please contact us for further investigation</p>
                        </div>
                    <?php else: ?>
                        <div class="no-asset">
                            We are currently processing uploaded video, please wait
                        </div>
                    <?php endif; ?>
                <?php
                else: ?>
                    <div id="mediaplayer"></div>
                <?php endif; ?>
                <br>
                <button type="submit" class="btn btn-primary" name="action" value="iwitness_do_update_event">SAVE</button>
            </form>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <?php if (!$initial_lat || !$initial_long): ?>
                <div class="no-coords smooth-text">
                    Map view is not available
                </div>
            <?php else: ?>
                <div id="map-canvas" style="width: 100%; height: 700px;"></div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php
// lazy loading style and script
wp_print_scripts('iwitness-event-video-player-plugin');
wp_print_scripts('google-map-plugin');
wp_print_scripts('iwitness-event-google-map-plugin');
?>

