<?php
	function vectorize($sentence){
	$sentence = preg_replace('/\s+/', '', $sentence);
	// replace stuff that's {c}
	//Uses two-char sequences.
	$sentenceLength = strlen($sentence);
	$biletters = array();
	for($i = 0; $i < $sentenceLength -1; $i++){
	  $bilet = substr($sentence, $i, 2);
	   //print $bilet . "\n";
	  if (array_key_exists($bilet, $biletters)){
 	     $biletters[$bilet]++;
	  }	
	  else
	      $biletters[$bilet] = 1;
	}
	return $biletters;
	}	

	function square($x){
          return $x*$x;
	}

	function magnitude($vector){
	$vector = array_map("square", $vector);
	return sqrt(array_sum($vector));
	}

	//this definition is actually the cosine of the angle, between 0 and 1.
	function dotProduct($vectorA, $vectorB) {
           $keys = array_keys($vectorA);          
           $sum = 0;
           for($i = 0; $i < count($keys); $i++){
               if(array_key_exists($keys[$i], $vectorB)){
                  $sum += $vectorA[$keys[$i]]*$vectorB[$keys[$i]];
               }
	  }
	  return $sum/(magnitude($vectorA) * magnitude($vectorB));
	}	
	

        function cosine($sample, $dataset){
	$similarity = 0;
	$thisfrq = vectorize($sample);
	$translatedFrq = array_map("vectorize", $dataset);
	$numPlayers = count($dataset);
	for($i = 0; $i < $numPlayers; $i++){
	  $temp = dotProduct($thisfrq, $translatedFrq[$i]);
	  //print $temp .", " ;
	  $similarity += $temp;
	}
	$similarity = $similarity/$numPlayers;
	print $similarity . " ";
	return $similarity;
	}
	//time awards between 50 and 100 base. Correction between (0.0, 1.0)
	//$ideally times would be sorted, so index is also the place.
	//|$times| = |$translatedStrings| or else will fail.!!!!!
	function score($times, $translatedStrings, $index) {
	$thisTime = $times[$index];
	$thisString = $translatedStrings[$index];
	$numPlayers = count($times);
	$thisScore = max(10*$numPlayers, 20*($numPlayers - $index));
	//between 0 and 1
	$similarity = cosine($thisString, $translatedStrings);	
	return $thisScore*$similarity;
	}

	$time = array(1, 2, 3,4);
	$data = array("$\sum_{i=1}^n 2 x ^ i$", "$\prod_{i=1}^n2x^{i}$"," $\sum_{i = 1} ^ n zx ^ i $ ", "$\sum_{i=1}^n 2x^i$");
	$sample =  "$\sum_{i=1}^n 2x^i$"; //"$2\sum_{i=1}^n x^i$" maybe with 2y
	$keys = array_keys($frq);

	for($i = 0; $i < 4; $i++){
          print score($time, $data, $i);
	  print "\n";        
	}

	print cosine($sample, $data);

?>
