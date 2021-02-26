<?php 
	/**
	*	Clump finding problem
	*	Use in commandline: php Exer1.2.1 <filname/genome> <patternLength> <fixed string length L> <number of times t>
	*
	*/

	if($argc != 5) {
		echo "Expects only four parameters: <String filename/genome>, <String pattern>, <int length>, and <int times>.";
		die();
	} else if ($argc == 5 && 
		(!is_string($argv[1]) || 	
		(!is_int($argv[2]) && $argv[2] <= 0) || 
		(!is_int($argv[3]) && $argv[3] <= 0) || 
		(!is_int($argv[4]) && $argv[4] <= 0))) {
		echo "First parameter should be a file or genome string.\nSecond, third, and fourth parameter should be a non-negative integer.";
		die();
	}

	/**
	*	Given a genome string and the length of a pattern, the function builds a map of substrings and the number of times the said substring exists.
	*	@param genome String
	*	@param patternLength Integer
	*	@return freqMap AssociativeArray
	*/
	function frequencyTable($genome, $patternLength) {
		$freqMap = array();
		$genomeLength = strlen($genome);
		$probeLength = $genomeLength - $patternLength;
		for($i=0; $i<=$probeLength; $i++) {
			$pattern = substr($genome, $i, $patternLength);
			if(!array_key_exists($pattern, $freqMap)) 
				$freqMap[$pattern] = 1;
			else
				$freqMap[$pattern]++;
		}

		return $freqMap;
	}

	/**
	*	Given a substring of length L, find a pattern that exists t times
	*	@param genome String
	*	@param patternLength Integer
	*	@param L Integer
	*	@param t Integer
	*	@return patterns Array
	*/
	function findClumps($genome, $patternLength, $L, $t) {
		$patterns = array();
		$genomeLength = strlen($genome);
		$probeLength = abs($genomeLength - $L);
		for($i=0; $i<=$probeLength; $i++) {
			$freqMap = frequencyTable(substr($genome, $i, $L), $patternLength);
			foreach ($freqMap as $key => $value) {
				if($value >= $t && !in_array($key, $patterns)) $patterns[] = $key;
			}
		}

		return $patterns;
	}

	$filename = isset($argv) ? $argv[1] : "./Vibrio_cholerae.txt";
	$patternLength = isset($argv) ? $argv[2] : 5;
	$L = isset($argv) ? $argv[3] : 500;
	$t = isset($argv) ? $argv[4] : 4;
	$freqMap = array();

	if(is_file($filename)) {
		$file = fopen($filename, "r");
		while(!feof($file)) {
			$genome = fgets($file);
			$freqMap = findClumps($genome, $patternLength, $L, $t);
			$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
		}
		fclose($file);
	} else {
		$freqMap = findClumps($filename, $patternLength, $L, $t);
	}

	foreach ($freqMap as $value) {
		echo $value . " ";
	}

	echo "Process time: " . $time;
?>