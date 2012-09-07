<?php
/**
 * DropDownList Control
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
class DropDownList extends ListControl
{
	//Control Events
	public function Init()
	{
		parent::Init();
		$this->SetAttribute("SelectionMode", ListControl::$ListSelectionMode_Single);
	}
	public function Render()
	{
		parent::Render();
		$this->Node->self_close = false;
		$this->Node->setTag("select", true);
		$this->Node->addAttribute("name", $this->UniqueID);
		
		$OptionsMarkup	= "";
		$Selected		= $this->SelectedValue();
		
		foreach($this->Items as $Key => $Value)
		{
			if (!$Value->Enabled())
			{
				continue;
			}
			
			$OptionsMarkup .= "<option value='{$Key}'" . ($Selected == $Key ? " selected='selected'" : "") . ">{$Value->Text()}</option>";
		}
		
		$this->Node->setInnerText($OptionsMarkup);
		
	}
}
