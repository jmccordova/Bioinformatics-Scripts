<?php 
	/**
	*	Get frequent patterns in a genome
	*	Use in commandline: php Exer1.2.2 <filname/genome> <pattern>
	*
	*/

	if($argc != 3) {
		echo "Expects only two parameters <filename/genome> and <length>.";
		die();
	} else if ($argc == 3 && (!is_string($argv[1]) || !is_file($argv[1]) || !is_int($argv[2])) && $argv[2] <= 0) {
		echo "First parameter should be a file or genome string. Second parameter should be a counting number.";
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
	*	After counting, this function keeps the elements that have the highest occurrence; delete if not
	*	@param freqMap AssociativeArray
	*	@return freqMap AssociativeArray
	*/
	function maxMap($freqMap) {
		$max = max($freqMap);
		foreach ($freqMap as $key => $value) {
			if($value < $max) unset($freqMap[$key]);
		}

		return $freqMap;
	}

	function getFrequentWords($genome, $patternLength) {
		$freqPatterns = array();
		$freqMap = frequencyTable($genome, $patternLength);
		$max = maxMap($freqMap);

		return $max;
	}

	$filename = isset($argv) ? $argv[1] : "./Vibrio_cholerae.txt";
	$patternLength = isset($argv) ? $argv[2] : 5;
	$freqMap = array();

	if(is_file($filename)) {
		$file = fopen($filename, "r");
		while(!feof($file)) {
			$genome = fgets($file);
			$freqMap = getFrequentWords($genome, $patternLength);

		}
		fclose($file);
	} else {
		$freqMap = getFrequentWords($filename, $patternLength);
	}

	foreach ($freqMap as $key => $value) {
		echo $key . "\n";
	}
?>