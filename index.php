<?php 
class index extends Page
{
	public function Button1_Clicked(&$Sender, $EventArgs)
	{
		//Get User Input of Text in $UserInput variable.
		$UserInput = $this->TextBox1->Text();
    
		//Change Label Text to What $UserInput.
		$this->UserInfoLabel->Text($UserInput);
		
		//Clear the TextBox.
		$this->TextBox1->Text("");
	}
}
