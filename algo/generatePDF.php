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
		exec("pdfLatex ")
	}
	$strs = array("this", "is", "my", "file");
	generatePDF($strs, "output");
?>