<?php
$event = (isset($_GET['event'])) ? $_GET['event'] : '';
if ($event !='saveAsNewPage') {
?>
<div id="flyspeck_topnav">
	<ul>
		<?php if (SITEBROWSER == true)  { ?>
		<li><a href="<?php echo INSTALL_DIR?>/index.php?event=siteBrowser"><?php $this->plugin ( 'translate' , 'Site Browser'); ?></a></li>
		<?php } ?>
		<?php if ($_SESSION['rolename'] == "Admin" || $_SESSION['rolename'] == "admin") { ?>
		<li><a href="<?php echo INSTALL_DIR?>/index.php?event=usersManager"><?php $this->plugin ( 'translate' , 'User Manager'); ?></a></li>
		<li><a href="<?php echo INSTALL_DIR?>/index.php?event=rolesManager"><?php $this->plugin ( 'translate' , 'Role Manager'); ?></a></li>
		<?php } ?>
		<li><a href="<?php if (isset($_SESSION['file'])){ echo $_SESSION['file'];} else { echo "/";}?>"><?php $this->plugin ( 'translate' , 'Return to Site');?></a></li>
		<li><a href="<?php echo INSTALL_DIR?>/index.php?event=logOut&logout=true&redir=<?php echo INSTALL_DIR?>"><?php $this->plugin ( 'translate' , 'Logout');?></a></li>
	</ul>

	<div style="float:right; margin-right:1em;margin-top:5px;">
	<em><?php $this->plugin ( 'translate' , 'Welcome');?> <?php echo $_SESSION['fullname']?> <?php $this->plugin ( 'translate' , 'you are in the role');?> <?php echo $_SESSION['rolename']?></em>
	</div>
</div>
<?php }?>
<p>&nbsp;</p>
