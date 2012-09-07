<?php
/**
 * LinkButton Control
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
class LinkButton extends WebControl implements IPostBackEventHandler
{
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
	
	public function Render()
	{
		parent::Render();
		$this->Node->self_close = false;
		$this->Node->setTag("a", true);
		
		$this->Node->addAttribute('href', "javascript:__doPostBack('{$this->UniqueID}', '');");
		$this->Node->addAttribute('name', $this->UniqueID);
		
		$Text = $this->Text();
		if (!empty($Text))
		{
			$this->Node->setInnerText($Text);
		}
	}
	
	public function RaisePostBackEvent($EventArgument)
	{
		$Method = $this->Clicked();
		
		if ($Method !== null && method_exists($this->TemplateControl, $Method))
		{
			$this->TemplateControl->$Method($this, array());
		}
	}
}