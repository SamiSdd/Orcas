<?php
/**
 * Bootstrap - Boot file
 * All Request are passed through Bootstrap. Bootstrap Configure some earlier options.
 *
 * Orcas
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @link		http://orcas.sdd.me.uk
 * @author		Abdul Sami Siddiqui - http://sdd.me.uk - sami@sdd.me.uk
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package		System
 */
error_reporting(E_ALL);
session_start();
$include_path = array(dirname(__FILE__), dirname(dirname(dirname(__FILE__))), dirname(dirname(dirname(__FILE__))) . "/AppCode");
set_include_path(implode(PATH_SEPARATOR, $include_path));
spl_autoload_register( 'myAutoLoad' );
function myAutoLoad($class) 
{
	include $class . ".php";
}

$Context = new HttpContext();
$Context->ProcessRequest();

