<?php
/**
 * ListControl is base class for controls which deals in list of items like ListBox, DropDownList etc
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
class ListControl extends WebControl
{
	//Enums
	public static $ListSelectionMode_Single		= "Single";
	public static $ListSelectionMode_Multiple	= "Multiple";
	
	public $Items;
	
	//Propertise
	public function SelectionMode($v = null)
	{
		if ($v === null)
		{
			return $this->GetProperty("SelectionMode", self::$ListSelectionMode_Single);
		}
		else
		{
			$this->SetProperty("SelectionMode", $v);
		}
	}
	public function SelectedValue($v = null)
	{
		$SelectionMode = $this->SelectionMode();
		if ($v === null)
		{
			return $this->Page->Request->GetForm($this->UniqueID, ($this->SelectionMode() == self::$ListSelectionMode_Single ? "" : array()));
		}
		else
		{
			if ($SelectionMode == self::$ListSelectionMode_Single)
			{
				$this->Page->Request->SetForm($this->UniqueID, $v);
			}
			else if ($SelectionMode == self::$ListSelectionMode_Multiple)
			{
				$Selected = $this->Page->Request->GetForm($this->UniqueID, array());
				
				if (is_string($v))
				{
					if (!in_array($v, $Selected))
					{
						$Selected[] = $v;
					}
				}
				else if (is_array($v))
				{
					foreach($v as $ItemValue)
					{
						if (!in_array($ItemValue, $Selected))
						{
							$Selected[] = $ItemValue;
						}
					}
				}
				$this->Page->Request->SetForm($this->UniqueID, $Selected);
			}
		}
	}
	public function &SelectedItem()
	{
		return $this->Items->Item($this->SelectedValue());
	}
	
	public function __construct()
	{
		parent::__construct();
		$this->Items = new ListItemCollection($this);
	}
	
	//Control Events
	public function Init()
	{
		parent::Init();
	
		$ListItems		= $this->Node->getChildrenByTag("php:ListItem", 'total', false);
		$SelectedValue	= array();
	
		foreach($ListItems as &$Item)
		{
			if (strtolower($Item->Selected) == "true")
			{
				$SelectedValue[] = $Item->Value;
			}
			$this->Items->Add(new ListItem($Item->Value, $Item->Text, !(strtolower($Item->Enabled) == "false")));
		}
	
		if (!$this->Page->IsPostBack)
		{
			if ($this->SelectionMode() == self::$ListSelectionMode_Single && count($SelectedValue) > 0)
			{
				$this->SelectedValue($SelectedValue[0]);
			}
			else if ($this->SelectionMode() == self::$ListSelectionMode_Multiple)
			{
				$this->SelectedValue($SelectedValue);
			}
		}
	}
	
	//Methods
	public function ClearSelection()
	{
		$this->Page->Request->SetForm($this->UniqueID, array());
	}
}