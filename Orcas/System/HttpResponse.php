<?php 
/**
 * HttpResponse contains members to properly render page, files, header, cookies
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
class HttpResponse
{
	public $Headers = array();
	
	public function ContentType($v)
	{
		header("Content-Type: {$v}");
	}
	
	public function __construct()
	{
		ob_start();
		header("X-Powered-By-2: Orcas");
		
		#$this->Headers = apache_response_headers();
	}
	
	
	public function AddHeader($Name, $Value)
	{
		header("{$Name}: {$Value}");
	}
	public function ClearHeaders()
	{
		header_remove();
	}
	
	public function Write($Text)
	{
		echo $Text;
	}
	public function WriteLine($Text)
	{
		echo $Text . "\n\r";
	}
	public function WriteFile($Path)
	{
		readfile($Path);
	}
	
	public function Flush()
	{
		ob_flush();
	}
	
	public function TransmitFile($Path)
	{
		ob_end_clean();
		
		$Handle = fopen($Path, 'rb');
		$this->ContentType(MimeMapping::GetMimeMapping($Path));
		$this->AddHeader('Content-Length', filesize($Path));
		fpassthru($Handle);
		exit();
	}
}