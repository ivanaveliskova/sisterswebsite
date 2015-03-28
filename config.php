<?php
/*Flyspeck Master Configurations File*/


$domain_key="179-389-289-189-290-145-690-345-778-795-793-190-"; 

/*FTP Editing
 * You can only use the ftp layer if you have php 5, if you have php 4, set FTP_ENABLED to false*/
define ("FTP_ENABLED" , true);
define ("FTP_SERVERNAME" , "127.0.0.1"); //Most often this works fine.
define ("FTP_USERNAME" , "newuser"); //Your ftp user that has write access to your files (can be just your main account)
define ("FTP_PASSWORD" , "test"); //password for above user
define ("FTP_ROOTDIR" , "/htdocs"); //Most often /public_html, sometimes its /www, when you login as your ftp user, what dir is the ROOT Directory of your site.

/*Default Document
 * This should be your default index file type, no path */
define("DEFAULT_DOCUMENT", "index.html"); //Set this to the sites default index document i.e. index.html, default.htm etc.

/*Email Notifications
 * Leave commented if you do not want notifications*/
//define("NOTIFY_EMAIL", "youremail@yoursite.com"); //Set this to the email address you want to receive notifications of edits. Leave blank if you dont

/*Upload
 * You create a directory (typically /userfiles) off of your site root, and chmod 777 that folder. Specify the path here*/
define("UPLOAD_DIR", "/userfiles/"); //Set to the directory you want people to upload files and images to.

/*Misc
 * */
define ("SAVE_PAGE_AS" , true);  //Set to true to allow people to do a save-page-as.
define ("TITLE_EDIT" , true); //Allow users to edit the <title> tag.
define ("META_KEYWORDS_EDIT" , true); //Allow users to edit the <meta keywords> tag. (must exist first in html page)
define ("META_DESC_EDIT" , true); //Allow users to edit the <meta description> tag. (must exist first in html page)
define ("SITEBROWSER" , true);  // Set to true to allow people to browse the tree under the "site browser" link.
define ("SITEBROWSER_FILTER" , "-/^\/_.*/,-/cgi-bin/,-/flyspeck/" );  // Setup regexes to filter out dirs you don't want clients to see in sitebrowser - dont use spaces in between the -/notthisdir/,.

define("DIRS_DEEP", 2); //Set this to how deep you wish to set your dir permissions for roles


