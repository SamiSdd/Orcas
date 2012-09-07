<?php
/**
 * CheckBoxList Control
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
class CheckBoxList extends ListControl
{
	//Enums
	public static $RepeatDirection_Vertical = "Vertical";
	public static $RepeatDirection_Horizontal = "Horizontal";
	
	//Propertise
	public function SelectionMode($v = null)
	{
		if ($v === null)
		{
			return ListControl::$ListSelectionMode_Multiple;
		}
	}
	public function RepeatColumns($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("RepeatColumns", 1);
		}
		else
		{
			$v = (int)$v;
			$this->SetProperty("RepeatColumns", ($v == 0 ? 1 : $v));
		}
	}
	public function RepeatDirection($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("RepeatDirection", self::$RepeatDirection_Vertical);
		}
		else
		{
			$this->SetProperty("RepeatDirection", $v);
		}
	}
	
	//Control Events
	public function Render()
	{
		$Selected		= $this->SelectedValue();
		if (is_string($Selected))
		{
			$Selected = array($Selected);
		}
		
		$ItemsCount = $this->Items->Count();
		
		if ($ItemsCount == 0)
		{
			$this->Node->setOuterText("<span></span>");
			return;
		}
		
		
		$ItemsMarkup	= array();
		$Columns		= (int)$this->RepeatColumns();
		$Rows			= (int)ceil($ItemsCount / $Columns);
		$ItemIndex		= 1;
		
		foreach($this->Items as $Item)
		{
			if ($this->RepeatDirection() == self::$RepeatDirection_Horizontal)
			{
				$RowIndex = (int)ceil($ItemIndex / $Columns);
			}
			else
			{
				$RowIndex = (int)ceil($ItemIndex % $Rows);
			}
			$ColIndex = (int)($Columns - ($RowIndex * $Columns - $ItemIndex));
			$RowIndex--;
			$ColIndex--;
			
			if (!isset($ItemsMarkup[$RowIndex]))
			{
				$ItemsMarkup[$RowIndex] = array();
			}
			$ItemsMarkup[$RowIndex][$ColIndex] = $this->RenderCheckBox($Item, in_array($Item->Value(), $Selected), $ItemIndex);
		
			$ItemIndex++;
		}
		
		$CssClass = $this->CssClass();
		
		$CheckBoxMarkups = "<table id='{$this->ClientID}' " . (!empty($CssClass) ? "class='{$CssClass}'": "" ) . ">";
		foreach($ItemsMarkup as $ItemsRow)
		{
			$CheckBoxMarkups .= "<tr>";
			foreach($ItemsRow as $ItemMarkup)
			{
				$CheckBoxMarkups .= "<td>{$ItemMarkup}</td>";
			}
			$CheckBoxMarkups .= "</tr>";
		}
		$CheckBoxMarkups .= "</table>";
		
		$this->Node->setOuterText($CheckBoxMarkups);
	}
	
	//Internal Methods
	protected function RenderCheckBox($Item, $Selected, $Index)
	{
		$Value = $Item->Value();
		$Text = $Item->Text();
		
		$ReturnStr = "<input type='checkbox' " . ($Selected ? " checked='checked'" : "") . " name='{$this->UniqueID}[]' id='{$this->ClientID}_{$Index}' value='{$Value}' /><label for='{$this->ClientID}_{$Index}'>{$Text}</label>";
		return $ReturnStr;
	}
}