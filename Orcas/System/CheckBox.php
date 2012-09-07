<?php
/**
 * CheckBox Control
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
class CheckBox extends WebControl implements IPostBackEventHandler
{
	//Enums
	public static $Layout_Before = "Before";
	public static $Layout_After = "After";
	
	//Events
	public function CheckChanged($v = null)
	{
		if ($v === null)
		{
			return $this->GetPropertyByKeys("OnCheckChanged", "CheckChanged", null);
		}
		else
		{
			$this->SetProperty("CheckChanged", $v);
		}
	}
	
	//Propertise
	public function AutoPostBack($v = null)
	{
		if ($v === null)
		{
			$Value = $this->GetProperty("AutoPostBack", false);
			if (is_string($Value))
			{
				$Value = (strtolower($Value) == "true");
			}
			return $Value;
		}
		else
		{
			$this->SetProperty("AutoPostBack", $v);
		}
	}
	public function Layout($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("Layout", self::$Layout_After);
		}
		else
		{
			$this->SetProperty("Layout", $v);
		}
	}
	public function Checked($v = null)
	{
		if ($v === null)
		{
			
			$Value = $this->LoadForm($this->UniqueID, "Checked", null);
			if (!is_null($Value))
			{
				$Value = (strtolower($Value) == "true" ? "on" : $Value);
			}
			
			return ($Value == "on" ? true: false);
		}
		else
		{
			$this->Page->Request->SetForm($this->UniqueID, ($v ? "on" : ""));
		}
	}
	public function Text($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("Text", "");
		}
		else
		{
			$this->SetProperty("Text", $v);
		}
	}
	
	//Control Events
	public function Render()
	{
		parent::Render();
		
		$this->Node->self_close = true;
		$this->Node->setTag("input", true);
		$this->Node->addAttribute('type', "checkbox");
		$this->Node->addAttribute('name', $this->UniqueID);
		
		if ($this->AutoPostBack() && $this->CheckChanged() !== null)
		{
			
			$this->Node->addAttribute('onclick', "javascript:setTimeout(function(){ __doPostBack('{$this->UniqueID}','')}, 0)");
		}
		
		if ($this->Checked())
		{
			$this->Node->addAttribute('checked', 'checked');
		}
		$Text = $this->Text();
		
		if (!empty($Text))
		{
			$Html	= $this->Node->getOuterText();
			$Label	= "<label for='{$this->ClientID}'>{$Text}</label>";
			$this->Node->setOuterText("<div>" . ($this->Layout() == self::$Layout_Before ? $Label . $Html : $Html . $Label) . "</div>");
		}
	}

	public function RaisePostBackEvent($EventArgument)
	{
		$CheckChangedEvent = $this->CheckChanged();
		if (!empty($CheckChangedEvent))
		{
			$this->TemplateControl->$CheckChangedEvent($this, array());
		}
	}
}