<?php
/**
 * PageHandler is Request Handler for Pages (php,phpx)
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
class PageHandler implements IHttpHandler
{
	public $Context;
	
	protected function GetTemplatePath()
	{
		return $this->Context->UserPath . "/" . str_replace($this->Context->Request->RequestExtension, "html.php", $this->Context->Request->Path);
	}
	public function ProcessRequest(&$Context)
	{
		$this->Context =& $Context;
		$PageTemplate = $this->GetTemplatePath();
		
		if (!file_exists($PageTemplate))
		{
			echo "404";
			exit();
		}
		$Template = System::GetContent($PageTemplate);
		$PageDirective = Parser::ParseDirective("Page", $Template);
		
		if (!isset($PageDirective['Inherits']))
		{
			System::LogError("Page Directive Must Include Inherits Attribute.");	
		}
		
		$Activator = new ReflectionClass($PageDirective['Inherits']);
		$Page = $Activator->newInstanceArgs();
		$Page->ProcessDirective($PageDirective);
		$Page->LoadTemplate($Template);
		
		$Page->PreInit();
		$Page->Init();
		$Page->Load();
		$Page->LoadComplete();
		$Page->PreRender();
		$Page->Render();
		
		$this->Context->Response->Flush();
	}
}