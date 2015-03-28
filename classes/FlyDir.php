<?php
class FlyDir {
	function getDir($path = "", $types = 1, $levels = DIRS_DEEP, $aFilter = "/.*/") {
		//  returns an array of the specified files/directories
		//  start search in $path (defaults to current working directory)
		//  return $types:  2 => files; 1 => directories; 3 => both;
		//  $levels: 1 => look in the $path only; 2 => $path and all children;
		//          3 => $path, children, grandchildren; 0 => $path and all subdirectories;
		//          less than 0 => complement of -$levels, OR everything starting -$levels down
		//                e.g. -1 => everthing except $path; -2 => all descendants except $path + children
		//  Remaining argument(s) is(are) a filter array(list) of regular expressions which operate on the full path.
		//    First character (before the '/' of the regExp) '-' => NOT.
		//    First character (after a possible '-') 'd' => apply to directory name
		//    The filters may be passed in as an array of strings or as a list of strings
		//  Note that output directories are prefixed with a '*' (done in the line above the return)
		$dS = "/";
		//if (!($path = realpath($path?$path:getcwd()))) return array();    // bad path
		// next line rids terminating \ on drives (works since c: == c:\ on PHP).  OK in *nix?
		if (substr($path, -1) == $dS)
			$path = substr($path, 0, -1);
		if (is_null($types))
			$types = 2;
		if (is_null($levels))
			$levels = 1;
		if (is_null($aFilter))
			$aFilter = "";

		// last argument may be passed as a list
		$aFilter = explode(",", $aFilter);
		$adFilter = array ();
		// now move directory filters to separate array:
		foreach ($aFilter as $i => $filter)
			// for each directory filter...
			if (($pos = strpos(" $filter", "d")) && $pos < 3) {
				// next line eliminates the 'd'
				$adFilter[] = substr($filter, 0, $pos -1) . substr($filter, $pos);
				unset ($aFilter[$i]);
			}
		// reset indeces
		$aFilter = array_merge($aFilter);

		// results, $aAcc is an Accumulator
		$aRes = array ();

		// dirs to check
		$aDir = array (
			$path
		);

			for ($i = $levels > 0 ? $levels++ : -1;($aAcc = array ()) || $i-- && $aDir; $aDir = $aAcc)
			while ($dir = array_shift($aDir))
				//$dir = str_replace("\\" , "/" , $dir) ;

				foreach ($this->scandirfly($dir) as $fileOrDir)
					if ($fileOrDir != "." && $fileOrDir != "..") {
						if ($dirP = is_dir($rp = "$dir$dS$fileOrDir"))
							$rp = str_replace(DOCUMENT_ROOT, "", $rp);
						if ($this->pathFilter($rp, $adFilter))
							$aAcc[] = $rp;
						if ($i < $levels -1 && ($types & (2 - $dirP)))
							if ($this->pathFilter($rp, $aFilter))
								$base = str_replace(DOCUMENT_ROOT, "", $rp);
						$base = (isset ($base)) ? $base : '';
						$aRes[$base] = $base;
					}
		return $aRes;
	}

	function scandirfly($dir = './', $sort = 0) {
		$dir_open = opendir($dir);

		if (!$dir_open)
			return false;

		while (($dir_content = readdir($dir_open)) !== false)
			$files[] = $dir_content;

		if ($sort == 1)
			rsort($files, SORT_STRING);
		else
			sort($files, SORT_STRING);

		return $files;
	}

	function pathFilter($path, $aFilter) {
		// returns true if $path survives the tests from $aFilter
		// $aFilter is an array of regular expressions: [-]/regExp/modifiers
		// if there is a leading '-' it means exclude $path upon a match (a NOT test)
		// If the first expression has a leading '-', $path is in, unless it gets excluded.
		// Otherwise, $path is out, unless it gets included via the filter tests.
		// The tests are applied in succession.
		// A NOT test is applied only if $path is currently (within the tests) included
		// Other tests are applied only if $path is currently excluded.  Thus,
		// array("/a/", "-/b/", "/c/") => passes if $path has a c or if $path has an a but no b
		// array("/a/", "/c/", "-/b/") => passes if $path has an a or c, but no b
		// array("-/b/", "/a/", "/c/") => passes if $path has no b, or if $path has an a or c
		// automatic inclusion (pass) if no filters
		if (!$aFilter)
			return true;
		// we don't know how it's indexed
		foreach ($aFilter as $filter)
			break;
		// initial in/exclusion based on first filter
		$in = $filter[0] == "-";
		foreach ($aFilter as $filter)
			// walk the filters

			if ($in == $not = ($filter[0] == "-"))
				// testing only when necessary
				// flip in/exclusion upon a match
				$in ^= preg_match(substr($filter, $not), $path);
		return $in;
	}
}

class read_full_dir {
	var $dir_tree;
	/*================================================
	   class constructor
	   ================================================*/
	function read_full_dir($path_to_dir, $depthlimit) {
		$this->read_directory($path_to_dir, $depthlimit);
	}
	/*================================================
	    reads the full directory tree and store it in
	    $dir_tree
	   ================================================*/
	function read_directory($directory, $depthlimit, $depthcounter) {
		if ($handle = @ opendir($directory)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != ".." && $file != ".") {
					if (is_dir($directory . '/' . $file) && ($depthcounter < $depthlimit || $depthlimit == 0) ) {
						$this->dir_tree[$file] = $directory . '/' . $file;
						$this->read_directory($directory . '/' . $file, $depthlimit, $depthcounter+1);
					} else {
						$$this->dir_tree[$file][] = $directory . '/' . $file;
					}
				}
			}
		}
	}

}
?>
