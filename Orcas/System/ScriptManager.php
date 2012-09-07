<?php
/**
 * Script Manager is control that include Javascript to support UpdatePanel and other ajax based 
 * features
 *
 * Orcas
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @link		http://orcas.sdd.me.uk
 * @author		Abdul Sami Siddiqui - http://sdd.me.uk - sami@sdd.me.uk
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package		Control
 */
class ScriptManager extends Control
{
	public $IsInAsyncPostBack = false;
	public $UpdatePanelsUpdated = array();
	
	public function __construct()
	{
		parent::__construct();
		self::$Current =& $this;
	}
	public function Init()
	{
		$UpdatePanelCalled = $this->Request->GetForm($this->UniqueID, null);
		if ($UpdatePanelCalled !== null)
		{
			$this->IsInAsyncPostBack = true;
			$this->UpdatePanelsUpdated[] = $UpdatePanelCalled;
		}
		$this->Page->ClientScript->RegisterClientScriptBlock($this->UniqueID . "_Register", "System.ScriptManagerID = '{$this->UniqueID}';");
		$this->Page->ClientScript->RegisterClientScriptInclude("jquery", AssemblyResourceLoader::GeneratePath("Script/jquery-1.8.0.min.js"));
		$this->Page->ClientScript->RegisterClientScriptInclude("orcas", AssemblyResourceLoader::GeneratePath("Script/System.js"));
	}
	public function Render()
	{
		$this->Node->setOuterText("");
	}
	
	
	private static $Current;
	public static function GetCurrent()
	{
		return self::$Current;
	}
}