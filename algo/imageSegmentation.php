<?php
	$img = imagecreatefrompng("photo-2.png");
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

	function outputPNG($y1, $y2, $sliceNum){
		global $lineIs, $img, $w, $h, $cuts;
        $dst_w = $w;
        $dst_h = $y2 - $y1;
        $src_x = 0;
		$src_y = $y1;
        $dst_x = 0;
		$dst_y = 0;
	 	$outImg = imagecreate($w, $dst_h);
 		imagecopyresampled($outImg, $img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $dst_w, $dst_h);
		imagepng($outImg, "img" . $sliceNum . ".png");
	}

	function cut() {
		global $lineIs, $img, $w, $h, $cuts;
		$sliceNum = 0;
		$step = 1;
		$start = 0;
		$state = 0;

		for ($y = 0; $y < $h - 10; $y += $step) {
			$l = lineValue($y);

			if ($l < 5000 && $state == 1) {
				if (($y - $start) > 8) {
					echo ($y);
					echo "\n";
					outputPNG(max(0, $start - 10), $y + 10, $sliceNum);
					$sliceNum += 1;
				}
				$state = 0;
			}
			if ($l > 5000 && $state == 0) {
				$start = $y;
				$state = 1;
			}
		}
	}


	echo $w;
	echo ". ";
	echo $h;
	echo "\n";
	//processLines();
	cut();

?>