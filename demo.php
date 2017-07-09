<?php 
	include './OfficeToTextClass/DocxToText.php';


	// 解析docx文件中的内容
	$doc = new DocxToText();
	$doc -> setDocx('./docDocxPdf/Error.docx');
	$text = preg_replace('/\s+/','',$doc->extract());
