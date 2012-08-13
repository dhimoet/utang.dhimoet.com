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
	return date_format(date_create($timestamp), 'M d, Y \a\t H:i');
}

/* Location: application/helpers/customphp.php */ 