/*Shouldnt touch these*/
define("INSTALL_DIR",  dirname($_SERVER["PHP_SELF"]));
define("INSTALL_ROOT",  dirname(__FILE__));
define("DOCUMENT_ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("FCK_PATH", INSTALL_DIR . "/includes/fckeditor/");


/*FCKeditor Upload Config*/
global $Config ;

// SECURITY: You must explicitly enable this "connector". (Set it to "true").
// WARNING: don't just set "$Config['Enabled'] = true ;", you must be sure that only
//		authenticated users can access this file or use some kind of session checking.
$Config['Enabled'] = true ;


// Path to user files relative to the document root.
$Config['UserFilesPath'] = UPLOAD_DIR ;

// Fill the following value it you prefer to specify the absolute path for the
// user files directory. Useful if you are using a virtual directory, symbolic
// link or alias. Examples: 'C:\\MySite\\userfiles\\' or '/root/mysite/userfiles/'.
// Attention: The above 'UserFilesPath' must point to the same directory.
$Config['UserFilesAbsolutePath'] = '' ;

// Due to security issues with Apache modules, it is recommended to leave the
// following setting enabled.
$Config['ForceSingleExtension'] = true ;

// Perform additional checks for image files.
// If set to true, validate image size (using getimagesize).
$Config['SecureImageUploads'] = true;

// What the user can do with this connector.
$Config['ConfigAllowedCommands'] = array('QuickUpload', 'FileUpload', 'GetFolders', 'GetFoldersAndFiles', 'CreateFolder') ;

// Allowed Resource Types.
$Config['ConfigAllowedTypes'] = array('File', 'Image', 'Flash', 'Media') ;

// For security, HTML is allowed in the first Kb of data for files having the
// following extensions only.
$Config['HtmlExtensions'] = array("html", "htm", "xml", "xsd", "txt", "js") ;

// After file is uploaded, sometimes it is required to change its permissions
// so that it was possible to access it at the later time.
// If possible, it is recommended to set more restrictive permissions, like 0755.
// Set to 0 to disable this feature.
// Note: not needed on Windows-based servers.
$Config['ChmodOnUpload'] = 0777 ;

// See comments above.
// Used when creating folders that does not exist.
$Config['ChmodOnFolderCreate'] = 0777 ;

/*
	Configuration settings for each Resource Type

	- AllowedExtensions: the possible extensions that can be allowed.
		If it is empty then any file type can be uploaded.
	- DeniedExtensions: The extensions that won't be allowed.
		If it is empty then no restrictions are done here.

	For a file to be uploaded it has to fulfill both the AllowedExtensions
	and DeniedExtensions (that's it: not being denied) conditions.

	- FileTypesPath: the virtual folder relative to the document root where
		these resources will be located.
		Attention: It must start and end with a slash: '/'

	- FileTypesAbsolutePath: the physical path to the above folder. It must be
		an absolute path.
		If it's an empty string then it will be autocalculated.
		Useful if you are using a virtual directory, symbolic link or alias.
		Examples: 'C:\\MySite\\userfiles\\' or '/root/mysite/userfiles/'.
		Attention: The above 'FileTypesPath' must point to the same directory.
		Attention: It must end with a slash: '/'

	 - QuickUploadPath: the virtual folder relative to the document root where
		these resources will be uploaded using the Upload tab in the resources
		dialogs.
		Attention: It must start and end with a slash: '/'

	 - QuickUploadAbsolutePath: the physical path to the above folder. It must be
		an absolute path.
		If it's an empty string then it will be autocalculated.
		Useful if you are using a virtual directory, symbolic link or alias.
		Examples: 'C:\\MySite\\userfiles\\' or '/root/mysite/userfiles/'.
		Attention: The above 'QuickUploadPath' must point to the same directory.
		Attention: It must end with a slash: '/'

	 	NOTE: by default, QuickUploadPath and QuickUploadAbsolutePath point to
	 	"userfiles" directory to maintain backwards compatibility with older versions of FCKeditor.
	 	This is fine, but you in some cases you will be not able to browse uploaded files using file browser.
	 	Example: if you click on "image button", select "Upload" tab and send image
	 	to the server, image will appear in FCKeditor correctly, but because it is placed
	 	directly in /userfiles/ directory, you'll be not able to see it in built-in file browser.
	 	The more expected behaviour would be to send images directly to "image" subfolder.
	 	To achieve that, simply change
			$Config['QuickUploadPath']['Image']			= $Config['UserFilesPath'] ;
			$Config['QuickUploadAbsolutePath']['Image']	= $Config['UserFilesAbsolutePath'] ;
		into:
			$Config['QuickUploadPath']['Image']			= $Config['FileTypesPath']['Image'] ;
			$Config['QuickUploadAbsolutePath']['Image'] 	= $Config['FileTypesAbsolutePath']['Image'] ;

*/

$Config['AllowedExtensions']['File']	= array('7z', 'aiff', 'asf', 'avi', 'bmp', 'csv', 'doc', 'fla', 'flv', 'gif', 'gz', 'gzip', 'jpeg', 'jpg', 'mid', 'mov', 'mp3', 'mp4', 'mpc', 'mpeg', 'mpg', 'ods', 'odt', 'pdf', 'png', 'ppt', 'pxd', 'qt', 'ram', 'rar', 'rm', 'rmi', 'rmvb', 'rtf', 'sdc', 'sitd', 'swf', 'sxc', 'sxw', 'tar', 'tgz', 'tif', 'tiff', 'txt', 'vsd', 'wav', 'wma', 'wmv', 'xls', 'xml', 'zip') ;
$Config['DeniedExtensions']['File']		= array() ;
$Config['FileTypesPath']['File']		= $Config['UserFilesPath'] . 'file/' ;
$Config['FileTypesAbsolutePath']['File']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'].'file/' ;
$Config['QuickUploadPath']['File']		= $Config['UserFilesPath'] ;
$Config['QuickUploadAbsolutePath']['File']= $Config['UserFilesAbsolutePath'] ;

$Config['AllowedExtensions']['Image']	= array('bmp','gif','jpeg','jpg','png') ;
$Config['DeniedExtensions']['Image']	= array() ;
$Config['FileTypesPath']['Image']		= $Config['UserFilesPath'] . 'image/' ;
$Config['FileTypesAbsolutePath']['Image']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'].'image/' ;
$Config['QuickUploadPath']['Image']		= $Config['UserFilesPath'] ;
$Config['QuickUploadAbsolutePath']['Image']= $Config['UserFilesAbsolutePath'] ;

$Config['AllowedExtensions']['Flash']	= array('swf','flv') ;
$Config['DeniedExtensions']['Flash']	= array() ;
$Config['FileTypesPath']['Flash']		= $Config['UserFilesPath'] . 'flash/' ;
$Config['FileTypesAbsolutePath']['Flash']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'].'flash/' ;
$Config['QuickUploadPath']['Flash']		= $Config['UserFilesPath'] ;
$Config['QuickUploadAbsolutePath']['Flash']= $Config['UserFilesAbsolutePath'] ;

$Config['AllowedExtensions']['Media']	= array('aiff', 'asf', 'avi', 'bmp', 'fla', 'flv', 'gif', 'jpeg', 'jpg', 'mid', 'mov', 'mp3', 'mp4', 'mpc', 'mpeg', 'mpg', 'png', 'qt', 'ram', 'rm', 'rmi', 'rmvb', 'swf', 'tif', 'tiff', 'wav', 'wma', 'wmv') ;
$Config['DeniedExtensions']['Media']	= array() ;
$Config['FileTypesPath']['Media']		= $Config['UserFilesPath'] . 'media/' ;
$Config['FileTypesAbsolutePath']['Media']= ($Config['UserFilesAbsolutePath'] == '') ? '' : $Config['UserFilesAbsolutePath'].'media/' ;
$Config['QuickUploadPath']['Media']		= $Config['UserFilesPath'] ;
$Config['QuickUploadAbsolutePath']['Media']= $Config['UserFilesAbsolutePath'] ;

?>
