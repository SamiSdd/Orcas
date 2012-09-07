<?php
/**
 * WebControl is base for all controls which have a User interface in HTML
 *
 * Orcas
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @link		http://orcas.sdd.me.uk
 * @author		Abdul Sami Siddiqui - http://sdd.me.uk - sami@sdd.me.uk
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package		System
 */
class WebControl extends Control
{
	//Propertise
	public function AccessKey($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("AccessKey", "");
		}
		else
		{
			$this->SetProperty("AccessKey", $v);
		}
	}
	public function CssClass($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("CssClass", "");
		}
		else
		{
			$this->SetProperty("CssClass", $v);
		}
	}
	
	public function Height($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("Height", "");
		}
		else
		{
			$this->SetProperty("Height", $v);
		}
	}
	public function Width($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("Width", "");
		}
		else
		{
			$this->SetProperty("Width", $v);
		}
	}
	public function Tooltip($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("Tooltip", "");
		}
		else
		{
			$this->SetProperty("Tooltip", $v);
		}
	}
	public function BackColor($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("BackColor", "");
		}
		else
		{
			$this->SetProperty("BackColor", $v);
		}
	}
	public function ForeColor($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("ForeColor", "");
		}
		else
		{
			$this->SetProperty("ForeColor", $v);
		}
	}
	public function BorderColor($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("BorderColor", "");
		}
		else
		{
			$this->SetProperty("BorderColor", $v);
		}
	}
	public function BorderStyle($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("BorderStyle", "");
		}
		else
		{
			$this->SetProperty("BorderStyle", $v);
		}
	}
	public function BorderWidth($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("BorderWidth", "");
		}
		else
		{
			$this->SetProperty("BorderWidth", $v);
		}
	}
	
	
	public $Style;
	public function Style()
	{
		if ($this->Style === null)
		{
			System::LogError("Css Style Collection not Initialized.");
		}
		else
		{
			return $this->Style;
		}
	}
	
	
	//Methods
	public function RenderAttributes()
	{
		$this->Node->addAttribute('id', $this->ClientID);
		
		$CssClass = $this->CssClass();
		if (strlen($CssClass) != 0)
		{
			$this->Node->addAttribute('class', $CssClass);
		}
		
		$AccessKey = $this->AccessKey();
		if (strlen($AccessKey) != 0)
		{
			$this->Node->addAttribute('accesskey', $AccessKey);
		}
		
		
		
		$Tooltip = $this->GetProperty("Tooltip", null);
		if ($Tooltip !== null)
		{
			$this->Node->addAttribute('title', $Tooltip);
		}
		
		
		//Render Internal Styles
		$Height = $this->GetProperty("Height", null);
		if ($Height !== null) $this->Style->Items['height'] = $Height;
		
		$Width = $this->GetProperty("Width", null);
		if ($Width !== null) $this->Style->Items['width'] = $Width;
		
		$BackColor = $this->GetProperty("BackColor", null);
		if ($BackColor !== null) $this->Style->Items['background-color'] = $BackColor;
		
		$ForeColor = $this->GetProperty("ForeColor", null);
		if ($ForeColor !== null) $this->Style->Items['color'] = $ForeColor;
		
		$BorderColor = $this->GetProperty("BorderColor", null);
		if ($BorderColor !== null) $this->Style->Items['border-color'] =  $BorderColor;
		
		$BorderStyle = $this->GetProperty("BorderStyle", null);
		if ($BorderStyle !== null) $this->Style->Items['border-style'] =  $BorderStyle;
		
		$BorderWidth = $this->GetProperty("BorderWidth", null);
		if ($BorderWidth !== null) $this->Style->Items['border-width'] =  $BorderWidth;
		
		$Style = $this->Style->ToString();
		if (strlen($Style) != 0)
		{
			$this->Node->addAttribute('style', $Style);
		}
		
		
	}
	
	//Control Events
	public function Init()
	{
		parent::Init();
		
		$Style = $this->LoadState("StyleCollection", null);
		if ($Style === null)
		{
			$Style = $this->GetAttribute("Style", "");
		}
		
		$Style = new CssStyleCollection($Style, $this);
		$this->Style =& $Style;
	}
	public function PreRender()
	{
		parent::PreRender();
		if ($this->Style->Modified)
		{
			$this->SaveState("StyleCollection", $this->Style->ToString());
		}
	}
	public function Render()
	{
		parent::Render();
		$this->RenderAttributes();
	}
}