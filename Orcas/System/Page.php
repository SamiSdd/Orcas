<?php
/**
 * Page is base class for all pages
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
class Page extends TemplateControl
{
	public static $Current;
	
	//Propertise
	public $IsPostBack;
	public $ClientScript;
	public $Form;
	public $MasterPageFile;
	public $Master;
	
	public $Title;
	
	public function __construct()
	{
		self::$Current =& $this;
		
		parent::__construct();
		
		$this->IsPostBack = (count($this->Request->Form) > 0);
		$this->ClientScript = new ClientScriptManager();
	}
	
	//Page Event Cycle
	public function PreInit()
	{
		$this->ClientScript->RegisterHiddenField("__EVENTTARGET", "");
		$this->ClientScript->RegisterHiddenField("__EVENTARGUMENT", "");
		
		if ($this->Master !== $this->MasterPageFile)
		{
			$this->Master = MasterPage::CreateMasterPage($this->MasterPageFile);
		}
		
		
		$this->LoadViewState();
		$this->CreateChildControls();
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
		
		if ($this->IsPostBack &&
			isset($this->Request->Form["__EVENTTARGET"]))
		{
			$EventTarget = $this->Request->Form["__EVENTTARGET"];
			$EventArgument = $this->Request->Form["__EVENTARGUMENT"];
			if (!empty($EventTarget))
			{
				$Control = $this->FindControlByUniqueID($EventTarget);
				
				if ($Control instanceof IPostBackEventHandler)
				{
					$Control->RaisePostBackEvent($EventArgument);
				}
			}
		}
	}
	public function PreRender()
	{
		parent::PreRender();
		
		$ViewState = array_filter($this->ViewState);
		$ViewState = base64_encode(gzcompress(serialize($ViewState)));
		$this->ClientScript->RegisterHiddenField("__VIEWSTATE", $ViewState);
		
		$this->PreRenderChildren();
		
		if ($this->Master !== null)
		{
			$this->Master->PreRender();
		}
	}
	public function RenderControl()
	{
		System::LogError("Render Control cannot be called on Page");
	}
	public function Render()
	{
		$ScriptManager = ScriptManager::GetCurrent();
		
		if ($ScriptManager === null || $ScriptManager->IsInAsyncPostBack !== true)
		{
			$this->RenderChildren();
			if ($this->Master === null)
			{
				$Markup = $this->Document->__toString();
			}
			else
			{
				$Markup = $this->Master->Render();
			}
			
			$this->Response->Write(System::EvalPHP($Markup));
		}
		else
		{
			$Response = (object)array(
				"HiddenFields" => $this->Page->ClientScript->HiddenFields,
				"UpdatePanels"	=> array()
			);
			foreach($ScriptManager->UpdatePanelsUpdated as $UpdatePanelID)
			{
				$UpdatePanel =& $this->FindControlByUniqueID($UpdatePanelID);
				if ($UpdatePanel !== null)
				{
					$UpdatePanel->Render();
					$Response->UpdatePanels[$UpdatePanel->ClientID] = System::EvalPHP($UpdatePanel->Node->getInnerText());
				}
				unset($UpdatePanel);
			}
			ob_end_clean();
			$this->Response->ContentType("application/json");
			$this->Response->Write(json_encode($Response));
		}
	}
	
	//Internal Methods
	protected function AddedControl($Key, &$Control)
	{
		if ($this->Master !== null && $Control instanceof Content)
		{
			$this->Master->AddContentTemplate($Key, $Control);
		}
	}
	protected function LoadViewState()
	{
		if (isset($this->Request->Form["__VIEWSTATE"]))
		{
			$ViewState = $this->Request->Form['__VIEWSTATE'];
			$ViewState = base64_decode($ViewState);
			$ViewState = gzuncompress($ViewState);
			$this->ViewState = unserialize($ViewState);
		}
		
		if ($this->Master !== null)
		{
			$this->Master->LoadViewState();
		}
	}
	public function CreateChildControls()
	{
		if ($this->Master !== null)
		{
			$this->Master->CreateChildControls();
		}
		parent::CreateChildControls();
	}
	
	//Methods
	public function ProcessDirective($Directives)
	{
		if (isset($Directives["MasterPageFile"]))
		{
			$this->MasterPageFile = $this->Server->MapPath($Directives["MasterPageFile"]);
		}
		
		if (isset($Directives["Title"]))
		{
			$this->Title = $Directives["Title"];
		}
	}
	public function &FindControlByUniqueID($UniqueID)
	{
		$ControlsList = explode("$", $UniqueID);
		
		$Container = null;
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
}