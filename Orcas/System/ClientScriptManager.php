<?php
/**
 * Client Script Manager Manage Hidden Fields, Client Scripts, Script Includes and 
 * Other Client Side Objects
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
class ClientScriptManager
{
	public $HiddenFields = array();
	public $StartupScripts = array();
	public $ScriptBlocks = array();
	public $ScriptIncludes = array();
	
	public function RegisterHiddenField($FieldName, $FieldValue)
	{
		$this->HiddenFields[$FieldName] = $FieldValue;
	}
	public function RegisterStartupScript($Key, $Script)
	{
		$this->StartupScripts[$Key] = $Script;
	}
	public function RegisterClientScriptBlock($Key, $Script)
	{
		$this->ScriptBlocks[$Key] = $Script;
	}
	public function RegisterClientScriptInclude($Key, $Url)
	{
		$this->ScriptIncludes[$Key] = $Url;
	}
}