<?php
 
 
class ftpclient
{
	var $linkid;
    var $errmsg;
	function ftpclient($ftpserver, $ftpuser, $ftppass)
	{
	    $this->linkid = ftp_connect($ftpserver);
		$this->errmsg = $this->linkid ? '' : 'Connect to server failed :(';
		$login = $this->linkid ? ftp_login($this->linkid, $ftpuser, $ftppass) : false;
		$this->errmsg = $login ? '' : 'Login to server failed :(';
		$this->linkid = $login ? $this->linkid : false;
	}
	function uploadfile($disfile, $sourcefile)
	{
	    
		$disfolder = explode('/', $disfile);
		$tmpfolder = '/';
		for($i = 0; $i < count($disfolder) - 1; $i++)
		{
		    if(!ftp_chdir($this->linkid, $tmpfolder.'/'.$disfolder[$i]))
			{
			    $this->errmsg = 'No such folder';
				if(!ftp_mkdir($this->linkid, $tmpfolder.'/'.$disfolder[$i]))
				{
				    $this->errmsg .= ' and cannot create:'.$tmpfolder.'/'.$disfolder[$i];
					return false;
				}
			}
			$tmpfolder .= '/'.$disfolder[$i];
		}
		
	    if(!ftp_put($this->linkid, $disfile, $sourcefile, FTP_BINARY))
		{
		    $this->errmsg = 'Can not upload file.'."|".$disfile."|".$sourcefile;
			return false;
		}
		else
		{
		    return true;
		}
	}
	function unlinkfile($disfile)
	{
	    return ftp_delete($this->linkid, $disfile) ? true : false;
	}
	function disconnect()
	{
	    ftp_close($this->linkid);
	}

}
?>