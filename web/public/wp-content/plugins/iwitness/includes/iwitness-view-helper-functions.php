<?php

/**
 * Adds prefix and suffix to given value if not empty,
 * otherwise returns empty string
 *
 * @param string $prefix
 * @param $value
 * @param string $suffix
 * @return type
 */
function iwitness_view_helper_decorate($prefix, $value, $suffix = '')
{
    if ('' !== (string)$value) {
        return $prefix . $value . $suffix;
    }
    return '';
}


/**
 * Formats phone number from normalized international form to human-friendly
 *
 * Normalized form example: 17525856424 (without +)
 * Human-friendly example
 *     for US: 752-585-6424
 *     for other countries: +1-752-585-6424
 *
 * @param string $phone
 * @return mixed|string
 */
function iwitness_view_helper_format_phone($phone)
{
    if (strlen($phone) < 10) {
        return $phone;
    }

    // make sure that valid int'l phone number
    $phone = iwitness_view_helper_format_intl_phone($phone);
    $length = strlen($phone);
    if ($length <= 0) {
        return '';
    }

    $human = substr($phone, $length - 10, 3) . '-'
        . substr($phone, $length - 7, 3) . '-'
        . substr($phone, $length - 4);

    if ('1' === $phone[0] && $length <= 11) {
        return $human; // US
    }

    return '+' . substr($phone, 0, $length - 10) . '-' . $human;
}

/**
 * Transforms phone number from human-friendly format to international format
 *
 * @param string $phone
 * @return mixed|string
 */
function iwitness_view_helper_format_intl_phone($phone)
{
    $norm = preg_replace('~[^0-9]~', '', $phone);

    if (10 === strlen($norm)) {
        return '1' . $norm; // US
    }

    return $norm;
}

/**
 * Adds prefix and suffix to given value if not empty,
 * otherwise returns empty string
 *
 * @param $count
 * @param $singular
 * @param null $plural
 * @return type
 */
function iwitness_view_helper_pluralize($count, $singular, $plural = null)
{
    if (null === $plural) {
        $plural = $singular . 's';
    }
    return intval($count) == 1 ? $singular : $plural;
}

/**
 * @param array $options
 * @param $selected
 */
function iwitness_view_helper_select_options($selected, array $options, $compare_exactly = false)
{
    foreach ($options as $key => $value) {
        if (!$compare_exactly) {
            iwitness_view_helper_select_option_render((string)$selected, $key, $value);
        } else {
            iwitness_view_helper_select_option_render((string)$selected, $key, $value);
        }
    }
}

function iwitness_view_helper_select_option_render($selected, $key, $value)
{
    if ($selected === '' || $selected === null) {
        if($key === iWitness::DEFAULT_TIMEZONE) {
            echo '<option selected="selected" value="' . sanitize_text_field($key) . '">' . sanitize_text_field($value) . '</option>';
        } else {
            echo '<option  value="' . sanitize_text_field($key) . '">' . sanitize_text_field($value) . '</option>';
        }
    } else {
        if ($key == $selected) {
            echo '<option selected="selected" value="' . sanitize_text_field($key) . '">' . sanitize_text_field($value) . '</option>';
        } else {
            echo '<option  value="' . sanitize_text_field($key) . '">' . sanitize_text_field($value) . '</option>';
        }
    }
}

/**
 * @param $value
 * @return bool|string
 */
function iwitness_view_helper_format_date($value)
{
    try {
        $result = $value ? date("m/d/Y", $value) : '';
    } catch (Exception $ex) {
        iwitness_log_error($ex->getMessage());
        $result = '';
    }
    return $result;
}


/**
 * @param $value
 * @return bool|string
 */
function iwitness_view_helper_format_datetime($value)
{
    try {
        $result = $value ? date("m/d/Y H:m:s", $value) : '';
    } catch (Exception $ex) {
        iwitness_log_error($ex->getMessage());
        $result = '';
    }
    return $result;
}
/**
 * @return array
 */
