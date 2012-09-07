<?php
/**
 * Parser is utility for parsing directive and attributes so far.
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
class Parser 
{
	public static function ParseAttributes($Str, &$Success = false)
	{
		preg_match_all('#([a-z0-9]*)=["\'](.*?)["\']#is', $Str, $Matches);
	
		$Attributes = array();
	
		foreach($Matches[1] as $Index => $Element)
		{
			$Attributes[$Element] = $Matches[2][$Index];
		}
		return $Attributes;
	}
	public static function ParseDirective($DirectiveType, &$Content)
	{
		$Directives = array();
		preg_match_all('#<%@ ' . $DirectiveType . ' (.*?)%>#is', $Content, $Matches);
		$Content = preg_replace('#<%@ ' . $DirectiveType . ' (.*?)%>#is', "", $Content);
		foreach($Matches[1] as $AttributesStr)
		{
			$Directives = array_merge($Directives, self::ParseAttributes($AttributesStr));
		}
	
		return $Directives;
	}
}