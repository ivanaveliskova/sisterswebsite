<?php

/**
* Base plugin class.
*/
require_once 'Plugin.php';


class Savant2_Plugin_truncate extends Savant2_Plugin {

function plugin($text,$numb=80,$etc = "...") {
//$text = html_entity_decode($text, ENT_QUOTES);
if (strlen($text) > $numb) {
$text = substr($text, 0, $numb);
$text = substr($text,0,strrpos($text," "));

$punctuation = ".!?:;,-"; //punctuation you want removed

$text = (strspn(strrev($text),  $punctuation)!=0)
        ?
        substr($text, 0, -strspn(strrev($text),  $punctuation))
        :
$text;

$text = $text.$etc;
}
//$text = htmlentities($text, ENT_QUOTES);
return $text;
}

}

?>
