<?php
/**
 * HttpRequest contains members to retrive user request parameters.
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
class HttpRequest
{
	public static $Current;
	
	public $Application;
	public $Path;
	public $Form;
	
	public $RequestExtension;
	
	public function __construct()
	{
		$this->Form =& $_POST;	
		if (strlen($_REQUEST["Path"]) !== 0)
		{
			$this->Path = $_REQUEST['Path'];
			
			if (strpos($this->Path, ".") !== false)
			{
				$this->RequestExtension = substr($this->Path, strpos($this->Path, ".") + 1);
			}
		}
		else
		{
			$this->Path = "index.html.php";
			$this->RequestExtension = "html.php";
		}
		
		self::$Current =& $this;
	}
	
	//Public Methods
	public function SetForm($Key, $Value)
	{
		$this->Form[$Key] = $Value;
	}
	public function GetForm($Key, $DefaultValue)
	{
		if (!isset($this->Form[$Key]))
		{
			return $DefaultValue;
		}
		else
		{
			return $this->Form[$Key];
		}
	}

	private $Url;
	public function Url()
	{
		if ($this->Url === null)
		{
			$this->Url = HttpServerUtility::$Current->ResolveUrl("~/" . $this->Path);
		}
		return $this->Url;
	}
}