<?php
	$img = imagecreatefromjpeg("photo.JPG");
	$w = imagesx($img);
	$h = imagesy($img);
	imagefilter($img, IMG_FILTER_GRAYSCALE);

	function pixelIntenxity($x, $y) {
		global $img;
		$rgb = imagecolorat($img, $x, $y);
		$i = $rgb & 0xFF;

		return imagecolorat($img, $x, $y);
	}

	function pixelValue($x, $y) {
		global $w, $h, $img, $imgg;
		return 1;
	}

	function lineValue($x, $y) {
		global $w, $h, $img, $imgg;
		return 2;
	}

	pixelIntenxity(1, 1);
	pixelIntenxity(1, 2);
	pixelIntenxity(1, 3);
	pixelIntenxity(1, 4);



?>