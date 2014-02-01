<?php
	$strs = $_POST['arr'];
	$name = $_POST['id'];

	function generateTEX($strings, $filename) 
	{
		$template = "template.tex";
		if ($fileName == $template) {
			return;
		}

		copy("template.tex", $filename . ".tex");
		$texFile = fopen($filename . ".tex", 'a');
		foreach($strings as $string) {
			fwrite($texFile, $string . "\\\\ \n");
		}
		fwrite($texFile, "\n\n\\end{document}");
		fclose($texFile);
	}
	generateTEX($strs, $name);
?>