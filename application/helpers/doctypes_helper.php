<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Doctypes
 *
 * Generates a doctype based on the strings passed to the function.
 * Defaults to xHTML Strict
 *
 * @access    public
 * @param    string
 * @return    string
 */

function doctype($doctype)
{
    $CI =& get_instance();
    $CI->config->load('doctypes');
    
    echo $CI->config->item($doctype);
    
} // doctype

/* End of file doctype_i.php */
/* Location: application/helpers/doctypes.php */ 