<?php
	$img = imagecreatefrompng("photo-1.png");
	$w = imagesx($img);
	$h = imagesy($img);
	$thresh = 3600;
	//imagefilter($img, IMG_FILTER_CONTRAST, 20);
	imagefilter($img, IMG_FILTER_GRAYSCALE);
	$lineIs = array(h);
	$cuts = array();

	function pixelIntensity($x, $y) {
		global $img;
		$rgb = imagecolorat($img, $x, $y);
		return ($rgb & 0xFF);
	}

	function pixelValue($x, $y) {
		global $w, $h, $img;
		$l = max(0, $x - 2);
		$leftI = pixelIntensity($l, $y);
		$thisI = pixelIntensity($x, $y);
		return pow($leftI - $thisI, 2);
	}

	function lineValue($y) {
		global $w, $h, $img, $thresh;
		$count = 0;
		for ($i = 0; $i < $w; $i += 1) {
			if (pixelValue($i, $y) > $thresh && pixelIntensity($i, $y) < 120) {
				$count += pixelValue($i, $y);
			}
		}
		return $count;
	}

	function processLines() {
		global $lineIs, $img, $w, $h;
		for ($i = 0; $i < $h; $i += 2) {
			$v = lineValue($i) + lineValue($i + 1);
			$lineIs[$i/2] = $v;
			//echo $v;
			//echo "\n";
		}
	}

	function cut() {
		global $lineIs, $img, $w, $h, $cuts;
		for ($i = 0; $i < $h - 2; $i += 2) {
			$x = $i/2;
			if ($lineIs[$x] == 0 && $lineIs[$x + 1] > 5000) {
				array_push($cuts, 2*$x);
				echo (2 * $x);
				echo "\n";
			}
		}
	}

	echo $w;
	echo ". ";
	echo $h;
	echo "\n";
	processLines();
	cut();

?>