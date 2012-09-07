<?php
/**
 * Button Control
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
class Button extends WebControl implements IPostBackEventHandler
{
	//Propertise
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
	public function Clicked($v = null)
	{
		if ($v === null)
		{
			return $this->GetPropertyByKeys("OnClicked", "Clicked", null);
		}
		else
		{
			$this->SetProperty("Clicked", $v);
		}
	}
	
	//Control Events
	public function LoadComplete()
	{
		if ($this->Page->IsPostBack && 
			isset($this->Page->Request->Form[$this->UniqueID]))
		{
			$this->RaisePostBackEvent("");
		}
		
		parent::LoadComplete();
	}
	public function Render()
	{
		parent::Render();
		$this->Node->self_close = true;
		$this->Node->setTag("input", true);
		$this->Node->addAttribute('type', 'submit');
		$this->Node->addAttribute('name', $this->UniqueID);
	
		$Text = $this->Text();
		if (strlen($Text) != 0)
		{
			$this->Node->addAttribute('value', $Text);
		}
	}
	
	public function RaisePostBackEvent($EventArgument)
	{
		$Method = $this->Clicked();
		if ($Method !== null &&
			method_exists($this->TemplateControl, $Method))
		{
			$this->TemplateControl->$Method($this, array());
		}
	}
}