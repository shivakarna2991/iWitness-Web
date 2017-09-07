<?php
$events = $view_model['events'];
$page_info = isset($view_model['page_info']) ? $view_model['page_info'] : array();
$user = $view_model['user'];
$timezone = !empty($user->timezone)
    ? $user->timezone
    : (!empty(get_option('timezone_string'))
        ? get_option('timezone_string')
		: current(DateTimeZone::listIdentifiers(DateTimeZone::UTC)));
if(strpos($timezone, 'selected="selected') !== false)
	$timezone = str_replace('" selected="selected', "", $timezone);
$tz = new DateTimeZone($timezone);
?>

<?php do_action('iwitness_print_notices'); ?>

<h2>Videos</h2>
<hr>
<h6 class="text-danger text-uppercase-transform">
    Never attempt to take the law into your own hands. Inform the police immediately about any threatening situation.
</h6>
<hr>

<div class="row">
    <?php foreach ($events as $i => $event): ?>
<?php
    $id = isset($event['id']) ? $event['id'] : '';
    $display_name = isset($event['displayName']) ? $event['displayName'] : "&nbsp;";
    $image_url = isset($event['imageUrl']) ? $event['imageUrl'] : get_bloginfo('template_directory') . '/images/no-video-available.png';
    $created = isset($event['created']) ? $event['created'] : "";

    $date = new DateTime();
    $date->setTimestamp($created);
    $date->setTimezone($tz);

    ?>
        <?php if (($i) % 3 == 0): ?>
            </div>
            <div class="row">
        <?php endif; ?>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="event">
                <div class="panel panel-default widget">
                    <div class="panel-heading">
                        <h4>
                            <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_EVENT_VIEW_ID); ?>?id=<?php echo $id ?>">
                                <?= $display_name ?>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_EVENT_VIEW_ID); ?>?id=<?php echo $id ?>">
                            <img src="<?php echo $image_url ?>" alt="" class="img-responsive"
                                 onerror="this.src='<?php echo get_bloginfo('template_directory') . '/images/no-video-available.png'; ?>'"
                                 data-src="holder.js/100%x180" style="height: 200px; width: 100%; display: block;" />
                        </a>
                    </div>
                    <div class="panel-footer">
                        <span class="text-muted small">
                            Created on <?php echo $date->format("M d, Y \\a\\t g:ia") ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

</div>

<?php iwitness_pager($page_info, iwitness_get_page_path(IWITNESS_PAGE_EVENT_LIST_ID)); ?>

<div class="small">
    * Date and time are shown for <strong><?= $timezone ?></strong> timezone. <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_USER_PROFILE_EDIT_ID); ?>">Change
        timezone...</a>
</div>
