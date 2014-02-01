<?php
	$img = imagecreatefromjpeg("photo.JPG");
	$w = imagesx($img);
	$h = imagesy($img);
	imagefilter($img, IMG_FILTER_GRAYSCALE);

	function pixelIntenxity($x, $y) {
		global $img;
		$rgb = imagecolorat($img, $x, $y);
		return ($rgb & 0xFF);
	}

	function pixelValue($x, $y) {
		global $w, $h, $img;
		$l = max(0, $x - 2);
		return pow($l, 2);
		return 1;
	}

	function lineValue($x, $y) {
		global $w, $h, $img;
		return 2;
	}

	pixelIntenxity(1, 1);
	pixelIntenxity(1, 2);
	pixelIntenxity(1, 3);
	pixelIntenxity(1, 4);



?>