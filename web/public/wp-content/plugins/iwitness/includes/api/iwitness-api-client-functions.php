<?php

include_once(iWitness()->plugin_path() . '/includes/api/oauth/class-iwitness-user.php');
include_once(iWitness()->plugin_path() . '/includes/api/oauth/class-iwitness-access-token.php');
include_once(iWitness()->plugin_path() . '/includes/api/class-iwitness-api-exception.php');
include_once(iWitness()->plugin_path() . '/includes/api/oauth/iwitness-oauth-functions.php');
include_once(iWitness()->plugin_path() . '/includes/api/iwitness-api-contact-functions.php');
include_once(iWitness()->plugin_path() . '/includes/api/iwitness-api-user-functions.php');
include_once(iWitness()->plugin_path() . '/includes/api/iwitness-api-setting-functions.php');


if (!defined('IWITNESS_CURRENT_USER_ACCESS_TOKEN')) {
    define('IWITNESS_CURRENT_USER_ACCESS_TOKEN', 'IWITNESS_CURRENT_USER_ACCESS_TOKEN');
}

if (!defined('IWITNESS_CURRENT_USER')) {
    define('IWITNESS_CURRENT_USER', 'IWITNESS_CURRENT_USER');
}

if (!defined('IWITNESS_API_CLIENT_ID')) {
    define('IWITNESS_API_CLIENT_ID', 'e114cbaa-f5a1-11e3-bc94-000c29c9a052');
}

if (!defined('IWITNESS_API_CLIENT_SECRET')) {
    define('IWITNESS_API_CLIENT_SECRET', 'ad990419-23f0-11e4-b8aa-000c29c9a052');
}

/**
 * @param $url
 * @param array $args
 * @param bool $is_filter_body
 * @return array|iWitness_Api_Exception
 * @throws InvalidArgumentException
 * @throws iWitness_Api_Exception
 */
function iwitness_api_request($url, $args = array(), $is_filter_body = true)
{
    /** @var iWitness $iWitness */
    $iWitness = iWitness();
    $start_time = microtime();

    $allow_methods = array('GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD');

    if (!isset($args['method']) || !in_array($args['method'], $allow_methods)) {
        throw new \InvalidArgumentException('method should be ' . implode(',', $allow_methods) . ', ' . $args['method'] . ' given');
    }

    iwitness_log_debug('----------------------------------------- begin to ' . $args['method']);

    //$args['timeout'] =56222;

    $response = null;

    //fix relative uri
    if (iwitness_string_start_with($url, 'http://') || iwitness_string_start_with($url, 'https://')) {
        //nothing change
    } else {
        $url = $iWitness->api_uri() . $url;
    }

    iwitness_log_debug('calling url = ' . $url);

    //default is json data
    if (!isset($args['headers']['Content-Type'])) {
        $args['headers']['Content-Type'] = 'application/json';
    }

    //create json data
    if (isset($args['headers']['Content-Type']) &&
        $args['headers']['Content-Type'] == 'application/json'
    ) {
        if (isset($args['body']) && is_array($args['body'])) {
            $args['body'] = json_encode($args['body']);
        }
    }

    //setup bearer

    $token = iwitness_get_current_user_access_token();
    if ($token && $token->hasExpired()) {
        $token = iwitness_refresh_access_token($token);
        if($token){
            $args['headers']['Authorization'] =  'Bearer ' . $token->access_token;
        }
    }

    if (!isset($args['headers']['Authorization']) && ($token)) {
        $headers = array_merge($args['headers'], $token->get_bearer());
        $args['headers'] = $headers;
    }

    //iwitness_log_debug('request is: ======= ' . print_r($args, true));

    $wp_http = iwitness_http_get_object();
    $response = $wp_http->request($url, $args);

    iwitness_log_debug('time spent  =' . (microtime() - $start_time) . ' milliseconds');
    //hung nguyen removed
    //iwitness_log_debug('return data =' . print_r($response, true));

    $data = iwitness_validate_response($response);


    if ($is_filter_body) {
        return $data;
    }
    return $response;
}

/**
 * @param $response
 * @return array|mixed
 * @throws iWitness_Api_Exception
 */
