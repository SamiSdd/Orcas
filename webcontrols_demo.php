<?php
class webcontrols_demo extends Page
{
	public function Panel_Button1_Clicked(&$Sender, $EventArgs)
	{
		//Get Height Of Panel1
		$Height = (int)$this->Panel1->Style->Items['height'];
		
		//Add Height +50
		$Height = $Height+50;
		
		//Apply New Height
		$this->Panel1->Style->Add("height", $Height . 'px');
	}
	public function Button1_Clicked(&$Sender, $EventArgs)
	{
		//Change Css Class of Sender (mean the Button which will call this event)
		$Sender->CssClass("Clicked");
	}
	
	public function TextBox1_Button_Clicked(&$Sender, $EventArgs)
	{
		//Get Whats Written In TextBox
		$UserInput = $this->TextBox1->Text();
		
		//Register Javascript to show alert of What User Input
		$this->ClientScript->RegisterClientScriptBlock("TextBox1_Notify", "alert('{$UserInput}')");
	}
	
	public function CheckBox2_CheckChanged(&$Sender, $EventArgs)
	{
		//Get CheckBox Value
		$Checked = $this->CheckBox2->Checked();

		if ($Checked == true)
		{
			$this->CheckBox2->Text("Im Checked");
		}
		else
		{
			$this->CheckBox2->Text("Not Checked");
		}
	}
	
	public function LinkButton1_Clicked(&$Sender, $EventArgs)
	{
		$Sender->Text("Im Clicked");
	}
	
	
	/*
	 * Events for DropDownList Demo Buttons
	 */
	public function DropDownList1_Show2(&$Sender, $EventArgs)
	{
		$this->DropDownList1->Items->Item("two")->Enabled(true);
	}
	public function DropDownList1_Translate(&$Sender, $EventArgs)
	{
		$this->DropDownList1->Items->Item("one")->Text("1");
		$this->DropDownList1->Items->Item("two")->Text("2");
		$this->DropDownList1->Items->Item("three")->Text("3");
	}
}