<html>
<head>
<style>
body {font-family: verdana; font-size: 10pt}
.ok {color:green}
.notok {background:pink; color:black; border: 2px solid red}
code {background:whitesmoke; border: 1px dashed gray}
.notification {background:lemonchiffon; border: 1px dashed gray; padding:2ex}
fieldset {margin-bottom:2em}
legend { font-weight:bold}
</style>
</head>
<body>
<h1>Flyspeck Install Script</h1>

<?php
require "config.php";
require "classes/Error.php";

/*
Verify Installation
 */
/*php ver*/
$vers = phpversion();
$vernum = $vers[0];
echo '<fieldset><legend>Current PHP version: '.$vers .'</legend>';
echo '<div class="notification">';
$ftppossible = false;
if(FTP_ENABLED){
if ($vernum <5){
	echo 'You are using php 4, you must disable the FTP_ENABLE config option in config.php</div>';
} else {
	echo 'You are using php 5, you may set FTP_ENABLE to true in config.php to use the ftp layer';
	$ftppossible = true;
}
} else {
  echo 'PHP ' . $vernum . ' detected, and FTP is disabled.';
}
echo '</div></fieldset>';



/*FTP CHECK*/
if($ftppossible){
require "classes/Ftp.php";
echo "<fieldset>";
echo "<legend>FTP Settings check</legend>";

echo "<p>";
$verify = FTPVerify(FTP_USERNAME, FTP_PASSWORD, $root, FTP_SERVERNAME, 21);

if(!is_object($verify) && $verify){
	echo '<div class="ok"><ul><li>Connection to FTP Server Successful.</li></ul></div>';
} else {
	echo '<div class="notok">';
$errorq = GlobalErrorQueue::getInstance();
$errorq->printAllErrors();
echo "</div>";
}

$goodRoot = findFtpRoot(FTP_USERNAME, FTP_PASSWORD, FTP_SERVERNAME, 21);
$rootMatchesConfig = (FTP_ROOTDIR == $goodRoot);
if($goodRoot){
	echo '<div class="ok"><ul><li>Auto detected Rootdir: '.$goodRoot.'</li>';
	if ($rootMatchesConfig) {  echo '<li>Auto detected Rootdir Matches the FTP_ROOTDIR config</li>';
	} else {
		echo '<li class="notok"><b>FTP_ROOTDIR Warning</b> Try setting your FTP_ROOTDIR in config.php to '.$goodRoot.' <b><a href="http://www.flyspeck.net/technical_info/qwikiwiki/index.php?page=Configuring_FTP_Settings" target="_blank">[help]</a></b></li>';
	}
	echo '</ul></div>';
} else{
	echo '<div class="notification">';
	echo "<ul><li>I could not autodetect your ftp site root, please <a href='http://www.flyspeck.net/technical_info/qwikiwiki/index.php?page=Configuring_FTP_Settings' target='_blank'>visit Flyspeck Documentation on Setting FTP_ROOT</a></li></ul>";
	echo '</div>';
}

echo "</p>";
echo "</fieldset>";
}



 /*File Permissions*/
echo "<fieldset><legend>File / Folder Permissions Check - <a href=\"http://flyspeck.net/technical_info/qwikiwiki/index.php?page=File_Permission_Requirements\" target=\"_blank\">[help]</a></legend>";
$files = array ('codelock.php' , 'data/flyspeck/roles.txt', 'data/flyspeck/users.txt');
print "<ul>";
foreach($files as $file){
	print "<li>";
	$isw = is_writeable($file);
	print "$file is writeable : ";
	if ($isw) {
		echo "<span class=\"ok\">OK</span>";
		} else {
	echo "<span class=\"notok\">FAILED</span>";
	}
	print "</li>";
}
print "</ul>";
print "</fieldset>";
/*Upload Dir*/
echo "<fieldset><legend>Upload Dir - <a href=\"http://flyspeck.com/technical_info/qwikiwiki/index.php?page=Configuring_Upload_Dir\" target=\"_blank\">[help]</a></legend>";
echo "<ul>";
$uploaddir = DOCUMENT_ROOT.'/'.UPLOAD_DIR;
if (is_dir($uploaddir)){
	echo "<li class=\"ok\">$uploaddir exists</li>";
	if (is_writeable($uploaddir)){
		echo "<li class=\"ok\">$uploaddir is ready!</li>";
	} else {
		echo "<li class=\"notok\">$uploaddir must be chmodded to 777.</li>";
	}
} else {
	echo "<li class=\"notok\">$uploaddir does not exist, you must create it, and chmod it 777.</li>";
}
echo "</ul></fieldset>";


 /*Domain Key*/
