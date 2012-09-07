<?php
/**
 * Form Control
 *
 * Orcas
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @link		http://orcas.sdd.me.uk
 * @author		Abdul Sami Siddiqui - http://sdd.me.uk - sami@sdd.me.uk
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package		Control
 */
class Form extends WebControl
{
	//Control Events
	public function Init()
	{
		parent::Init();

		if ($this->Page->Form === null)
		{
			$this->Page->Form =& $this;
		}
		else
		{
			System::LogError("Only one instance of Form can exist on a page.");	
		}
	}
	public function Render()
	{	
		parent::Render();
		$this->Node->self_close = false;
		$this->Node->setTag("form", true);
		$this->Node->addAttribute('method', 'post');
		$this->Node->addAttribute('action', $this->Request->Url());
		/*
		$ParamsDiv = new HTML_Node("div", $this->Instance);
		$ParamsDiv->addAttribute('style', 'display:none;');
		*/
		
		$HiddenFieldsMarkup = array();
		foreach($this->Page->ClientScript->HiddenFields as $Name => $Value)
		{
			$Value = htmlentities($Value);
			$HiddenFieldsMarkup[] = "<input type='hidden' name='{$Name}' value='{$Value}' />";
		}
		
		$ClientScriptOnLoad = array();
		
		$ClientScriptOnLoad[] = "//<![CDATA[
		var theForm = document.forms['{$this->ClientID}'];
		if (!theForm) { theForm = document.{$this->ClientID}; }
		function __doPostBack(eventTarget, eventArgument) 
		{
			theForm.__EVENTTARGET.value = eventTarget;
			theForm.__EVENTARGUMENT.value = eventArgument;
			
			var DoPostResult = true;
			
			if (theForm.DoPost)
			{
				DoPostResult = theForm.DoPost(eventTarget, eventArgument);
			}
			
			if (DoPostResult && (!theForm.onsubmit || (theForm.onsubmit() != false))) 
			{
				theForm.submit();
			}
		}
		//]]>";
		
		
		$HiddenFieldsMarkup = implode("\n", $HiddenFieldsMarkup);
		
		
		$ScriptIncludes = array_map(function($e){
			return "<script type='text/javascript' src='{$e}'></script>";
		}, $this->Page->ClientScript->ScriptIncludes);
		
		if (count($ScriptIncludes) > 0)
		{
			$ScriptIncludes = implode("\n", $ScriptIncludes);
		}
		else
		{
			$ScriptIncludes = "";
		}
		
		
		$ClientScriptOnLoadtStr = "";
		if (count($ClientScriptOnLoad) > 0)
		{
			$ClientScriptOnLoadtStr = "<script type='text/javascript'>" . implode("\n", array_merge($ClientScriptOnLoad, $this->Page->ClientScript->ScriptBlocks)) . "</script>";
		}
		
		
		$StartupScriptsStr = "";
		$StartupScriptsStr = implode("\n", $this->Page->ClientScript->StartupScripts);
		if (strlen($StartupScriptsStr) > 0)
		{
			$StartupScriptsStr = "<script type='text/javascript'>{$StartupScriptsStr}</script>";
		}
		
		
		$this->Node->setInnerText(
				"<div>{$HiddenFieldsMarkup}</div>" . 
				$ScriptIncludes . 
				$ClientScriptOnLoadtStr . 
				$this->Node->getInnerText() .
				"<div>{$StartupScriptsStr}</div>");
		
	}
}

