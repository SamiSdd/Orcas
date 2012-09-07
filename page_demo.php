<?php
class page_demo extends Page
{
	public function Load()
	{
		//Must Trigger Base Class Load Event
		parent::Load();
		
		//Checks if Page is not Posted back.
		if ($this->IsPostBack == false)
		{
			//Then Change Label to Current Date Time.
			$this->DateLoadedLabel->Text(date("Y/m/d H:i:s"));
		}
	}
	
	//This event will handle Button1 is clicked.
	public function Button1_Clicked()
	{
		//Change Button1 Text So We Know Page is Posted
		$this->Button1->Text("Hey I'm Clicked");
	}
}