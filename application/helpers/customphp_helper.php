<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Custom PHP Helper
 */

function print_rf($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';    
}

function friendly_date($timestamp)
{
	return date_format(date_create($timestamp), 'M d, Y');
}

function friendly_date_time($timestamp)
{
	return date_format(date_create($timestamp), 'M d, Y \a\t g:i A');
}

/*** get time difference in minutes ***/
function get_age($time)
{
	$to_time = strtotime(date("Y-m-d H:i:s"));
	$from_time = strtotime($time);
	
	return (int)round(abs($to_time - $from_time) / 60);
}

/* Location: application/helpers/customphp.php */ 
