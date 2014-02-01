<?php
	$img = imagecreatefrompng("input.jpeg");
	$w = imagesx($img);
	$h = imagesy($img);
	$grayscale = imagefilter($img, IMG_FILTER_GRAYSCALE);

	function pixelIntenxity($x, $y) {
		global $imgg;
		print(imagecolorat($imgg, $x, $y));
		return imagecolorat($imgg, $x, $y);
	}

	function pixelValue($x, $y) {
		global $w, $h, $img, $imgg;
		return 1;
	}

	function lineValue($x, $y) {
		global $w, $h, $img, $imgg;
		return 2;
	}


?>