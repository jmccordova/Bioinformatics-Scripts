<?php 
	/**
	*	Get sum of differences among patterns
	*	Use in commandline: php Exer2.4.1 <file/pattern> <file/pattern>
	*
	*/

	if($argc != 3) {
		echo "Expects only two parameters <file/pattern> and <file/pattern>.";
		die();
	} else if ($argc == 3 && (!is_string($argv[1]) || !is_string($argv[2]))) {
		echo "First and second parameter should be either a file or genome string.";
		die();
	}

	/**
	*	Traverse the whole genome and compute the sum for every different nucleotide
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

	$filename1 = isset($argv) ? $argv[1] : "./Vibrio_cholerae.txt";
	$filename2 = isset($argv) ? $argv[2] : "./Vibrio_cholerae.txt";
	$genome1 = $genome2 = '';

	if(is_file($filename1)) {
		$file = fopen($filename1, "r");
		while(!feof($file)) {
			$genome1 = fgets($file);

		}
		fclose($file);
	} else {
		$genome1 = $filename1;
	}

	if(is_file($filename2)) {
		$file = fopen($filename2, "r");
		while(!feof($file)) {
			$genome2 = fgets($file);

		}
		fclose($file);
	} else {
		$genome2 = $filename2;
	}

	echo hammingDistance($genome1, $genome2);

?>