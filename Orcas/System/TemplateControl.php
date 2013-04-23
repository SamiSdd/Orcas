<?php
/**
 * TemplateControl handle entity which have a seprate template file and markup
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
class TemplateControl extends Control
{
	//Propertise
	public $Template;
	public $Document;
	
	//Internal Methods
	protected function CreateChildControls()
	{
		if ($this->Document === null)
		{
			return;
		}
	
		
		foreach($this->Document->select("link[href]") as $Style)
		{
			$Style->href = $this->ResolveUrl($Style->href);
		}
	
		foreach($this->Document->select("script[src]") as $Script)
		{
			$Script->src = $this->ResolveUrl($Script->src);
		}
	
		$Controls = $this->Document->select("*[runat='server']");
		
		array_walk($Controls, function(&$Control, $Index, &$TemplateControl)
		{
			$Control = Control::CreateControl($Control, $TemplateControl);
		}, $this);
	
		
		if (count($Controls) === 0)
		{
			return;
		}
		
		for($i = 0; $i < count($Controls); $i++)
		{
			$ControlID = $Controls[$i]->ID;
			
			$this->$ControlID =& $Controls[$i];
			
			if ($Controls[$i]->Parent === null)
			{
				if ($Controls[$i] instanceof Content)
				{
					if (isset($this->Master->ContentPlaceHolders[$Controls[$i]->ContentPlaceHolderID()]))
					{
						$Controls[$i]->Parent =& $this->Master->ContentPlaceHolders[$Controls[$i]->ContentPlaceHolderID()];
					}
					else
					{
						$Controls[$i]->Parent =& $this;
					}
				}
				/*
				else if ($this instanceof MasterPage)
				{
					$Controls[$i]->Parent = null;
				}
				*/
				else if ($this instanceof UserControl)
				{
					$Controls[$i]->Parent =& $this;
				}
			}
			
			
			if ($Controls[$i]->Parent === null)
			{
				$this->Controls[$ControlID] =& $Controls[$i];
				
				$Controls[$i]->UniqueID = $ControlID;
				$Controls[$i]->ClientID = $ControlID;
			}
			else
			{
				$Controls[$i]->Parent->Controls[$ControlID] =& $Controls[$i];
				
				$Controls[$i]->UniqueID = $Controls[$i]->Parent->UniqueID . Control::$IdSeparator . $ControlID;
				$Controls[$i]->ClientID = $Controls[$i]->Parent->ClientID . Control::$ClientIDSeparator . $ControlID;
			}
			$this->AddedControl($ControlID, $Controls[$i]);
		}
	}
	
	//Methods
	public function LoadTemplate($Template)
	{
		$this->Template = $Template;
		$this->Document = str_get_dom($this->Template);
	}
	public function RenderControl()
	{
		parent::RenderControl();
		if ($this->Document === null)
		{
			$this->Node->setOuterText("<span></span>");
		}
		else if ($this->Node !== null)
		{
			$this->Node->setOuterText($this->Document->__toString());
		}
	}
	public function ProcessDirective($Directive)
	{
	}
	
	public function EvalPHP($Code)
	{
	    ob_start();
	    eval('?>' . $Code);
	    return ob_get_clean();
	}
}