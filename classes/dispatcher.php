<?php
# A class implementing an event driven web programming paradigm
# in php
class dispatcher {

    # The name of the GET or POST variable which
    # holds the event name
    var $event_var;

    # Must not ever call these methods as an event
    var $bad_method_names;

    function dispatcher(){

        # Set vars to default values:
        # can be overridden by child class

        $this->event_var='event';

        $this->bad_method_names = array(
                'dispatcher' => TRUE,
                'dispatch' => TRUE,
                '_isa_child_class_method' => TRUE,
                'url' => TRUE
        );

		$this->bad_method_names[get_class($this)] = TRUE;
    }

    function dispatch(){

        # Determine which event to call: first look in CGI GET
        # variables, then in POST variables, and if not found
        # call the 'main' event

        if (
            array_key_exists($this->event_var,$_GET) && 
            $_GET[$this->event_var] != '' &&
            $this->_isa_child_class_method($_GET[$this->event_var])
        ){
            $event = $_GET[$this->event_var];
        } elseif (
            array_key_exists($this->event_var,$_POST) && 
            $_POST[$this->event_var] != '' &&
            $this->_isa_child_class_method($_POST[$this->event_var])
        ){
            $event = $_POST[$this->event_var];
        } else {
            $event = 'main';
        }

        # Invoke event; Make method call
        $this->$event();

    }
    


    function _isa_child_class_method($method){
        
        # 1. Make sure method is not a _bad_ name. 
        # 2. Make sure that the object's parent is dispatcher
        # 3. Make sure method exists

        if (array_key_exists($method,$this->bad_method_names)){
            return FALSE;
        } elseif ( 
            get_parent_class($this) == 'dispatcher' &&
            method_exists($this,$method)
        ){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function url($event='',$cgi_get_vars=NULL,$path_info='',$id=''){

		# Programmer 'asleep at the wheel' check
		if (! $this->_isa_child_class_method($event)){
			exit("Oops! $event is not a child class method");
		}

       //I removed this because of cgi issues.
       //$url = $_SERVER['SCRIPT_NAME'];
        $url = $_SERVER['PHP_SELF'];


        if ($path_info != ''){
            $url .= '/' . urlencode($path_info);
        }

        if (!is_array($cgi_get_vars)){
            $cgi_get_vars = array();
        }
        if ($event!='') {
            $cgi_get_vars[$this->event_var] = $event;
        }
        foreach ($cgi_get_vars as $key => $val){
            $vars[] = urlencode($key) . '=' . urlencode($val);
        }
        $url .= '?' . implode("&",$vars);

        if ($id != ''){
            $url .= '#' . urlencode($id);
        }

        return $url;
    }
    
function &errorHandler($errno='', $errstr='', $errfile='', $errline='')
{
	static $error_list = array();
    switch ($errno) {
    case E_USER_ERROR:
//        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
//        echo "  Fatal error on line $errline in file $errfile";
//        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
//        echo "Aborting...<br />\n";
//        exit(1);
		$error_list['fatals'][] = $errstr . $errfile . $errline;
        break;

    case E_USER_WARNING:
       // echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        $error_list['warnings'][] = $errstr;// . $errfile . $errline;
        break;

    case E_USER_NOTICE:
        //echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        $error_list['notices'][] = $errstr;// . $errfile . $errline;
        break;

    default:
        //echo "Unknown error type: [$errno] $errstr<br />\n";
        //$error_list['unknown'][] = $errno . $errstr . $errfile . $errline;
        break;
    }

    /* Don't execute PHP internal error handler */
    return $error_list;
}
}
?>
