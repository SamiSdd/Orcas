<?php
/**
 * UpdatePanel Control
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
class UpdatePanel extends WebControl
{
	public function PreRender()
	{
		parent::PreRender();
		
		$this->Page->ClientScript->RegisterStartupScript($this->UniqueID, "System.RegisterUpdatePanel('{$this->UniqueID}');");
	}
	
	public function Render()
	{
		parent::Render();
		$this->Node->self_close = false;
		$this->Node->setTag("div", true);
	}
	
	
	public function Update()
	{
		ScriptManager::GetCurrent()->UpdatePanelsUpdated[] = $this->UniqueID;
	}
}