<?php 
	/**
	*	Get indices of ori (minimum)
	*	Use in commandline: php Exer2.3.1 <filname/genome>
	*
	*/

	if($argc != 2) {
		echo "Expects only one parameter <filename/genome>.";
		die();
	} else if ($argc == 2 && !is_string($argv[1])) {
		echo "First parameter should be a file or genome string.";
		die();
	}

	function getIndexOfMinimum($sumLine) {
		$min = min($sumLine);
		
		return array_keys($sumLine, $min);
	}

	/**
	*	Traverse the whole genome and compute the sum for every nucleotide that is either G or C
	*	@param genome String
	*	@return sumLine Array
	*/
	function computeLine($genome) {
		$sum = 0;
		$sumLine = array();

		$sumLine[] = $sum;
		for($i=0; $i<strlen($genome); $i++) {
			switch (strtoupper($genome[$i])) {
				case 'G':
					$sum++;
					break;
				case 'C':
					$sum--;
					break;
			}

			$sumLine[] = $sum;
		}

		return $sumLine;
	}

	$filename = isset($argv) ? $argv[1] : "./Vibrio_cholerae.txt";
	$indices = array();

	if(is_file($filename)) {
		$file = fopen($filename, "r");
		while(!feof($file)) {
			$genome = fgets($file);
			$indices = getIndexOfMinimum(computeLine($genome));

		}
		fclose($file);
	} else {
		$indices = getIndexOfMinimum(computeLine($filename));
	}

	foreach ($indices as $index) {
		echo $index . " ";
	}

?>