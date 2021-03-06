<?php 
	/**
	*	Counts occurrence of a pattern (accepts mismatches) in a genome
	*	Use in commandline: php Exer2.4.3 <filname/genome> <pattern> <length>
	*
	*/

	if($argc != 4) {
		echo "Expects exactly three parameters <filename/genome> <pattern> and <length>.";
		die();
	} else if ($argc == 4 && (!is_string($argv[1]) || !is_string($argv[2]) || !is_int($argv[3]) && $argv[3] < 0)) {
		echo "First and second parameter should be a file or genome string.\nThird parameter should be a non-negative integer.";
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
	*	Given a genome string and pattern to look for, the function counts how many times the patterns exists in a string.
	*	@param genome String
	*	@param pattern String
	*	@return count Integer
	*/
	function patternCount($genome, $pattern, $threshold) {
		$count = 0;
		$genomeLength = strlen($genome);
		$patternLength = strlen($pattern);
		$probeLength = $genomeLength - $patternLength;
		for($i=0; $i<=$probeLength; $i++) {
			$window = substr($genome, $i, $patternLength);
			if(hammingDistance($window, $pattern) <= $threshold) {

				$count++;
			}
		}

		return $count;
	}

	$filename = isset($argv) ? $argv[1] : "./Vibrio_cholerae.txt";
	$pattern = isset($argv) ? strtoupper($argv[2]) : "GCGCG";
	$threshold = isset($argv) ? strtoupper($argv[3]) : 0;

	if(is_file($filename)) {
		$file = fopen($filename, "r");
		while(!feof($file)) {
			$genome = strtoupper(fgets($file));
			echo "{$pattern} occured " . patternCount($genome, $pattern, $threshold) . " time/s.";
		}
		fclose($file);
	} else {
		echo "{$pattern} occured " . patternCount(strtoupper($filename), $pattern, $threshold) . " time/s.";
	}
?>