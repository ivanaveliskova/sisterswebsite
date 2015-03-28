<?php

/**
  *	File class provides a wrapper around filesystem file functions
  *	@class		File
  *	@version	0.4.1
  */

class File {

	// protected variables
	var $filename;
	var $fileOpenMode;
	var $fileOpenModeRead;
	var $fileOpenModeReadWrite;
	var $fileOpenModeWrite;
	var $fileOpenModeWriteRead;
	var $fileOpenModeAppend;
	var $fileOpenModeAppendRead;
	var $connected;
	var $handleID;

	/**
	  *	Constructor accepts filename (optional) and open mode (optional, default "r")
	  *	If filename is specified, it is opened with the supplied open mode
	  *	@method 	File
	  *	@param		optional string filename
	  *	@param		optional string fileOpenMode
	  */
	function File($filename = "", $fileOpenMode = "r") {
		$success = true;
		$this->filename = $filename;
		$this->fileOpenMode = $fileOpenMode;
		$this->fileOpenModeRead = "r";
		$this->fileOpenModeReadWrite = "r+";
		$this->fileOpenModeWrite = "w";
		$this->fileOpenModeWriteRead = "w+";
		$this->fileOpenModeAppend = "a";
		$this->fileOpenModeAppendRead = "a+";
		$this->connected = false;
		$this->handleID = false;
		if($this->filename != "") {
			$success = $this->open($this->filename, $this->fileOpenMode);
		}
		return $success;
	}

		/**
	  *	Opens a file with the supplied open mode
	  *	@method		open
	  *	@param		string filename
	  *	@param		optional string fileOpenMode
	  *	@returns	true if successful, false otherwise
	  */
	function open($filename, $mode = "r") {
		$success = false;
		if(!$this->connected) {
			$this->handleID = fopen($filename, $mode);
			if($this->handleID !== false) {
				$this->filename = $filename;
				$this->fileOpenMode = $mode;
				$this->connected = true;
				$success = true;
			}
		}
		return $success;
	}

	/**
	  *	Closes open file handle, resets filename, and file open mode to defaults
	  *	@method		close
	  *	@returns	true if successful, false otherwise
	  */
	function close() {
		$success = fclose($this->handleID);
		if($success) {
			$this->filename = "";
			$this->fileOpenMode = "r";
			$this->connected = false;
			$this->handleID = false;
		}
		return $success;
	}


	function truncate() {
		$success = ftruncate($this->handleID,0);
		return $success;
	}

	/**
	  *	Returns file contents, optionally specify chunk size number of bytes to use per chunk read (default 8192)
	  *	@method		getContents
	  *	@param		optional int chunkSize
	  *	@returns	string file contents if successful, false otherwise
	  */
	function getContents() {
		if($this->connected) {
			/*
			$fileContents = "";
			do {
				$data = fread($this->handleID, $chunkSize);
				print_r ($data);
				if (strlen($data) == 0) {
					break;
				}
				$fileContents .= $data;
			} while(true);
			return $fileContents;*/
		 clearstatcache();
          if ($fsize = @filesize($this->filename)) {
              $data = fread($this->handleID, $fsize);
          } else {
              $data = '';
              while (!feof($this->handleID)) {
                  $data .= fread($this->handleID, 8192);
              }
          }
          return $data;
		} else{
			return false;
		}
	}

	/**
	  *	Returns file contents as an array of lines
	  *	@method		getContentsArray
	  *	@returns	array file contents lines
	  */
	function getContentsArray() {
		$fileContentsArray = file($this->filename);
		return $fileContentsArray;
	}



	/**
	  *	Writes supplied string content to already open file handle
	  *	@method		write
	  *	@param		string strContent
	  *	@returns	number of bytes written if successful, false otherwise
	  */
	function write($strContent) {
		$bytesWritten = fwrite($this->handleID, $strContent, strlen($strContent));
		return $bytesWritten;
	}




}

?>
