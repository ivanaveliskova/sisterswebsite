<?php  if ($this->msg == TRUE): ?>
<h3>Save Successful</h3>
<p>You may  return to the 
<?php  if ($this->sitebrowser == 1): ?>
Site Browser
<?php else:?>
live site</p>
<?php endif;?>
<ul>
<?php  if ($this->sitebrowser == 1): ?>
<li><a href="<?php echo INSTALL_DIR;?>/index.php?&event=siteBrowser&folder=<?php echo dirname($this->file);?>"><?php echo $this->file?></a></li>
<?php else:?>
<li><a href="<?php  echo $this->file?>"><?php echo $this->file?></a></li>
<?php endif;?>
</ul>
<p>
or click "Edit Page" to see your changes and continue editing.
</p>
<?php  else:?>
<?php echo $this->msg;?>
<?php  endif; ?>