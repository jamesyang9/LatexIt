<?php
function vectorize($sentence){
  $sentence = preg_replace('/[\s|$]+/', '', $sentence);
  // remove all $ because they're just delimiters and you would fail if you had them.
  $sentenceLength = strlen($sentence);

  //special case
  if($sentenceLength < 2){
	$sentence = $sentence . " ";
	$sentenceLength = 2;
  }

  $biletters = array();
  for($i = 0; $i < $sentenceLength -1; $i++){
	$bilet = substr($sentence, $i, 2);
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
	    $similarity += $temp;
	  }
	  $similarity = $similarity/$numPlayers;
	  return $similarity;
	}

	//time awards between 0 and 100 base. Correction between (0.0, 1.0)
	//Since only placing matters, time is irrelevant.

                    function score($translatedStrings) {
	  $scores = array();
	  $numPlayers = count($translatedStrings);
	  for($index = 0; $index < $numPlayers; $index++){	
		                                              $thisString = $translatedStrings[$index];
		                                              $thisScore = max(10*$numPlayers, 20*($numPlayers - $index));
		                                              $similarity = cosine($thisString, $translatedStrings);	
		                                              $scores[$index] = round($thisScore*$similarity);
	                                                  }	
	  return $scores;
	}

	$stringFile = fread(fopen($argv[1], 'r'), 1000);
	$entries = array_slice(explode("\n", $stringFile), 0, $argv[2]);
	print json_encode(score($entries));


?>
