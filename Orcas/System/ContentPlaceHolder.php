<?php
/**
 * ContentPlaceHolder Control is used in Master page to define area which child page can use 
 * by content Control.
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
class ContentPlaceHolder extends WebControl
{
	public $ContentTemplate;
	
	//Control Events
	public function Render()
	{
		parent::Render();
		if ($this->ContentTemplate === null)
		{
			$this->Node->setOuterText("");
		}
		else
		{
			
			$this->ContentTemplate->InstantiateIn($this->Node);
		}
	}
}