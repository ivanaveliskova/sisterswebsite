<?php
header("Content-type: text/css");
require "../config.php";
?>
/*wholeTopBar*/
#wholeDiv { width:100%; position:absolute; text-align:left; z-index:1000 !important;  }
*html #flycontentdiv {position:absolute; margin-top:20px;}

/*Toolbar*/
#xToolbar {width:100% }

.flybodyclass { height: auto;}

/*flynav*/
#flynav td {padding-left: 2px; padding-right: 2px}

/*TopNav*/
#flyspeck_topnav { width:100%; font-family:verdana; float:left; background: whitesmoke; border:1px solid gray; clear:both;}
#flyspeck_topnav table { font-size: 10pt;}
#flyspeck_topnav a {color:navy; text-decoration: none; display:block; padding: 0.25em; border:1px solid whitesmoke; }
#flyspeck_topnav a:hover {background-color:white; border:1px solid gray}
#flyspeck_topnav label {float:left;}

/*contentdiv*/
div#flycontentdiv {margin-top:150px}

/* LoginMenu */
#flyspeck_logindiv {clear:both;}
#flyspeck_loginmenu {font-size: 9pt; font-family: verdana; text-align:left; background-color:whitesmoke; border: 1px solid black; width:150px; padding: 10px}
#flyspeck_loginmenu form { font-size: 9pt; font-family: verdana}
#flyspeck_loginmenu label {color:black; display:block; margin-top:1em}

/*errors*/
li.flyspeck_fatal {list-style-image: url(<?php echo INSTALL_DIR?>/images/app-delete-32x32.png)}
li.flyspeck_warning {list-style-image: url(<?php echo INSTALL_DIR?>/images/bt-attention-32x32.png)}
li.flyspeck_notice {list-style-image: url(<?php echo INSTALL_DIR?>/images/app-upload-32x32.png)}

/*Ajaxnotif*/
#ajaxnotif {font-family: verdana;}

/*Return*/
#exitdiv {position:absolute; z-index:1000 !important;  }
#exitpreview {position:absolute; z-index:1000 !important; font-family: verdana; font-size: 10pt; border:1px solid black; width:14px; height: 14px;  display:block;  top:5px; left:5px; background-color:whitesmoke; background-image:url(<?php echo INSTALL_DIR?>/images/return.png); background-repeat:no-repeat; padding:6px;}

*html #exitpreview {width: 27px; height: 27px; z-index:1000 !important; }
