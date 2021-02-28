<?php 
	/**
	*	Get complement of a genome
	*	Use in commandline: php Exer1.3.1 <filname/genome> <pattern>
	*
	*/

	if($argc != 2) {
		echo "Expects only one parameter: <filename/genome>.";
		die();
	} else if ($argc == 2 && !is_string($argv[1])) {
		echo "First parameter should be a file or genome string.";
		die();
	}

	/**
	*	Accepts a base and returns the complement
	*	@param base Character
	*	@return complement Character
	*/
	function getComplementBase($base) {
		$complement = "";
		switch (strtoupper($base)) {
			case 'A':
				$complement .= 'T';
				break;
			case 'U':
				$complement .= 'A';
				break;
			case 'T':
				$complement .= 'A';
				break;
			case 'G':
				$complement .= 'C';
				break;
			case 'C':
				$complement .= 'G';
				break;
			default:
				break;
		}

		return $complement;
	}

	/**
	*	Accepts a genome and returns the complement
	*	@param genome String
	*	@return complement String
	*/
	function getComplement($genome) {
		$complement = "";
		for ($i=0; $i < strlen($genome); $i++) { 
			$complement .= getComplementBase($genome[$i]);
		}

		return strrev($complement);
	}

	$filename = isset($argv) ? $argv[1] : "./Vibrio_cholerae.txt";
	$complement = "";

	if(is_file($filename)) {
		$file = fopen($filename, "r");
		while(!feof($file)) {
			$genome = fgets($file);
			$complement = getComplement($genome);

		}
		fclose($file);
	} else {
		$complement = getComplement($filename);
	}

	echo $complement . "\n";
?>
