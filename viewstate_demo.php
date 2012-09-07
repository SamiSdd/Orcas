<?php
class viewstate_demo extends Page
{
	public function Button1_Clicked()
	{
		/*
		 * LoadState exsist in Page, Master Page, User Control and Web Control. 
		 * Everywhere similar syntax will be follow
		 * 
		 * Param1 - Key
		 * Param2 - Default Value if State Doesn't Exist
		 */
		$Count = $this->LoadState("Button1_Count", 0);
		
		//Add 1 to Count
		$Count++;
		
		//Save Back Count to ViewState
		/*
		 * Behaviour is similar to LoadState
		 * 
		 * Param1 - Key
		 * Param2 - Value to save in this Item
		 */
		$this->SaveState("Button1_Count", $Count);
		$this->Button1->Text($Count);
	}	
	public function Button2_Clicked()
	{
		//Demostrate Another way to Handle ViewState
		
		//Load Count of Button2 When Button 2 is clicked
		$Count = 0;
		if (isset($this->ViewState["Button2_Count"]))
		{
			$Count = (int)$this->ViewState["Button2_Count"];
		}
		
		//Add 1 to Count
		$Count++;
		
		//Save Back Count to ViewState
		$this->ViewState["Button2_Count"] = $Count;
		$this->Button2->Text($Count);
	}
}