echo "<fieldset><legend>Domain Key Check</legend><ul>";
$url = "http://".$_SERVER['HTTP_HOST'] . INSTALL_DIR . "/index.php";

$open= get_cfg_var('allow_url_fopen');

if (!$open) {
    echo "<li>I could not detect if your key is valid, try the <a href=\"". INSTALL_DIR . "/examples/whole_page.html\"> Example Page</a> To see if the trigger works, it just might!</li>";
} else {
	if ($_SERVER['HTTP_HOST'] != 'localhost'){
	$home = file_get_contents($url);
	$len = strlen($home);
	} else {
		$len = 301;
	}
}

print "<li>";
if ($len > 300){
	print "<span class=\"ok\">Domain Key Entered and Correct</span> ";
} else {
	echo "<span class=\"notok\">Domain Key not Entered, non determinable or Incorrect.</span><p>NOTE: Even if this is red, it maybe ok. <a href=\"examples/whole_page.html\">Just try the example page and see if the trigger works.</a></p>";
}
echo "</li></ul></fieldset>";



echo "<fieldset><legend>Site Files Check</legend>";
$files = array (DOCUMENT_ROOT . "/" . DEFAULT_DOCUMENT);
print "<ul>";
foreach($files as $file){
	print "<li>";
	$isw = file_exists($file);
	print "Default Document: " . DEFAULT_DOCUMENT . "<br>";
	print "$file - (default doc check) :<br>";
	if ($isw) {
		echo "<span class=\"ok\">DEFAULT DOCUMENT EXISTS</span>";
			if (!$ftppossible && is_writeable($file)){
				echo "<span class=\"ok\">- AND IS WRITABLE.</span>";
			}
		} else {
	echo "<span class=\"notok\">DEFAULT DOCUMENT DOES NOT EXIST.</span>";
				if (!$ftppossible && !is_writeable($file)){
				echo "<span class=\"notok\">- AND IS NOT WRITABLE- you must CHMOD 666 your site files.</span>";
			}

	}
	print "</li>";
}
print "</ul></fieldset>";
print "<hr>";
echo "<h2>Trigger Code Snips</h2>";

echo "<p>This line must go in the head section tag on all your pages that you want flyspeck on.</p>";
echo "<code>";
echo '&lt;script src="' . INSTALL_DIR . '/trigger.js" id="flytrig"&gt;&lt;/script&gt;';
echo "</code>";
echo "</fieldset>";


?>
<h2>Try Out Sample Page</h2>
<a href="examples/whole_page.html">Super Simple Hello World Test Page</a>
<hr>
<h4>Additional Debugging Info</h4>
<ul>
<?php
echo "<li>INSTALL_DIR: " . INSTALL_DIR;
echo "<li>_SERVER[DOCUMENT_ROOT]: " . $_SERVER["DOCUMENT_ROOT"];
echo "<li>_SERVER[\"SCRIPT_FILENAME\"]: ". $_SERVER["SCRIPT_FILENAME"];
echo "<li>_ENV[\"OS\"]: " . $_ENV["OS"];

