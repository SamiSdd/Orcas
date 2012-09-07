<?php
/**
 * ListItem is Item entity of ListControl
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
class ListItem
{
	public $Collection;
	
	//Privates
	private $Value;
	private $Text;
	private $Enabled;
	
	//Propertise
	public function Value()
	{
		return $this->Value;
	}
	public function Text($v = null)
	{
		if ($v === null)
		{
			$Text = $this->Collection->ListControl->LoadState("{$this->Value}@Text" , null);
				
			if ($Text === null)
			{
				return $this->Text;
			}
			else
			{
				return $Text;
			}
		}
		else
		{
			$this->Collection->ListControl->SaveState("{$this->Value}@Text" , $v);
		}
	}
	public function Enabled($v = null)
	{
		if ($v === null)
		{
			$IsEnabled = $this->Collection->ListControl->LoadState("{$this->Value}@Enabled" , null);
			
			if (is_null($IsEnabled))
			{
				return $this->Enabled;
			}
			else
			{
				return $IsEnabled;
			}
		}
		else if (is_bool($v))
		{
			$this->Collection->ListControl->SaveState("{$this->Value}@Enabled" , $v);
		}
	}
	public function Selected($v = null)
	{
		if ($v === null)
		{
			if (!is_null($this->Collection) && !is_null($this->Collection->ListControl))
			{
				$Selected = $this->Collection->ListControl->SelectedValue();
				if (is_string($Selected))
				{
					return $Selected == $this->Value;
				}
				else if (is_array($Selected))
				{
					return (in_array($this->Value, $Selected));
				}
			}
				
			return false;
		}
		else
		{
			if ($this->Collection !== null && $this->Collection->ListControl !== null)
			{
				$this->Collection->ListControl->SelectedValue($this->Value);
				#$this->Collection->ListControl->SelectByValue($this->Value);
			}
		}
	}
	
	public function __construct($Value = null, $Text = null, $Enabled = true)
	{
		if ($Value !== null)
		{
			$this->Value = $Value;
			$this->Text = $Value;
		}
		
		if ($Text !== null)
		{
			$this->Text = $Text;
		}
		
		$this->Enabled = $Enabled;
	}
	
	//Methods
	public function AssignListItemCollection(&$ListItemCollection)
	{
		if ($this->Collection === null)
		{
			$this->Collection =& $ListItemCollection;
		}
		else
		{
			System::LogError("A ListItem can only be assign to one ListItemCollection.");
		}
	}
}