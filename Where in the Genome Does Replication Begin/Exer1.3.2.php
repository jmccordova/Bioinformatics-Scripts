<?php 
	/**
	*	Returns index of where the pattern showed up
	*	Use in commandline: php Exer1.3.2 <pattern> <filname/genome>
	*
	*/

	if($argc != 3) {
		echo "Expects only two parameters <pattern> and <filename/genome>.";
		die();
	} else if ($argc == 3 && (!is_string($argv[1]) || !is_string($argv[2]))) {
		echo "First parameter should be a string pattern. Second parameter should be a file or genome string.";
		die();
	}

	/**
	*	Given a genome string and pattern to look for, the function lists where the pattern exist in a string.
	*	@param genome String
	*	@param pattern String
	*	@return count Integer
	*/
	function getIndices($pattern, $genome) {
		$indices = [];
		$genomeLength = strlen($genome);
		$patternLength = strlen($pattern);
		$probeLength = $genomeLength - $patternLength;
		for($i=0; $i<=$probeLength; $i++) {
			if(substr($genome, $i, $patternLength) == $pattern) {
				$indices[] = $i;
			}
		}

		return $indices;
	}

	$pattern = isset($argv[1]) ? strtoupper($argv[1]) : "GCGCG";
	$filename = isset($argv[2]) ? $argv[2] : "./Vibrio_cholerae.txt";
	$indices = [];

	if(is_file($filename)) {
		$file = fopen($filename, "r");
		while(!feof($file)) {
			$genome = strtoupper(fgets($file));
			$indices = getIndices($pattern, $genome);
		}
		fclose($file);
	} else {
		$indices = getIndices($pattern, strtoupper($filename));
	}

	echo "{$pattern} is found at index: ";
	foreach ($indices as $index) {
		echo $index . ' ';
	}
?>