<?php

/**
* Base plugin class.
*/
require_once 'Plugin.php';
require_once "classes/get_languages.php";
require_once "classes/zbz/zbz5.php";


class Savant2_Plugin_translate extends Savant2_Plugin {

function plugin($text) {
$l = get_languages('data');
/*Determine which locale file we have matches best*/
$bestlocale = '';
foreach($l as $locale){
	//If the first member is a complete locale, it has a - right now I am just doing lang_LANG.
	$parts = explode("-", $locale[0]);
	$lang = $parts[0] .'_'.strtoupper($parts[0]);
	//If the file exists, use it.
	if(file_exists(ZBZ5_LANGUAGE_DIR.'/'.$lang.'.txt')){
		$bestlocale = $lang;
		break;
	}
}
if($bestlocale == ZBZ5_FALLBACK_LOCALE){
	return $text;
}

$trans = new zbz5Localizer($bestlocale);
return $trans->zbz5($text);
}

}

?>
