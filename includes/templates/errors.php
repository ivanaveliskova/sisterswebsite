<?php if($this->errors) : ?>
<ul id="fly-ajaxnotice">

	<?php foreach($this->errors['fatals'] as $fatal): ?>
	<li class="flyspeck_fatal">Fatal Error: <?php $this->plugin ( 'translate' ,  $fatal); ?></li>
	<?php endforeach;?>

	<?php foreach($this->errors['warnings'] as $warning): ?>
	<li class="flyspeck_warning"><?php $this->plugin ( 'translate' , $warning); ?></li>
	<?php endforeach;?>


	<?php foreach($this->errors['notices'] as $notice): ?>
	<li class="flyspeck_notice"><?php $this->plugin ( 'translate' , $notice); ?></li>
	<?php endforeach;?>

</ul>
<?php endif; ?>
