<?php
/**
 * MimeMapping is a utility to get Mime Type
 *
 * Orcas
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @link		http://orcas.sdd.me.uk
 * @author		Abdul Sami Siddiqui - http://sdd.me.uk - sami@sdd.me.uk
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package		Utility
 */
class MimeMapping
{
	public static $MimeType = array(
			"pdf"=>"application/pdf"
			,"exe"=>"application/octet-stream"
			,"zip"=>"application/zip"
			,"docx"=>"application/msword"
			,"doc"=>"application/msword"
			,"xls"=>"application/vnd.ms-excel"
			,"ppt"=>"application/vnd.ms-powerpoint"
			,"gif"=>"image/gif"
			,"png"=>"image/png"
			,"jpeg"=>"image/jpg"
			,"jpg"=>"image/jpg"
			,"mp3"=>"audio/mpeg"
			,"wav"=>"audio/x-wav"
			,"mpeg"=>"video/mpeg"
			,"mpg"=>"video/mpeg"
			,"mpe"=>"video/mpeg"
			,"mov"=>"video/quicktime"
			,"avi"=>"video/x-msvideo"
			,"3gp"=>"video/3gpp"
			,"css"=>"text/css"
			,"jsc"=>"application/javascript"
			,"js"=>"application/javascript"
			,"php"=>"text/html"
			,"htm"=>"text/html"
			,"html"=>"text/html"
	);
	
	public static function GetMimeMapping($FileName, &$Extension = null)
	{
		$PathInfo = pathinfo($FileName);
		
		if (!isset($PathInfo['extension']))
		{
			return "";
		}
		$Extension = strtolower($PathInfo['extension']);
		
		if (isset(self::$MimeType[$Extension]))
		{
			return self::$MimeType[$Extension];
		}
		else
		{
			if(function_exists("mime_content_type"))
			{
				$m = mime_content_type($FileName);
			}
			else if(function_exists(""))
			{
				# if Pecl installed use it
				$finfo = finfo_open(FILEINFO_MIME);
				$m = finfo_file($finfo, $FileName);
				finfo_close($finfo);
			}
			else
			{    
				# if nothing left try shell
				if(strstr($_SERVER['HTTP_USER_AGENT'], "Windows"))
				{ 
					# Nothing to do on windows
					return ""; # Blank mime display most files correctly especially images.
				}
				if(strstr($_SERVER['HTTP_USER_AGENT'], "Macintosh"))
				{ 
					# Correct output on macs
					$m = trim(exec('file -b --mime '.escapeshellarg($FileName)));
				}
				else
				{    # Regular unix systems
					$m = trim(exec('file -bi '.escapeshellarg($FileName)));
				}
			}
			$m = split(";", $m);
			return trim($m[0]);
		}
	}
}