function iwitness_get_time_zone_options()
{
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();
    $utcTime = new DateTime('now', new DateTimeZone('UTC'));

    $tempTimezones = array();
    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
        $currentTimezone = new DateTimeZone($timezoneIdentifier);

        $tempTimezones[] = array(
            'offset' => (int)$currentTimezone->getOffset($utcTime),
            'identifier' => $timezoneIdentifier
        );
    }

    // Sort the array by offset,identifier ascending
    usort($tempTimezones, function ($a, $b) {
        return ($a['offset'] == $b['offset'])
            ? strcmp($a['identifier'], $b['identifier'])
            : $a['offset'] - $b['offset'];
    });

    $timezoneList = array();
    foreach ($tempTimezones as $tz) {
        $sign = ($tz['offset'] > 0) ? '+' : '-';
        $offset = gmdate('H:i', abs($tz['offset']));
        $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
            $tz['identifier'];
    }

    return $timezoneList;
}


/**
 * @param array $data
 * @param bool $linkEmail
 * @return string
 */
function iwitness_display_name(array $data, $linkEmail = true)
{
    if (!empty($data['firstName']) || !empty($data['lastName'])) {
        $name = trim($data['firstName'] . ' ' . $data['lastName']);
    } else if ($data['email']) {
        $name = $data['email'];
    } else if ($data['phone']) {
        $name = '+' . $data['phone'];
    } else {
        $name = 'Unnamed';
    }

    if ($linkEmail && $data['email']) {
        $email = $data['email'];
        $name = "<a href='mailto:{$email}'>$name</a>";
    }
    return $name;
}

/**
 * Get States
 *
 * @return array
 */
function iwitness_get_states()
{
    return array(
        'AL' => "Alabama", 'AK' => "Alaska", 'AZ' => "Arizona", 'AR' => "Arkansas",
        'CA' => "California", 'CO' => "Colorado", 'CT' => "Connecticut", 'DE' => "Delaware",
        'DC' => "District Of Columbia", 'FL' => "Florida", 'GA' => "Georgia", 'HI' => "Hawaii",
        'ID' => "Idaho", 'IL' => "Illinois", 'IN' => "Indiana", 'IA' => "Iowa", 'KS' => "Kansas",
        'KY' => "Kentucky", 'LA' => "Louisiana", 'ME' => "Maine", 'MD' => "Maryland", 'MA' => "Massachusetts",
        'MI' => "Michigan", 'MN' => "Minnesota", 'MS' => "Mississippi", 'MO' => "Missouri", 'MT' => "Montana",
        'NE' => "Nebraska", 'NV' => "Nevada", 'NH' => "New Hampshire", 'NJ' => "New Jersey",
        'NM' => "New Mexico", 'NY' => "New York", 'NC' => "North Carolina", 'ND' => "North Dakota",
        'OH' => "Ohio", 'OK' => "Oklahoma", 'OR' => "Oregon", 'PA' => "Pennsylvania", 'RI' => "Rhode Island",
        'SC' => "South Carolina", 'SD' => "South Dakota", 'TN' => "Tennessee", 'TX' => "Texas",
        'UT' => "Utah", 'VT' => "Vermont", 'VA' => "Virginia", 'WA' => "Washington", 'WV' => "West Virginia",
        'WI' => "Wisconsin", 'WY' => "Wyoming"
    );
}



function iwitness_pager($page_info, $base_url)
{
    if (!$page_info) return;

    if ($page_info['page_count'] > 1) {
        $current_page = get_query_var('page');
        ?>
        <form id='pager' role="form" method="POST" data-validate="true">
            <div class="pull-right">
                <ul class="pagination pagination-sm">
                    <li class="<?php echo $current_page == 1 ? 'disabled' : ''; ?>">
                        <a href="<?php echo esc_url("{$base_url}?page=1"); ?>">&laquo;</a>
                    </li>
                    <?php for ($index = 1; $index <= $page_info['page_count']; $index++):
                        $url = "?page={$index}";
                        $url = $base_url . $url;
                        $url = esc_url($url);
                        ?>
                        <li class="<?php echo $current_page == $index || ($index == 1 && $current_page == 0) ? 'active' : ''; ?>">
                            <a href="<?php echo $url; ?>"><?php echo $index; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="<?php echo $current_page == $page_info['page_count'] ? 'disabled' : ''; ?>">
                        <a href="<?php echo esc_url("{$base_url}?page={$page_info['page_count']}"); ?>">&raquo;</a>
                    </li>
                </ul>
            </div>
        </form>
    <?php
    }
}

