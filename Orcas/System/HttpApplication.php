<?php
/**
 * Primary Application Object Handle User request can be derived in Application Class to extend
 * or change default functionality.
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
class HttpApplication
{
	public static $Current;
	
	public $CompletedRequest = false;
	
	public $Request;
	public $Context;
	public $Response;
	
	public function __construct()
	{
		self::$Current = &$this;
	}
	
	//Application Life Cycle
	public function Init()
	{
		$this->Context	= HttpContext::$Current;
		$this->Response	= $this->Context->Response;
		$this->Request	= $this->Context->Request;
	}
	public function BeginRequest()
	{
		$FilePath = $this->Context->UserPath . "/" . $this->Request->Path;
		if (isset($this->Context->RegisteredHandlers[$this->Request->RequestExtension]))
		{
			$Activator = new ReflectionClass($this->Context->RegisteredHandlers[$this->Request->RequestExtension]);
			$Handler = $Activator->newInstanceArgs();
			$Handler->ProcessRequest($this->Context, $this->Request->RequestExtension);
		}
		else
		{
			if (file_exists($FilePath))
			{
				$this->Response->AddHeader("Cache-Control", "maxage=15768000");
				$this->Response->AddHeader("Pragma", "public");
				$this->Response->AddHeader("Expires", gmdate('D, d M Y H:i:s', (strtotime("+1 year"))) . ' GMT');
					
				$this->Response->TransmitFile($FilePath);
				exit;
			}
			else
			{
				header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
				echo "404";
				exit();
			}
		}
	}
	public function EndRequest()
	{
	}
}