?>
</ul>
</body>
</html>
<?


	/**
	 * Find the ftp filesystem root for a given user/pass pair
	 *
	 * @static
	 * @param	string	$user	Username of the ftp user to determine root for
	 * @param	string	$pass	Password of the ftp user to determine root for
	 * @return	string	Filesystem root for given FTP user
	 * @since 1.5
	 */
	function findFtpRoot($user, $pass, $host='127.0.0.1', $port='21')
	{

		$ftpPaths = array();


		// Connect and login to the FTP server (using binary transfer mode to be able to compare files)
		$ftp =& JFTP::getInstance($host, $port, array('type'=>FTP_BINARY));
		if (!$ftp->isConnected()) {
			return JError::raiseError('31', 'NOCONNECT');
		}
		if (!$ftp->login($user, $pass)) {
			return JError::raiseError('31', 'NOLOGIN');
		}

		// Get the FTP CWD, in case it is not the FTP root
		$cwd = $ftp->pwd();
		if ($cwd === false) {
			return JError::raiseError('SOME_ERROR_CODE', 'NOPWD');
		}
		$cwd = rtrim($cwd, '/');

		// Get list of folders in the CWD
		$ftpFolders = $ftp->listDetails(null, 'folders');
		if ($ftpFolders === false || count($ftpFolders) == 0) {
			return JError::raiseError('SOME_ERROR_CODE', 'NODIRECTORYLISTING');
		}
		for ($i=0, $n=count($ftpFolders); $i<$n; $i++) {
			$ftpFolders[$i] = $ftpFolders[$i]['name'];
		}

		// Check if flyspeck is installed at the FTP CWD
		$dirList = array('flyspeck');
		if (count(array_diff($dirList, $ftpFolders)) == 0) {
			$ftpPaths[] = $cwd.'/';
		}

		// Process the list: cycle through all parts of INSTALL_ROOT, beginning from the end
		$parts		= explode(DIRECTORY_SEPARATOR, INSTALL_ROOT);


		$tmpPath	= '';
		for ($i=count($parts)-1; $i>=0; $i--)
		{
			$tmpPath = '/'.$parts[$i].$tmpPath;
			if (in_array($parts[$i], $ftpFolders)) {
				$ftpPaths[] = $cwd.$tmpPath;
			}
		}

		// Check all possible paths for the real flyspeck installation
		$checkValue = file_get_contents(INSTALL_ROOT.'/license.txt');
		foreach ($ftpPaths as $tmpPath)
		{
			$filePath = rtrim($tmpPath, '/').'/license.txt';
			$buffer = null;
			$ftp->read($filePath, $buffer);
			if ($buffer == $checkValue)
			{
				$ftpPath = $tmpPath;
				break;
			}
		}

		// Close the FTP connection
		$ftp->quit();

		// Return the FTP root path
		if (isset($ftpPath)) {
			return str_replace(INSTALL_DIR, "", $ftpPath);
		} else {
			return JError::raiseError('SOME_ERROR_CODE', 'Unable to autodetect the FTP root folder');
		}
	}

	/**
	 * Verify the FTP configuration values are valid
	 *
	 * @static
	 * @param	string	$user	Username of the ftp user to determine root for
	 * @param	string	$pass	Password of the ftp user to determine root for
	 * @return	mixed	Boolean true on success or JError object on fail
	 * @since	1.5
	 */
	function FTPVerify($user, $pass, $root, $host='127.0.0.1', $port='21')
	{
		$ftp = & JFTP::getInstance($host, $port);

		// Since the root path will be trimmed when it gets saved to configuration.php, we want to test with the same value as well
		$root = rtrim($root, '/');

	// Verify connection
		if (!$ftp->isConnected()) {
			return JError::raiseWarning('31', 'NOCONNECT');
		}

		// Verify username and password
		if (!$ftp->login($user, $pass)) {
			return JError::raiseWarning('31', 'NOLOGIN');
		}

		// Verify PWD function
		if ($ftp->pwd() === false) {
			return JError::raiseError('SOME_ERROR_CODE', 'NOPWD');
		}

		// Verify root path exists
		if (!$ftp->chdir($root)) {
			return JError::raiseWarning('31', 'NOROOT');
		}

		$ftp->quit();
		return true;
	}




?>
