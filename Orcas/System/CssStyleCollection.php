<?php
/**
 * CssStyleCollection is Stylesheet property collection.
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
class CssStyleCollection
{
	public $Modified = false;
	public $Page;
	
	public $Items = array();
	public function __construct($Style, &$Page)
	{
		$this->Page =& $Page;
		
		if (is_string($Style))
		{
			$Style = array_filter(explode(";", $Style));
			foreach($Style as $StyleItem)
			{
				$StylePair = explode(":", $StyleItem);
				$this->Items[trim($StylePair[0])] = trim($StylePair[1]);
			}
		}
	}

	public function Add($Key, $Value)
	{
		$this->Modified = true;
		$this->Items[$Key] = $Value;
	}
	public function Remove($Key)
	{
		$this->Modified = true;
		if (isset($this->Items[$Key]))
		{
			unset($this->Items[$Key]);
		}
	}
	public function ToString()
	{
		$CssStr = "";
		foreach($this->Items as $Key => $Value)
		{
			$CssStr .= "{$Key}:{$Value};";
		}
		return $CssStr;
	}
}