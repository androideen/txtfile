<?php
namespace TLTemplates;

class TxtFile {	
	public $file;
	public $createFileIfNotExist;
	public $readMode;
	public $writeMode;


	function __construct($filePath, $createFileIfNotExist = false) {
		$this->file = $filePath;
		$this->readMode = 'r';
		if($createFileIfNotExist && !file_exists($filePath)){
			$this->readMode = 'w';
		}
		$this->writeMode = 'w';
	}

	/**
	* Read all content of a file
	* @return content as array 
	*/
	public function readAllAsArray(){		
		return $this->readAsArray(-1, -1);
	}

	/**
	* Read all content of a file
	* @return content as a string 
	*/
	public function readAllAsString(){
		return $this->readAsString(-1, -1);
	}

	/**
	* Read content of a file
	* @param int $fromLine starting line # to read from
	* @param int $toLine ending line # to read to
	* both params to be -1 to read all
	* @return content as string 
	*/
	public function readAsString($fromLine, $toLine) {
		if($fromLine > $toLine){
			return 'From Line should not larger than To Line';
		}
		$content = '';
		$fh = fopen($this->file, $this->readMode); 
		$index = 0;
		while ($line = fgets($fh)) {
			if(($index >= $fromLine && $index <= $toLine) || ($fromLine == -1 && $toLine == -1)){				
				$content .= $line;		
			}		  
			$index++;
			if($index > $toLine && ($toLine != -1))
				break;
		}		
		fclose($fh);			
		return $content;	
	}

	/**
	* Read content of a file
	* @param int $fromLine starting line # to read from
	* @param int $toLine ending line # to read to
	* both params to be -1 to read all
	* @return content as array 
	*/
	public function readAsArray($fromLine, $toLine) {
		if($fromLine > $toLine){
			return 'From Line should not larger than To Line';
		}
		$content = array();
		$fh = fopen($this->file, $this->readMode); 
		$index = 0;
		while ($line = fgets($fh)) {
			if(($index >= $fromLine && $index <= $toLine) || ($fromLine == -1 && $toLine == -1)){
				$content[] = $line;		
			}		  
			$index++;
			if($index > $toLine && ($toLine != -1))
				break;
		}	
		fclose($fh);
		return $content;
	}

	/**
	* Read all content of a file while removing blank lines
	* @param int $fromLine starting line # to read from
	* @param int $toLine ending line # to read to
	* @return content as array 
	*/
	public function readAllWithoutBlankLines(){	
		$content = $this->readAllAsArray();
		$result = array();
		foreach ($content as $key => $line) {
			if(trim($line) != ''){
				$result[] = $line;
			}
		}
		return $result;	
	}

	/**
	* Read all content of a file while removing duplicated lines
	* @param int $fromLine starting line # to read from
	* @param int $toLine ending line # to read to
	* @return content as array 
	*/
	public function readAllWithoutDuplicatedLines(){		
		$content = $this->readAllAsArray();
		$result = array();
		foreach ($content as $key => $line) {
			if(!in_array($line, $result)){
				$result[] = $line;	
			}	
		}
		return $result;			
	}

	/**
	* Write text to end of the file	
	*/
	public function append($text){			
		$this->save($this->readAllAsString().$text);	
	}

	/**
	* Write text as a line to the defined line
	* @param int $lineNo line # to append text to
	*/
	public function writeLineAt($lineNo, $text){
		$this->writeAt($lineNo, $text."\n");
	}

	/**
	* Write text to the defined line
	* @param int $lineNo line # to append text to
	*/
	public function writeAt($lineNo, $text){	
		$lines = $this->readAllAsArray();
		$content = '';
		foreach ($lines as $key => $line) {
			if($key == $lineNo){
				$content .= $text;
			}
			$content .= $line;
		}
		//append to last if lineNo exceed file's total lines
		if($lineNo > count($lines)){
			$content .= $text;	
		}
		$this->save($content);	
	}

	/**
	* save text to fole
	* @param string $content line # to append text to
	*/
	private function save($content){		
		$fh = fopen($this->file, $this->writeMode);		
		fwrite($fh, $content);
		fclose($fh);	
	}

	/**
	* empty text of a file	
	*/
	public function emptyFile(){
		$fh = fopen($this->file, $this->writeMode);
		fwrite($fh, '');
		fclose($fh);
	}
	
}
?>
