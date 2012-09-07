<?php
class update_panel extends Page
{
	public function Load()
	{
		parent::Load();
		
		$this->Label1->Text(date("Y-m-d H:i:s") . " Im Outside");
		$this->Label2->Text(date("Y-m-d H:i:s") . " Im in 1st UpdatePanel");
		$this->Label3->Text(date("Y-m-d H:i:s") . " Im in 2nd UpdatePanel");
	}
	
	public function Button1_Clicked(&$Sender, $EventArgs)
	{
		
	}
	public function Button2_Clicked(&$Sender, $EventArgs)
	{
		$this->UpdatePanel1->Update();
	}
}