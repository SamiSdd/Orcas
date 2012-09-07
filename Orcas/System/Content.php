<?php
/**
 * Content Control is used in Child page of Master page to refer Master Page Content Place Holder
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
class Content extends WebControl
{
	//Propertise
	public function ContentPlaceHolderID($v = null)
	{
		if ($v === null)
		{
			return $this->GetAttribute("ContentPlaceHolderID", null);
		}
		else
		{
			$this->GetAttribute("ContentPlaceHolderID", $v);
		}
	}
	
	//Methods
	public function InstantiateIn(&$HtmlNode)
	{
		$HtmlNode->Markup = $this->Node->getInnerText();
	}
}