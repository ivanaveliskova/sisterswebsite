<?php

/**
* Base plugin class.
*/
require_once 'Plugin.php';

/**
*
* Modifies a value with a series of functions.
*
* $Id: Savant2_Plugin_modify.php,v 1.2 2005/08/09 22:19:39 pmjones Exp $
*
* @author Paul M. Jones <pmjones@ciaweb.net>
*
* @package Savant2
*
* @license LGPL http://www.gnu.org/copyleft/lesser.html
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as
* published by the Free Software Foundation; either version 2.1 of the
* License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful, but
* WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
*
*/

class Savant2_Plugin_ToJsObject extends Savant2_Plugin {



	function plugin($obj, $mixArray)
	{
		$props = get_object_vars($obj);
		if(is_array($mixArray)){
			$mergeObj = new stdClass;
			$merged = array_merge($props, $mixArray);
			$props = $merged;
		}
		$jsObj ='{';
		$i = 0;
		foreach($props as $propkey => $propval){
			$i++;
			$jsObj .= "'".$propkey."': '".$propval ."'";
			if($i != count($props)){
				$jsObj .= ', ';
			}
		}
		$jsObj .='}';

		return $jsObj;
	}

}
?>