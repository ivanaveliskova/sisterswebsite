<?php

class FlyspeckFile
{
	var $myFile, $contents;

	function FlyspeckFile()
	{

	}

	function connectToFTP(){
		require "Ftp.php";
		$this->_ftp = & JFTP :: getInstance(FTP_SERVERNAME, 21, array(FTP_AUTOASCII), FTP_USERNAME, FTP_PASSWORD);

	}

	function setFile($file){
		$this->myFileName = DOCUMENT_ROOT . $file;
		$this->myRootRelativeFileName = (FTP_ROOTDIR) ? FTP_ROOTDIR . $file :  $file;
	}

	function processBody($bodyContent, &$tpl){
		$this->tpl =& $tpl;
		$pat = "/<!-- ".BEGIN_TAG." ".BEGIN_ATTR."\"(.*)\" -->(.*)<!-- ".END_TAG." -->/Us";
		$bodyContent = preg_replace_callback(
        $pat,
        array($this, 'applyTemplate'),
        $bodyContent
    );
    return $bodyContent;
	}


	function getTitleContent(){
		preg_match( "/<title[^>]*>(.*)<\/title>/si", $this->contents, $match );
		$title = strip_tags($match[1]);
		return $title;
	}

	function getBodyContent(){
		preg_match( "/<body[^>]*>(.*)<\/body>/si", $this->contents, $match );
		//We try to get the body, but if we dont, we just use the contents of the file.
		if(empty($match)){
			$body = $this->contents;
		} else {
			$body = $match[1];
		}
		return $body;
	}

	function getHeadContent(){
		preg_match( "/<head[^>]*>(.*)<\/head>/si", $this->contents, $match );
		//We try to get the body, but if we dont, we just use the contents of the file.
		if(empty($match)){
			$body = "";
		} else {
			$body = $match[1];
		}
		return $body;
	}

	function getMetaContent() {
	preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si',  $this->contents, $out, PREG_PATTERN_ORDER);

	for ($i=0;$i < count($out[1]);$i++) {
		// loop through the meta data - add your own tags here if you need
		if (strtolower($out[1][$i]) == "keywords") $meta['keywords'] = $out[2][$i];
		if (strtolower($out[1][$i]) == "description") $meta['description'] = $out[2][$i];
	}
	return isset($meta) ? $meta : null;
	}

	function applyTemplate($matches){
		$this->tpl->assign("matches",$matches);
		$html = $this->tpl->fetch('processbody.php');
		return $html;
	}

	function addSearchPat($pat) {
		$this->searchPats[] = $pat;
	}

	function addSearchRepl($repl) {
		$this->searchRepl[] = preg_quote($repl);
	}

	function replaceContent() {
		$this->contents = stripslashes(preg_replace ( $this->searchPats, $this->searchRepl, $this->contents ));
	}

	function getContents()
	{

		$myFile = new File($this->myFileName, 'r');
		$this->contents = $myFile->getContents();
		$myFile->close();
		if ($this->contents){
			if ($this->validateTags()) {
				return true;
			} else {
				trigger_error("There is an error in your editable tags syntax, you must have at least one set of tags &lt!-- ".BEGIN_TAG." ".BEGIN_ATTR."\"name\" --&gt;(.*)&lt;!-- ".END_TAG." --&gt;", E_USER_WARNING);
				return false;
			}
		} else {
			trigger_error("I couldn't get the contents of your file," .$this->myFileName, E_USER_WARNING);
		}
		return false;
	}

	function writeContent()
	{

		if(FTP_ENABLED){
		$this->connectToFTP();
		if($this->_ftp->isConnected()){
 			$ret = $this->_ftp->write($this->myRootRelativeFileName , $this->contents);
 			if(!$ret){
 				trigger_error ("An FTP error has occured saving", E_USER_WARNING);
 				$this->_ftp->quit();
 				return false;
 			} else {
				trigger_error("Content Saved", E_USER_NOTICE);
				$this->_ftp->quit();
				return true;
 			}
		} else {
			trigger_error ("Connection Refused to FTP Server", E_USER_WARNING);
			return false;
		}

		}	 //end if ftp enabled.

		if (!is_writable($this->myFileName)) {
			$decperms = fileperms($this->myFileName);
			$octalperms = sprintf("%o",$decperms);
			$perms=(substr($octalperms,3));
			$msg =  "<br>Cannot write to file ".$this->myFileName;
			$msg .= "<br>The permissions on the file currently are " . $perms;
			$msg .= "<br>You must chmod this file to 666 or higher in your ftp program.";
			trigger_error ($msg, E_USER_WARNING);
			return false;
		} else {
			$myFile = new File($this->myFileName, 'w+');
			$myFile->write($this->contents);
			$myFile->close();
			trigger_error("Content Saved", E_USER_NOTICE);
			return true;
		}

	}

function validateTags() {
define ("BEGIN_TAG" , "#BeginEdit");
define ("BEGIN_ATTR" , ""); // Leave blank for default flyspeck tags, make it name= for Dreamweaver.
define ("END_TAG" , "#EndEdit");
	$pat = "/<!-- ".BEGIN_TAG." ".BEGIN_ATTR."\"(.*)\" -->(.*)<!-- ".END_TAG." -->/Us";
 	preg_match_all( $pat, $this->contents, $matches, PREG_SET_ORDER);

 	if (count($matches)>0){
 		$this->allmatches = $matches;
 		return true;
 	} else {
 		return false;
 	}
}

function generateMasterContentModel(){
	$obj = new stdClass;
	foreach($this->allmatches as $match){
		$obj->$match[1] = $match[2];
	}
	return $obj;
}

}//end class


?>
