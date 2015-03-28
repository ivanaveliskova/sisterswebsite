<script type="text/javascript">opener.flyspeckGenerator.saveContent();</script>
<?php
$filename = (substr($_GET['filename'] , -1) == '/' ) ? $_GET['filename'] . DEFAULT_DOCUMENT : $_GET['filename'];
$path_parts = pathinfo($filename);
?>
<h3>Save as New Page</h3>
<p>This will save a copy of this page at the same directory level as this page.</p>
<?php
	$this->plugin ( 'form' , 'start', array('name'=>'saveAsNewPage', 'action'=>''.INSTALL_DIR.'/index.php?event=saveNewPage' , 'onsubmit'=>'javascript:return limitAttach( new Array(\'.'.$path_parts['extension'].'\'), document.forms[\'saveAsNewPage\'])' ));
	$this->plugin ( 'form' , 'label' , "File Name" );
	$this->plugin ( 'form' , 'text', 'fileName' );
	$origfile = substr($_GET['filename'] , -1) == '/' ? $_GET['filename'] . DEFAULT_DOCUMENT : $_GET['filename'];
	$this->plugin ( 'form' , 'hidden', 'originalfile', $origfile );
	$this->plugin ( 'form' , 'text', 'hid', '', '','style="visibility:hidden"' );
	$this->plugin ( 'form' , 'submit' , 'savenew', 'Save New Page');
	$this->plugin ( 'form' , 'end' );
?>