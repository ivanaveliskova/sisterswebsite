<div id="flyspeck_topnav">
	<table style="clear:both; border-bottom: 1px solid gainsboro; width:100%">
	<tr>
	<td>
		<table cellpadding="0" cellspacing="0" id="flynav">
		<tr>
		<td width="20">
		<img src="<?php echo INSTALL_DIR?>/includes/images/flyicon.png">
		</td>
			<td>
			<a href="javascript:flyspeckGenerator.saveContent();"><?php $this->plugin ( 'translate' , 'Publish Page'); ?></a></td>
			<td>
			<a href="javascript:flyspeckGenerator.previewContent();"><?php $this->plugin ( 'translate' , 'Preview Page'); ?></a>
			</td>
			<?php  if (SAVE_PAGE_AS == true)  { ?>
			<td><a href="javascript:openW('<?php echo INSTALL_DIR?>/index.php?event=saveAsNewPage&filename=<?php echo $this->filename?>','Save',400,400,'')"><?php $this->plugin ( 'translate' , 'Save as New Page');?></a></td>
			<?php }?>
			<?php if (SITEBROWSER == true)  { ?>
			<td><a href="<?php echo INSTALL_DIR?>/index.php?event=siteBrowser"><?php $this->plugin ( 'translate' , 'Site Browser'); ?></a></td>
			<?php } ?>
	  		<?php if ($_SESSION['rolename'] == "Admin" || $_SESSION['rolename'] == "admin") { ?>
			<td><a href="<?php echo INSTALL_DIR?>/index.php?event=usersManager"><?php $this->plugin ( 'translate' , 'User Manager'); ?></a></td>
			<td><a href="<?php echo INSTALL_DIR?>/index.php?event=rolesManager"><?php $this->plugin ( 'translate' , 'Role Manager'); ?></a></td>
			<?php } ?>
			<td><a href="javascript:flyspeckGenerator.logoutfly();"><?php $this->plugin ( 'translate' , 'Logout'); ?></a></td>
			</tr>
		</table>
	</td>
	<td align="right" id="flyNotifications">
		<em><?php $this->plugin ( 'translate' , 'Welcome'); ?> <?php echo $_SESSION['fullname']?> <?php $this->plugin ( 'translate' , 'you are in the role'); ?> <?php echo $_SESSION['rolename']?></em>
	</td>
	</tr>
</table>
<?php include $this->loadTemplate('meta_display.php') ?>
</div>
