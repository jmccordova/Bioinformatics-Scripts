<?php 
	if($argc == 2) {
		echo "Expects only two parameters <filename/genome> and <pattern>.";
		die();
	}

	function PatternCount($genome, $pattern) {
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
	$pattern = isset($argv) ? $argv[2] : "GCGCG";

	if(is_file($filename)) {
		$file = fopen($filename, "r");
		while(!feof($file)) {
			$genome = fgets($file);
			echo "{$pattern} occured " . PatternCount($genome, $pattern) . " time/s.";
		}
		fclose($file);
	} else {
		echo "{$pattern} occured " . PatternCount($filename, $pattern) . " time/s.";
	}
?>