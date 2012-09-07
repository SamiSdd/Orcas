<?php
/**
 * TextBox Control
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
class TextBox extends WebControl
{
	//Enums
	public static $TextMode_SingleLine	= "SingleLine";
	public static $TextMode_MultiLine	= "MultiLine";
	public static $TextMode_Password		= "Password";
	
	//Propertise
	public function TextMode($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("TextMode", self::$TextMode_SingleLine);
		}
		else
		{
			$this->SetProperty("TextMode", $v);
		}
	}
	public function Text($v = null)
	{
		if ($v === null)
		{
			return $this->LoadForm($this->UniqueID, "Text", "");
			$Text = $this->Page->Request->GetForm($this->UniqueID, null);
			if (is_null($Text)) $Text = $this->GetAttribute("Text", "");
			return $Text;
		}
		else
		{
			$this->Page->Request->SetForm($this->UniqueID, $v);
		}
	}
	
	//Control Events
	public function Render()
	{
		parent::Render();
		$this->Node->addAttribute("name", $this->UniqueID);
		switch ($this->TextMode()) 
		{
			case self::$TextMode_MultiLine:
				$this->Node->self_close = false;
				$this->Node->setTag("textarea", true);
				$this->Node->setInnerText($this->Text());
			break;
			default:
				$this->Node->self_close = true;
				$this->Node->setTag("input", true);
				
				if ($this->TextMode() == self::$TextMode_Password)
				{
					$this->Node->addAttribute("type", "password");
				}
				else
				{
					$this->Node->addAttribute("type", "text");
				}
				$this->Node->addAttribute('value', $this->Text());
			break;
		}
		
		
	}
}