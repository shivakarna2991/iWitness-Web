<?php

/**
 * Log message into  write stream
 * @param $level
 * @param $message
 */
function iwitness_log($level, $message)
{
    if (IWITNESS_LOG === true && $level <= IWITNESS_LOG_LEVEL) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}

/**
 * @param $message
 */
function iwitness_log_error($message)
{
    if ($message instanceof \Exception) {
        iwitness_log(IWITNESS_LOG_LEVEL_ERROR, $message->getMessage());
    } else {
        iwitness_log(IWITNESS_LOG_LEVEL_ERROR, $message);
    }
}

/**
 * @param $message
 */
function iwitness_log_debug($message)
{
    iwitness_log(IWITNESS_LOG_LEVEL_DEBUG, $message);
}

/**
 * @param $message
 */
function iwitness_log_info($message)
{
    iwitness_log(IWITNESS_LOG_LEVEL_INFO, $message);
}


