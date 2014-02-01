<?php
	$img = imagecreatefrompng("input.jpeg");
	$w = imagesx($img);
	$h = imagesy($img);
	$grayscale = imagefilter($img, IMG_FILTER_GRAYSCALE);

	function pixelIntenxity($x, $y) {
		global $w, $h, $img, $imgg;
	}

	function pixelValue($x, $y) {

	}

	function lineValue($x, $y) {

	}


?>