<?php
/**
 * HttpContext load all configration, controls, handler so application can further process
 * the request.
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
class HttpContext
{
	public static $Current;
	
	public $Response;
	public $Request;
	public $Application;
	public $Server;
	
	//Server Configration
	public $BasePath;
	public $CorePath;
	public $UserPath;
	public $BaseDirname;
	
	//Objects Registrations
	public $RegisteredHandlers = array();
	public $RegisteredControls	= array();
	
	public function __construct()
	{
		if (self::$Current === null)
		{
			self::$Current =& $this;
		}
		else
		{
			System::LogError("Cannot Create Multiple Context at a Time");
		}
	}
	
	public function ProcessRequest()
	{
		//Define Directories
		$this->BasePath		= dirname(dirname(dirname(__FILE__)));
		$this->CorePath		= dirname(dirname(__FILE__));
		$this->UserPath		= $this->BasePath;
		$this->BaseDirname	= $this->GetBaseDirname();
		
		//Load Core Files
		$this->LoadModules();
		
		//Create Basic Required Objects
		$this->Request = new HttpRequest();
		$this->Response = new HttpResponse();
		$this->Application = new Application();
		$this->Server = new HttpServerUtility();
		
		//Load Default Configtion
		$this->LoadDefaultConfigration();
		
		//Load Custom User Configration
		$this->LoadConfigration();
		
		
		$this->Application->Init();
		$this->Application->BeginRequest();
		$this->Application->EndRequest();
	}
	
	private function LoadConfigration()
	{
		$ConfigrationFile = $this->UserPath . "/Web.config.xml";
		if (file_exists($ConfigrationFile))
		{
			$Xml = simplexml_load_file($ConfigrationFile);
			$HttpHandlers = $Xml->xpath('/configuration/system.web/httpHandlers/add');
			
			foreach($HttpHandlers as $Item)
			{
				$Attributes = $Item->attributes();
				$this->RegisterHandler((string)$Attributes['extension'], (string)$Attributes['type']);
			}
			
			unset($HttpHandlers);
			
			$Controls = $Xml->xpath('/configuration/system.web/pages/controls/add');
			foreach($Controls as $Item)
			{
				$Attributes = $Item->attributes();
				$this->RegisterControl((string)$Attributes['tagPrefix'], (string)$Attributes['tagName'], (string)$Attributes['type'], (string)$Attributes['src']);
			}
			
			unset($Controls);
			
			unset($Xml);
		}
	}
	private function LoadModules()
	{
		$Sequence = array("Modules" => true);
		foreach($Sequence as $Folder => $Recursive)
		{
			$this->LoadFiles($this->CorePath . "/" . $Folder, $Recursive);
		}
	}
	private function LoadFiles($Path, $Recursive = false, $Inclusive = array(".php"), $Exclusive = array(".html.php"))
	{
		$Dir = new DirectoryIterator($Path);
		foreach($Dir as $Item)
		{
			$Pathname = $Item->getPathname();
				
			if ($Item->isFile())
			{
				$Extension = substr($Pathname, strpos($Pathname, "."));
				if (in_array($Extension, $Inclusive) && !in_array($Extension, $Exclusive))
				{
					require_once $Pathname;
				}
	
			}
			else if (!$Item->isDot() && $Item->isDir() && $Recursive)
			{
				$this->LoadFiles($Pathname, true, $Inclusive, $Exclusive);
			}
		}
	}
	private function GetBaseDirname()
	{
		$BasePathInfo = pathinfo(dirname(dirname($_SERVER['PHP_SELF'])));
		$BaseDirname = (isset($BasePathInfo['dirname']) ? $BasePathInfo['dirname'] : "");
		
		if (substr($BaseDirname, strlen($BaseDirname) - 1) == "/")
		{
			$BaseDirname = substr($BaseDirname, 0, strlen($BaseDirname) - 1);
		}
		return $BaseDirname;
	}

	public function RegisterControl($TagPrefix, $TagName, $ClassName, $TemplateFile = null)
	{
		$Register = array(
				"TagPrefix"	=> $TagPrefix,
				"TagName"	=> $TagName,
				"Class"		=> $ClassName
		);
		if (!empty($TemplateFile))
		{
			$Template = System::GetContent($this->Server->MapPath($TemplateFile));
			$Directive = Parser::ParseDirective("Control", $Template);
			
			$Register["Template"]	= $Template;
			$Register["Directive"]	= $Directive;
			
			if (isset($Directive["Inherits"]))
			{
				$Register["Class"] = $Directive["Inherits"];
			}
		}
		
		$this->RegisteredControls["{$TagPrefix}:{$TagName}"] = (object)$Register;
	}
	public function RegisterHandler($Extension, $HandlerName)
	{
		$this->RegisteredHandlers[$Extension] = $HandlerName;
	}

	public function LoadDefaultConfigration()
	{
		$this->RegisterHandler("html.php", "PageHandler");
		$this->RegisterHandler("php", "PageHandler");
		$this->RegisterHandler("phpx", "PageHandler");
		$this->RegisterHandler("res.php", "AssemblyResourceLoader");
		
		$this->RegisterControl("php", "Button", "Button");
		$this->RegisterControl("php", "CheckBox", "CheckBox");
		$this->RegisterControl("php", "CheckBoxList", "CheckBoxList");
		$this->RegisterControl("php", "DropDownList", "DropDownList");
		$this->RegisterControl("php", "Form", "Form");
		$this->RegisterControl("php", "Label", "Label");
		$this->RegisterControl("php", "ListBox", "ListBox");
		$this->RegisterControl("php", "Panel", "Panel");
		$this->RegisterControl("php", "TextBox", "TextBox");
		$this->RegisterControl("php", "LinkButton", "LinkButton");
		$this->RegisterControl("php", "Image", "Image");
		$this->RegisterControl("php", "ScriptManager", "ScriptManager");
		$this->RegisterControl("php", "UpdatePanel", "UpdatePanel");
		
		$this->RegisterControl("php", "ContentPlaceHolder", "ContentPlaceHolder");
		$this->RegisterControl("php", "Content", "Content");
	}
}