<?php
/**
 * AssemblyResourceLoader - Internal Assets Handler
 * AssemblyResourceLoader deliever internal files of orcas such as Javascript files and Images.
 *
 * Orcas
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @link		http://orcas.sdd.me.uk
 * @author		Abdul Sami Siddiqui - http://sdd.me.uk - sami@sdd.me.uk
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package		Handler
 */
class AssemblyResourceLoader implements IHttpHandler
{
	public $Context;
	
	public function ProcessRequest(&$Context)
	{
		$this->Context =& $Context;
		
		$File = $this->Context->CorePath . "/" . $_REQUEST['d'];
		
		$FileInfo = pathinfo($File);
		if (!isset($_REQUEST['d']) &&
			!isset($FileInfo['extension']) &&
			!file_exists($File))
		{
			return;
		}
		
		if ($FileInfo['extension'] != "php")
		{
			$this->Context->Response->AddHeader("Cache-Control", "maxage=15768000");
			$this->Context->Response->AddHeader("Pragma", "public");
			$this->Context->Response->AddHeader("Expires", gmdate('D, d M Y H:i:s', (strtotime("+1 year"))) . ' GMT');
			
			$this->Context->Response->TransmitFile($File);
		}
		else
		{
			include $File;
		}
	}
	
	public static function GeneratePath($FilePath)
	{
		return HttpContext::$Current->Server->ResolveUrl("~/ScriptResource.res.php?d=" . urlencode($FilePath));
	}
}