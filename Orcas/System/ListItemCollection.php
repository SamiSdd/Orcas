<?php
/**
 * ListItemCollection is Collection of "ListItem" in "ListControl"
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
class ListItemCollection implements Iterator
{
	//Privates
	private $position = 0;
	private $Items;
	
	//Propertise
	public function Count()
	{
		return count($this->Items);
	}
	public $ListControl;
	
	public function __construct(&$ListControl)
	{
		$this->ListControl =& $ListControl;
		$this->Items = array();
		$this->position = 0;
	}
	
	//Methods
	public function &Item($Index)
	{
		if (is_int($Index))
		{
			$Values = array_values($this->Items);
			if ($Index < count($Values))
			{
				return $Values[$Index];
			}
		}
		else if (is_string($Index) && isset($this->Items[$Index]))
		{
			return $this->Items[$Index];
		}
	
		return null;
	}
	public function Add(&$Item)
	{
		$ItemInstance = null;
		if (is_string($Item))
		{
			$ItemInstance = new ListItem($Item, $Item);
		}
		else if (get_class($Item) == "ListItem")
		{
			$ItemInstance =& $Item;
		}
		
		if (!isset($this->Items[$ItemInstance->Value()]))
		{
			$ItemInstance->AssignListItemCollection($this);
			$this->Items[$ItemInstance->Value()] =& $ItemInstance;
		}
		else
		{
			System::LogError("A ListItem with '{$ItemInstance->Value()}' already registered in ListItemCollection");
		}
	}
	public function AddRange($List)
	{
		if (is_array($List))
		{
			for($i = 0; $i < count($List); $i++)
			{
				$this->Add($List[$i]);
			}
		}
	}
	public function &FindByValue($Value)
	{
		if (isset($this->Items[$Value]))
		{
			return $this->Items[$Value];
		}
		return null;
	}
	public function &FindByText($Text)
	{
		foreach($this->Items as $Value => $Item)
		{
			if ($Item->Text == $Text)
			{
				return $Item;
			}
		}
		
		return null;
	}

	//Iterator Implementation
	function rewind() 
	{
		$this->position = 0;
	}
	function current()
	{
		$Keys = array_keys($this->Items);
		return  $this->Items[$Keys[$this->position]];
	}
	function key()
	{
		$Keys = array_keys($this->Items);
		return $Keys[$this->position];
	}
	function next() 
	{
		++$this->position;
	}
	function valid()
	{
		$Keys = array_keys($this->Items);
		return isset($Keys[$this->position]);
	}
}