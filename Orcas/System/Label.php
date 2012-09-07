<?php
/**
 * Label Control
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
class Label extends WebControl
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

	//Control Events
	public function Render()
	{
		parent::Render();
		
		$this->Node->self_close = false;
		$this->Node->setTag("span", true);
		$this->Node->setInnerText($this->Text());
	}
}


