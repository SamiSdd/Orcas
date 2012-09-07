<?php
/**
 * Image Control
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
class Image extends WebControl
{
	public function AltText($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("AltText", "");
		}
		else
		{
			$this->SetProperty("AltText", $v);
		}
	}
	public function ImageUrl($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("ImageUrl", "");
		}
		else
		{
			$this->SetProperty("ImageUrl", $v);
		}
	}
	public function ImageAlign($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("ImageAlign", "");
		}
		else
		{
			$this->SetProperty("ImageAlign", $v);
		}
	}

	public function Render()
	{
		parent::Render();
		
		$this->Node->self_close = true;
		$this->Node->setTag("img", true);
		
		$AltText = $this->AltText();
		$ImageUrl = $this->ImageUrl();
		$ImageAlign = $this->ImageAlign();
		
		
		if (strlen($AltText) != 0)
		{
			$this->Node->addAttribute('alt', $AltText);
		}
		
		if (strlen($ImageUrl) != 0)
		{
			$this->Node->addAttribute('src', $this->ResolveUrl($ImageUrl));
		}
		
		if (strlen($ImageAlign) != 0)
		{
			$this->Node->addAttribute('align', $ImageAlign);
		}
		
	}
}