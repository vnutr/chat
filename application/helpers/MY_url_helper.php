<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * refirect to any urls
 * @param $url
 */
function redirect_absolute($url, $http_response_code = 302)
{
	if(preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', $url))
    {
    	header("Location: ".$url, TRUE, $http_response_code);
    }
}

/**
 * Check to match current url
 * @param $url
 * @return bool
 */
function is_current_url($url)
{
    $ci = &get_instance();
    return "{$ci->router->class}/{$ci->router->method}" == $url;
}

/**
 * Site URL
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string
 * @return	string
 */
function site_url($uri = '', $is_short = FALSE)
{
    if(!$is_short)
    {
        $CI =& get_instance();
        return $CI->config->site_url($uri);
    }
    else
        return "/$uri";
}

function current_url()
{
    return "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}
