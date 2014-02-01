<?php
	function generatePDF($strings, $filename) 
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
		shell_exec("pdflatex ". $filename . ".tex");
	}
	$strs = array("$4x^2 \\sum_{i=0}^9 i^2$", "is", "my", "file");
	generatePDF($strs, "output");
?>