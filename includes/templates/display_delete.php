<?php  if (!isset($_REQUEST['Confirm'])): ?>
<h2>Delete From <?php echo ucfirst($this->defName)?></h2>
<p>Are you sure you want to delete record #<?php echo $this->id ?> from <?php echo $this->defName?> ?
<?php $this->plugin ( 'form' , 'start', array('name'=>'delete'.$this->defName, 'action'=>$this->post_url) )?>
<?php 

		print "<input type=\"submit\" value=\"$this->submit_value\">";
		$this->plugin ( 'form' , 'hidden' , "Confirm", "1");
		$this->plugin ( 'form' , 'hidden' , "id", $this->id);
		$this->plugin ( 'form' , 'hidden' , "defName", $this->defName);

?>
<?php  $this->plugin ( 'form' , 'end' ); ?>
<?php  else: ?>
	<?php if (isset($this->success) && $this->success == true):?>
	
	<h2><?php echo ucfirst($this->defName)?> Deleted</h2>
	<p><?php echo substr(0,-1,ucfirst($this->defName))?> Deleted Successfully</p>
	<?php  else:?>
	<h2>An error has occurred deleting your <?php echo substr(0,-1,ucfirst($this->defName))?></h2>
	<?php  endif; ?>
	<a href="<?php echo INSTALL_DIR?>/index.php?event=<?php echo $this->defName?>Manager">Return to <?php echo ucfirst($this->defName)?> Manager</a>
<?php  endif; ?>