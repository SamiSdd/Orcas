<?php
class form_validation extends Page
{
	public function AllowAddress_CheckChanged(&$Sender, $EventArgs)
	{
		//Get Wether checkbox is checked.
		$ShowAddress = $this->AllowAddress->Checked();
		
		//Show hide Panel According to check
		$this->AddressPanel->Visible($ShowAddress);
	}
	
	public function Save_Form_Clicked(&$Sender, $EventArgs)
	{
		//Create Errors array to validate form at once and save error
		$Errors		= array();
		
		//Get First name, Last name and Password from textboxes
		$FirstName	= $this->FirstNameTextBox->Text();
		$LastName	= $this->LastNameTextBox->Text();
		$Password	= $this->PasswordTextBox->Text();
		
		//Get fix Address check and address value
		$FixAddress	= $this->AllowAddress->Checked();
		$Address	= $this->AddressTextBox->Text();
		
		
		//Validate first name
		if (empty($FirstName))
		{
			//If empty then add error and add class to First Name textbox
			$Errors[] = "First Name is Required";
			$this->FirstNameTextBox->CssClass("Required");
		}
		else
		{
			//If not empty clear css class
			$this->FirstNameTextBox->CssClass("");
		}
		

		//Validate Password
		if (empty($Password))
		{
			$Errors[] = "Password is Required";
			$this->PasswordTextBox->CssClass("Required");
		}
		else
		{
			$this->PasswordTextBox->CssClass("");
		}
		
		//Validate Address if checkbox is checked
		if ($FixAddress && empty($Address))
		{
			$Errors[] = "Address is Required";
			$this->AddressTextBox->CssClass("Required");
		}
		else
		{
			$this->AddressTextBox->CssClass("");
		}
		
		//If error occurred show error else show success message
		if (count($Errors) > 0)
		{
			$this->MessageLabel->CssClass("ErrorLabel");
			
			//Error array to string and set it to label
			$this->MessageLabel->Text(implode("<br>", $Errors));
		}
		else
		{
			$this->MessageLabel->CssClass("SucessLabel");
			
			$this->MessageLabel->Text("Successfully registered user.");
		}
	}
}