function iwitness_guest_menu_render()
{
    global $post;

    if (!is_user_logged_in() && $post) {
        ?>

        <li class="<?php echo $post->post_name == 'start-now' ? 'active' : ''; ?>">
            <a href="/start-now"> Purchase </a>
        </li>
        <li class="<?php echo $post->post_name == 'content-learn-more' ? 'active' : ''; ?>">
            <a href="/content-learn-more"> Learn More </a>
        </li>
        <li>
            <a href="<?php echo wp_login_url(); ?>">
                Sign In </a>
        </li>

    <?php
    }
}

function iwitness_admin_menu_render()
{
    if (iwitness_is_api_admin_user()) {
        ?>

        <li>
            <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_PROMO_CODE_LIST_ID); ?>">
                Promotion </a>
        </li>
        <li>
            <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_ADMIN_DELETE_USER_ID); ?>">
                User </a>
        </li>
        <li>
            <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_NOTIFICATION_ID); ?>">
                Notification</a>
        </li>

        <li class="dropdown-submenu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                Report
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo iwitness_get_page_path(IWITNESS_USER_REPORT_ID); ?>">List all users</a></li>
                <li><a href="<?php echo iwitness_get_page_path(IWITNESS_USER_EVENT_REPORT_ID); ?>">User activity by
                        created event</a></li>
                <li><a href="<?php echo iwitness_get_page_path(IWITNESS_REVENUE_REPORT_ID); ?>">Revenue by date
                        range</a></li>
                <li><a href="<?php echo iwitness_get_page_path(IWITNESS_SUBSCRIPTION_REPORT_ID); ?>">Subscriptions by
                        exp date</a></li>
            </ul>
        </li>

    <?php
    }
}

function iwitness_user_menu_render()
{
    if (is_user_logged_in()) {
        ?>

        <li>
            <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_USER_PROFILE_EDIT_ID); ?>">My Account </a>
        </li>

        <li><a href="/content-events">
                Videos </a></li>
        <li><a href="/content-contacts">
                Emergency Contacts </a></li>
        <?php   if (!iwitness_is_api_admin_user()){ ?>
        <li><a href="/gift-card">
				Gift Card </a></li>
        <?php } ?>
        <li class="divider"></li>

        <?php iwitness_admin_menu_render(); ?>

        <li class="divider"></li>

        <li>
            <a href="<?php echo wp_logout_url(home_url()); ?>">
                Logout
            </a>
        </li>
    <?php
    }
}

function iwitness_small_device_user_menu_render()
{
    if (is_user_logged_in()) {
        ?>

        <li>
            <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_USER_PROFILE_EDIT_ID); ?>">My Account </a>
        </li>

        <li><a href="/content-events">
                Events </a></li>
        <li><a href="/content-contacts">
                Contacts </a></li>

        <?php
        if (iwitness_is_api_admin_user()) {
            ?>

            <li>
                <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_PROMO_CODE_LIST_ID); ?>">
                    Promotion </a>
            </li>
            <li>
                <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_ADMIN_DELETE_USER_ID); ?>">
                    User </a>
            </li>
            <li>
                <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_NOTIFICATION_ID); ?>">
                    Notification</a>
            </li>

        <?php } ?>

        <li>
            <a href="<?php echo wp_logout_url(home_url()); ?>">
                Logout </a>
        </li>
    <?php
    }
}


