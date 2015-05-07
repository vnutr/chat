<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get double md5 with salt
 * @return string
 */
function get_double_hash($password)
{
    $ci = &get_instance();
    return md5(md5($password) . $ci->config->item('encryption_key'));;
}