function iwitness_validate_response($response)
{
    //parse response
    if (is_wp_error($response)) {
        throw \iWitness_Api_Exception::parse_from($response);
    }

    $data = json_decode($response['body'], true);
    //check server return error
    if (isset($data['status'])
        && (intval($data['status']) < 200 || intval($data['status']) > 299)
    ) {
        throw new \iWitness_Api_Exception($data['detail'], $data['status'], $data);
    }

    //check internal server error
    if (isset($response['response']['code'])
        && (intval($response['response']['code']) < 200 || intval($response['response']['code']) > 299)
    ) {
        throw new \iWitness_Api_Exception($response['response']['message'], $response['response']['code'], $data);
    }
    return $data;
}


/**
 * @param $response
 */
function iwitness_api_response_filter($response, $resource_name, $filter_first = false)
{
    //do not process error response
    if (is_wp_error($response)) {
        return $response;
    }

    //extract embedded
    $data = $response;
    if (isset($response['_embedded'][$resource_name])) {
        $data = $response['_embedded'][$resource_name];
        if ($filter_first) {
            if (count($response['_embedded'][$resource_name]) > 0) {
                $data = $response['_embedded'][$resource_name][0];
            } else {
                $data = null;
            }
        }
    }
    return $data;
}

/**
 * @param $response
 * @return array
 */
function iwitness_api_response_paging_filter($response)
{
    $page_count = intval($response['page_count']);
    $page_size = intval($response['page_size']);
    $total_items = intval($response['total_items']);

    return array(
        'page_count' => $page_count,
        'page_size' => $page_size,
        'total_items' => $total_items
    );
}


/**
 * @param $url
 * @param array $args
 * @return array|iWitness_Api_Exception
 */
function iwitness_api_get($url, $args = array())
{
    $defaults = array('method' => 'GET');
    $r = wp_parse_args($args, $defaults);
    return iwitness_api_request($url, $r);
}

/**
 * @param $url
 * @param array $args
 * @return array|iWitness_Api_Exception
 */
function iwitness_api_post($url, $args = array())
{
    $defaults = array('method' => 'POST');
    $r = wp_parse_args($args, $defaults);
    return iwitness_api_request($url, $r);
}

/**
 * @param $url
 * @param array $args
 * @return array|iWitness_Api_Exception
 */
function iwitness_api_put($url, $args = array())
{
    $defaults = array('method' => 'PUT');
    $r = wp_parse_args($args, $defaults);
    return iwitness_api_request($url, $r);
}

/**
 * @param $url
 * @param array $args
 * @return array|iWitness_Api_Exception
 */
function iwitness_api_patch($url, $args = array())
{
    $defaults = array('method' => 'PATCH');
    $r = wp_parse_args($args, $defaults);
    return iwitness_api_request($url, $r);
}

/**
 * @param $url
 * @param array $args
 * @return array|iWitness_Api_Exception
 */
function iwitness_api_delete($url, $args = array())
{
    $defaults = array('method' => 'DELETE');
    $r = wp_parse_args($args, $defaults);
    return iwitness_api_request($url, $r);
}

/**
 * @return null | iWitness_Access_Token
 */
function iwitness_get_current_user_access_token($default = null)
{
    $login_user = wp_get_current_user();
    if ($login_user) {
        return iwitness_get_token_from_meta($login_user);
    }
    return $default;
}

/**
 *
 * @param WP_User | user id
 * @return iWitness_Access_Token|null
 */
function iwitness_get_token_from_meta($user)
{
    $id = ($user instanceof WP_User) ? $user->ID : $user;

    /** @var iWitness $iWitness */
    $iWitness = iWitness();
    $key = IWITNESS_CURRENT_USER_ACCESS_TOKEN . '_' . $id;

    //get from cache
    if (isset($GLOBALS[$key])) {
        return $GLOBALS[$key];
    }

    //get from database
    //iwitness_log_debug('begin to get token from database, id =' . $id);
    $api_json = get_user_meta($id, $iWitness->user_meta_api_token(), true);
    //iwitness_log_debug('json token ' . $api_json);

    if ($api_json) {
        $token = iWitness_Access_Token::deserialize($api_json);
        $GLOBALS[$key] = $token;
        return $token;
    }
    return null;
}


/**
 * @return WP_Http
 */
function iwitness_http_get_object()
{
    static $http;

    if (is_null($http)) {
        $http = new WP_Http();
    }
    return $http;
}

/**
 * @param int $val
 * @return int
 */
function custom_request_timeout($val = 5)
{
    return max($val, 15);
}
