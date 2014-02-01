<?php
	$img = imagecreatefrompng("photo-1.png");
	$w = imagesx($img);
	$h = imagesy($img);
	$thresh = 3600;
	//imagefilter($img, IMG_FILTER_CONTRAST, 20);
	imagefilter($img, IMG_FILTER_GRAYSCALE);
	$lineIs = array(h);

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
		for ($i = 0; $i < $h; $i += 3) {
			$v = lineValue($i) + lineValue($i + 1) + lineValue($i + 2);
			lineIs[$i/3] = $v;
		}
	}
	echo $w;
	echo ". ";
	echo $h;
	echo "\n";
	processLines();

?>