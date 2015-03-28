<?php

class Password 
{

function Password(){

	    // 3 different symbols (or combinations) for obfuscation 
	    // these should not appear within the original text 
	    $sym = array('¶', '¥xQ', '|'); 
	    foreach(range('a','z') as $key=>$val) 
	        $this->chars[$val] = str_repeat($sym[0],($key + 1)).$sym[1]; 
	    $this->chars[' '] = $sym[2]; 
	    unset($sym); 

}

// encrypt 
function encrypt($data) 
{ 
    $data = strtr(strtolower($data), $this->chars); 
    return $data; 
} 

// decrypt 
function decrypt($data) 
{ 
    $charset = array_flip($this->chars); 
    $charset = array_reverse($charset, true); 

    $data = strtr($data, $charset); 
    unset($charset); 
    return $data; 
}

function check($try, $password) {
	if ($this->decrypt($try) == $password) {
		return true;	
	} else {
		return false;	
	}
	
}

/*
$text = encrypt($text); 
echo 'encrypted: '.$text.'<br />'; 
// echo 'decrypted: '.decrypt($text);
*/ 
}





?>