<?php
/**
 * ListBox Control
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
class ListBox extends ListControl
{
	//Propertise
	public function Rows($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("Rows", 4);
		}
		else
		{
			$this->SetProperty("Rows", $v);
		}
	}
	
	//Control Events
	public function Render()
	{
		parent::Render();
		$this->Node->self_close = false;
		$this->Node->setTag("select", true);
		
		if ($this->SelectionMode() == self::$ListSelectionMode_Multiple)
		{
			$this->Node->addAttribute("multiple", "multiple");
			$this->Node->addAttribute("name", $this->UniqueID . "[]");
		}
		else
		{
			$this->Node->addAttribute("name", $this->UniqueID);
		}
		$this->Node->addAttribute("size", $this->Rows());
		
		$OptionsMarkup	= "";
		$Selected		= $this->SelectedValue();
	
		if (is_string($Selected))
		{
			$Selected = array($Selected);
		}
		foreach($this->Items as $Key => $Value)
		{
			if (!$Value->Enabled())
			{
				continue;
			}
		
			$OptionsMarkup .= "<option value='{$Key}'" . (in_array($Key, $Selected) ? " selected='selected'" : "") . ">{$Value->Text()}</option>";
		}
	
		$this->Node->setInnerText($OptionsMarkup);
	
	}
}
