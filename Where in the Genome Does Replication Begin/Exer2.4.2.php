<?php 

	/**
	*	Returns index of where the pattern showed up based on a threshold
	*	Use in commandline: php Exer2.4.2 <pattern> <filname/genome> <d>
	*
	*/

	if($argc != 4) {
		echo "Expects only three parameters <pattern> <filename/genome> and <int d>.";
		die();
	} else if ($argc == 4 && 
		(!is_string($argv[1]) || 
		!is_string($argv[2]) || 
		(!is_int($argv[3]) && $argv[3] <= 0))) {
		echo "First parameter should be a string pattern.\nSecond parameter should be a file or genome string.\nThird parameter should be an integer.";
		die();
	}

	/*	Traverse the whole genome and compute the sum for every different nucleotide
	*	@param genome1 String
	*	@param genome2 String
	*	@return sum Integer
	*/
	function hammingDistance($genome1, $genome2) {
		$sum = 0;

		for($i=0; $i<strlen($genome1); $i++) {
			if(strtoupper($genome1[$i]) != strtoupper($genome2[$i]))
				$sum++;
		}

		return $sum;
	}

	/**
	*	Given a genome string and pattern to look for, the function lists where the pattern exist in a string. Acceptance is based on an error threshold.
	*	@param genome String
	*	@param pattern String
	*	@return count Integer
	*/
	function getIndices($pattern, $genome, $d) {
		$indices = [];
		$genomeLength = strlen($genome);
		$patternLength = strlen($pattern);
		$probeLength = $genomeLength - $patternLength;
		for($i=0; $i<=$probeLength; $i++) {
			$window = substr($genome, $i, $patternLength); 
			if(hammingDistance($window, $pattern) <= $d) {
				$indices[] = $i;
			}
		}

		return $indices;
	}

	$pattern = isset($argv[1]) ? strtoupper($argv[1]) : "GCGCG";
	$filename = isset($argv[2]) ? $argv[2] : "./Vibrio_cholerae.txt";
	$d = isset($argv[3]) ? $argv[3] : 3;
	$indices = [];

	if(is_file($filename)) {
		$file = fopen($filename, "r");
		while(!feof($file)) {
			$genome = strtoupper(fgets($file));
			$indices = getIndices($pattern, $genome, $d);
		}
		fclose($file);
	} else {
		$indices = getIndices($pattern, strtoupper($filename), $d);
	}

	echo "{$pattern} is found at index: ";
	foreach ($indices as $index) {
		echo $index . ' ';
	}
?>