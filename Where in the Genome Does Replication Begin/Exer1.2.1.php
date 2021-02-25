<?php 
	/**
	*	Counts occurrence of a pattern in a genome
	*	Use in commandline: php Exer1.2.1 <filname/genome> <pattern>
	*
	*/

	if($argc != 3) {
		echo "Expects only two parameters <filename/genome> and <pattern>.";
		die();
	} else if ($argc == 3 && (!is_string($argv[1]) || !is_file($argv[1]) || !is_string($argv[2]))) {
		echo "First parameter should be a file or genome string. Second parameter should be a string pattern.";
		die();
	}

	/**
	*	Given a genome string and pattern to look for, the function counts how many times the patterns exists in a string.
	*	@param genome String
	*	@param pattern String
	*	@return count Integer
	*/
	function patternCount($genome, $pattern) {
		$count = 0;
		$genomeLength = strlen($genome);
		$patternLength = strlen($pattern);
		$probeLength = $genomeLength - $patternLength;
		for($i=0; $i<=$probeLength; $i++) {
			if(substr($genome, $i, $patternLength) == $pattern) {
				$count++;
			}
		}

		return $count;
	}

	$filename = isset($argv) ? $argv[1] : "./Vibrio_cholerae.txt";
	$pattern = isset($argv) ? strtoupper($argv[2]) : "GCGCG";

	if(is_file($filename)) {
		$file = fopen($filename, "r");
		while(!feof($file)) {
			$genome = strtoupper(fgets($file));
			echo "{$pattern} occured " . patternCount($genome, $pattern) . " time/s.";
		}
		fclose($file);
	} else {
		echo "{$pattern} occured " . patternCount(strtoupper($filename), $pattern) . " time/s.";
	}
?>