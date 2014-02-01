<?php
	$img = imagecreatefrompng("input.jpeg");
	$w = imagesx($img);
	$h = imagesy($img);
	$grayscale = imagefilter($img, IMG_FILTER_GRAYSCALE);
?>