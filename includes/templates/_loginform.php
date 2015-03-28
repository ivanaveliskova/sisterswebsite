<form name="authenticate" method="post" onsubmit="<?php echo $this->formonsubmit?>">
<label><?php $this->plugin ( 'translate' , 'Username'); ?></label>
<?php
$this->plugin('input', 'text', 'flyspeckUserName', '', array('id'=>'flyspeckUserName'))
?>
<label><?php $this->plugin ( 'translate' , 'Password'); ?></label>
<?php
$this->plugin('input', 'password', 'flyspeckPassWord', '', array('id'=>'flyspeckPassWord'));
?>
<p>
<button onclick="<?php echo $this->onsubmit?>"><?php $this->plugin ( 'translate' , 'Login'); ?></button>
</p>
<?php include $this->loadTemplate('errors.php') ?>
</form>