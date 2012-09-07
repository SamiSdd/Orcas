<?php
/**
 * Master Page is base class for all Master Pages.
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
class MasterPage extends UserControl
{
	//Propertise
	public $MasterPageFile;
	public $Master;
	public $ContentTemplates = array();
	public $ContentPlaceHolders = array();
	
	//Methods
	public function AddContentTemplate($ID, &$Control)
	{
		$this->ContentTemplates[] =& $Control;
	}
	
	public function &FindControlByUniqueID($UniqueID)
	{
		$ControlsList = explode("$", $UniqueID);
	
		$Container = null;
		$ContainerID = array_shift($ControlsList);
		$ContainerID = array_shift($ControlsList);
	
		if (isset($this->Controls[$ContainerID]))
		{
			$Container = $this->Controls[$ContainerID];
				
			foreach($ControlsList as $ControlID)
			{
				$Container = $Container->Controls[$ControlID];
			}
				
			return $Container;
		}
		else if ($this->Master !== null)
		{
			return $this->Master->FindControlByUniqueID($UniqueID);
		}
	}
	
	
	//Control Events
	public function LoadViewState()
	{
		if ($this->Master !== null)
		{
			$this->Master->LoadViewState();
		}
		parent::LoadViewState();
	}
	public function CreateChildControls()
	{
		if ($this->Master !== null)
		{
			$this->Master->CreateChildControls();
		}
		parent::CreateChildControls();
	}
	
	public function AddedControl($ID, &$Control)
	{
		if($Control instanceof ContentPlaceHolder)
		{
			$this->ContentPlaceHolders[$ID] =& $Control;
		}
		else if ($this->Master !== null && $Control instanceof Content)
		{
			$this->Master->AddContentTemplate($ID, $Control);
		}
	}
	public function Init()
	{
		$this->InitChildren();
		
		if ($this->Master !== null)
		{
			$this->Master->Init();
		}
	}
	public function Load()
	{
		parent::Load();
		if ($this->Master !== null)
		{
			$this->Master->Load();
		}
	}
	public function LoadComplete()
	{
		parent::LoadComplete();
		if ($this->Master !== null)
		{
			$this->Master->LoadComplete();
		}
	}
	public function PreRender()
	{
		parent::PreRender();
		foreach($this->ContentTemplates as &$ContentTemplate)
		{
			$PlaceHolderID = $ContentTemplate->ContentPlaceHolderID();
			
			if(isset($this->ContentPlaceHolders[$PlaceHolderID]))
			{
				$this->ContentPlaceHolders[$PlaceHolderID]->ContentTemplate = $ContentTemplate;
			}
			unset($ContentTemplate);
		}
		
		if ($this->Master !== null)
		{
			$this->Master->PreRender();
		}
		
	}
	public function Render()
	{
		parent::Render();
		if ($this->Master === null)
		{
			return $this->Document->__toString();
		}
		else
		{
			return $this->Master->Render();
		}
	}
	
	//Static
	public static $MasterCount = 1;
	public static function &CreateMasterPage($MasterPageTemplate)
	{
		$Template = System::GetContent($MasterPageTemplate);
		$Directives = Parser::ParseDirective("Master", $Template);
		
		if (!isset($Directives["Inherits"]))
		{
			System::LogError("Master page must requires a Inherits Directive.");
		}
		
		$Activator = new ReflectionClass($Directives["Inherits"]);
		$Instance = $Activator->newInstanceArgs();
		
		$Instance->ID = "m" . self::$MasterCount;
		$Instance->UniqueID = "m" . self::$MasterCount;
		$Instance->ClientID = "m" . self::$MasterCount;
		
		$Instance->LoadTemplate($Template);
		
		self::$MasterCount++;
		
		if (isset($Directives["MasterPageFile"]))
		{
			$SubPageMasterFile = HttpServerUtility::$Current->MapPath($Directives["MasterPageFile"]);
			$SubMasterPage = self::CreateMasterPage($SubPageMasterFile);
			$Instance->Master =& $SubMasterPage;
			
			unset($SubMasterPage);
		}
		
		return $Instance;
	}
}