<h2>Site Browser</h2>
<p>Click a folder link to go into the folder, or a file link to edit.</p>

<ul>
<?php $upfolder = str_replace('\\', '/' , dirname($this->folder)) ?>
<?php if ($this->folder != "/"  )  { ?>
<a href="<?php echo INSTALL_DIR?>/index.php?event=siteBrowser&folder=<?php echo $upfolder;?>">[.. Up a folder]</a>
<?php }?>
<?php
foreach ($this->dirdata as $item) {
	if (substr_count( $item , ".") == 0) {
	$folders[] = $item;
	} else {
	//We have file
	$files[] = $item;
	}
}
//$files = (isset($files) ? $files : '');
	if (isset($folders) && count($folders)>0) {
		foreach ($folders as $folder) {
			print "<li style=\"list-style-image:url(".INSTALL_DIR."/includes/images/folder.gif)\">";
			print '<a href="'.INSTALL_DIR.'/index.php?event=siteBrowser&folder='.$folder.'">';
			print $folder;
			print '</a>';
			print "</li>";
		}
	}
	if (isset($files) && count($files)>0) {
		foreach ($files as $file) {
			print "<li style=\"list-style-image:url(".INSTALL_DIR."/includes/images/file.jpg)\">";
			print '<a href="'.$file.'">';
			print $file;
			print "</a>";
			print "</li>";
		}
	}
?>
</ul>