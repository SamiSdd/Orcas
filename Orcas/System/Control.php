<?php
/**
 * Control is very basic entity of orcas from which mostly everything derive it contain basic 
 * set of propertise and functions which mostly every control entity will use in orcas
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
class Control
{
	public $Context;
	public $Request;
	public $Response;
	public $Application;
	public $Page;
	public $Server;
	
	public $Node;
	
	public $Attributes	= array();
	
	public $ID;
	public $UniqueID;
	public $ClientID;
	public $Parent;
	public static $ClientIDSeparator = "_";
	public static $IdSeparator = "$";
	
	public $ViewState = array();
	public $Controls = array();
	
	public $TemplateControl;
	
	public function __construct()
	{
		$this->Context		=& HttpContext::$Current;
		$this->Application	=& $this->Context->Application;
		$this->Request		=& $this->Context->Request;
		$this->Server		=& $this->Context->Server;
		$this->Response		=& $this->Context->Response;
		
		$this->Page			=& Page::$Current;
	}
	
	//Propertise
	public function Visible($v = null)
	{
		if ($v === null)
		{
			$Visible = $this->GetProperty("Visible", true);
			if (is_string($Visible))
			{
				$Visible = $Visible == "true";
			}
			return $Visible;
		}
		else
		{
			$this->SetProperty("Visible", (bool)$v);
		}
	}
	
	//Internal Methods
	protected function LoadViewState()
	{
		if ($this->Parent !== null)
		{
			if (!isset($this->Parent->ViewState[$this->ID]))
			{
				$this->Parent->ViewState[$this->ID] = array();
			}
			$this->ViewState =& $this->Parent->ViewState[$this->ID];
		}
		else
		{
			if (!isset($this->Page->ViewState[$this->ID]))
			{
				$this->Page->ViewState[$this->ID] = array();
			}
			$this->ViewState =& $this->Page->ViewState[$this->ID];
		}
	}
	protected function SaveViewState()
	{
	}
	protected function CreateChildControls()
	{
	}
	protected function InitChildren()
	{
		foreach($this->Controls as $Control)
		{
			$Control->Init();
		}
	}
	protected function LoadChildren()
	{
		foreach($this->Controls as $Control)
		{
			$Control->Load();
		}
	}
	protected function LoadCompleteChildren()
	{
		foreach($this->Controls as $Control)
		{
			$Control->LoadComplete();
		}
	}
	protected function PreRenderChildren()
	{
		foreach($this->Controls as $Control)
		{
			$Control->PreRender();
		}
	}
	protected function RenderChildren()
	{
		foreach($this->Controls as $Control)
		{
			$Control->Render();
		}
	}
	protected function AddedControl($Key, &$Control)
	{
	}
	
	//Control Event Cycle
	public function Init()
	{
		foreach($this->Node->attributes as $Attribute => $Value)
		{
			#$this->SetAttribute($Attribute, $Value);
			$this->Node->deleteAttribute($Attribute);
		}
		
		$this->LoadViewState();
		$this->CreateChildControls();
		$this->InitChildren();
	}
	public function Load()
	{
		$this->LoadChildren();
	}
	public function LoadComplete()
	{
		$this->LoadCompleteChildren();
	}
	public function PreRender()
	{
		$this->PreRenderChildren();
	}
	public function Render()
	{
		if ($this->Visible() !== false)
		{
			$this->RenderControl();
		}
		else if ($this->Node !== null)
		{
			$this->Node->setOuterText("");
		}
		
	}
	
	//Methods
	public function RenderControl()
	{
		$this->RenderChildren();
	}
	public function SetAttribute($Key, $Value)
	{
		$this->Attributes[$Key] = $Value;
	}
	public function GetAttribute($Key, $DefaultValue)
	{
		if (isset($this->Attributes[$Key]))
		{
			return $this->Attributes[$Key];
		}
		else
		{
			return $DefaultValue;
		}
	}
	public function SaveState($Key, $Value)
	{
		$this->ViewState[$Key] = $Value;
	}
	public function LoadState($Key, $DefaultValue)
	{
		if (isset($this->ViewState[$Key]))
		{
			return $this->ViewState[$Key];
		}
		else
		{
			return $DefaultValue;
		}
	}
	public function SetProperty($Key, $Value)
	{
		$this->SaveState($Key, $Value);
	}
	public function GetProperty($Key, $DefaultValue)
	{
		$Value = $this->LoadState($Key, null);
		if ($Value === null)
		{
			$Value = $this->GetAttribute($Key, $DefaultValue);
		}
		return $Value;
	}
	public function GetPropertyByKeys($AttributeKey, $StateKey, $DefaultValue)
	{
		$Value = $this->LoadState($StateKey, null);
		if ($Value === null)
		{
			$Value =  $this->GetAttribute($AttributeKey, $DefaultValue);
		}
		return $Value;
	}
	public function ResolveUrl($Url)
	{
		return $this->Server->ResolveUrl($Url);
	}
	
	public function LoadForm($FormKey, $AttributeKey, $DefaultValue)
	{
		$Value = null;
		if ($this->Page->IsPostBack)
		{
			$Value = $this->Page->Request->GetForm($FormKey, "");
		}
		if (is_null($Value)) $Value = $this->GetAttribute($AttributeKey, $DefaultValue);
		return $Value;
	}
	
	//Static Methods
	public static $ControlCount = 1;
	public static function CreateControl($DomNode, $TemplateControl)
	{
		$Context = HttpContext::$Current;
		
		if (!isset($Context->RegisteredControls[$DomNode->tag]))
		{
			System::LogError("{$DomNode->tag} is not registered.");
		}
		$ControlDirectative = $Context->RegisteredControls[$DomNode->tag];
		
		$ControlID = $DomNode->ID;
		if (empty($ControlID))
		{
			$ControlID = "ctl" . self::$ControlCount;
			self::$ControlCount++;
		}
		
		
		$Activator = new ReflectionClass($ControlDirectative->Class);
		$Instance = $Activator->newInstanceArgs(); 
		$Instance->ID = $ControlID;
		$Instance->Node =& $DomNode;
		$Instance->Node->ControlInstance =& $Instance;
		$Instance->TemplateControl =& $TemplateControl;
		
		
		//Add Parent From Previous Function
		$ParentInstance =& $Instance->Node->getParentsByAttribute("runat","server");
		if ($ParentInstance !== null)
		{
			$Instance->Parent =& $ParentInstance->ControlInstance;
		}
		
		if (!empty($ControlDirectative->Template))
		{
			$Instance->LoadTemplate($ControlDirectative->Template);
		}
		foreach($DomNode->attributes as $Attribute => $Value)
		{
			$Instance->SetAttribute($Attribute, $Value);
			#$DomNode->deleteAttribute($Attribute);
		}
		return $Instance;
	}
}