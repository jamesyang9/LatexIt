<?php
	$strs = $_POST['arr'];
	$name = $_POST['id'];

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
		shell_exec("pdflatex -interaction=nonstopmode ". $filename . ".tex");
	}
	generatePDF($strs, $name);
?>