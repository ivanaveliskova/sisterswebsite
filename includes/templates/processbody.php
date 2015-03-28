<?php
/*This file is not used anymore*/
return;
$name = $this->matches[1];
$oFCKeditor = new FCKeditor($name) ;
$oFCKeditor->Config['CustomConfigurationsPath'] = INSTALL_DIR . '/includes/FlyspeckFckconfig.js';
$oFCKeditor->ToolbarSet = 'Flyspeck';
$oFCKeditor->BasePath = FCK_PATH;
$oFCKeditor->Config['ToolbarStartExpanded'] = true;
$oFCKeditor->Config['BaseHref'] = "http://" . $_SERVER['HTTP_HOST'] . dirname($this->filename) . '/';
$oFCKeditor->Config['EditorAreaCSS'] = $this->css;
$oFCKeditor->Config['ToolbarLocation'] = 'Out:xToolbar';
//$oFCKeditor->Config['ImageBrowserURL'] = FCK_PATH . 'editor/filemanager/browser/default/browser.html?Type=Image&Connector=connectors/php/connector.php&ServerPath='.IMAGES_DIR.'/' ;
//$oFCKeditor->Config['LinkBrowserURL'] = FCK_PATH . 'editor/filemanager/browser/default/browser.html?Type=File&Connector=connectors/php/connector.php&ServerPath='.UPLOAD_DIR.'/' ;
//$oFCKeditor->Config['FlashBrowserURL'] = FCK_PATH . 'editor/filemanager/browser/default/browser.html?Type=Flash&Connector=connectors/php/connector.php&ServerPath='.UPLOAD_DIR.'/' ;
//$oFCKeditor->Config['LinkUpload'] = false ;
//$oFCKeditor->Config['ImageUpload'] = false ;
$oFCKeditor->Config['StylesXmlPath'] = INSTALL_DIR . '/includes/fckstyles.xml' ;
$oFCKeditor->Config['TemplatesXmlPath']	= INSTALL_DIR . '/includes/fcktemplates.xml' ;

$oFCKeditor->Value = $this->matches[2];
$oFCKeditor->Create();
?>