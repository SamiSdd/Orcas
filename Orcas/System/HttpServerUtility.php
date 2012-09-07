<?php
/**
 * HttpServerUtility allow user to retrieve server configration and file structure.
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
class HttpServerUtility
{
	public static $Current;
	
	public $Context;
	public function __construct()
	{
		self::$Current = &$this;
		
		$this->Context = HttpContext::$Current;
	}
	
	//Public Methods
	public function BaseUrl($Path)
	{
		if (strpos($Path, "/") === 0)
		{
			$Path = substr($Path, 1);
		}
	
		$Protocol	= "http";
		$Port		= $_SERVER['SERVER_PORT'];
		if ($Port == 443)
		{
			$Protocol = "https";
		}
		
		return $Protocol . "://" . $_SERVER['SERVER_NAME'] . ($Port == 80 || $Port == 443 ? "": ":" . $Port) . $this->Context->BaseDirname . "/" . $Path;
	}
	public function ResolveUrl($Url)
	{
		if (strpos($Url, "~/") === 0)
		{
			return $this->BaseUrl(substr($Url, 1));
		}
		else
		{
			return $Url;
		}
	}
	public function MapPath($Path)
	{
		if (strpos($Path, "~/") === 0)
		{
			return $this->Context->BasePath . substr($Path, 1);
		}
		else
		{
			return $Path;
		}
	}
}