<div id="flyspeck_loginmenu">
<strong>Welcome <?php echo $this->fullname;?></strong>
<p>
<button onclick="<?php echo $this->logOut;?>">Logout</button>
</p>
<?php include $this->loadTemplate('errors.php') ?>
</div>
<div id="ajaxnotif" style="display:none"><?php include $this->loadTemplate('errors.php') ?></div>