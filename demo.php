<?php 
	include './OfficeToTextClass/DocxToText.php';
	include './OfficeToTextClass/OfficeToText.php';

	 OfficeToText::config(['base_bath'=>__DIR__,'filter_pattern'=>'/\w+|[\\/{}\-\^\$\|=*#@~&:]/']);

	 // 解析docx文件中的内容
	 if(!$txt = OfficeToText::text('/docDocxPdf/test.docx')){
	 	echo OfficeToText::$error;
	 }

	 print_r($txt);