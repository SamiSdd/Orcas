<?php
/**
 * System is utility to handler internal task
 *
 * Orcas
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @link		http://orcas.sdd.me.uk
 * @author		Abdul Sami Siddiqui - http://sdd.me.uk - sami@sdd.me.uk
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package		Utility
 */
class System
{
	public static function GetContent($Path)
	{
		if (!file_exists($Path))
		{
			System::LogError("{$Path} Not found");
		}
		$file = file_get_contents($Path);
		return $file;
	}
	public static function LogError($ErrorStr)
	{
		var_dump(debug_backtrace());
		die($ErrorStr);
	}
}