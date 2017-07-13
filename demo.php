<?php 
	
	//将doc,pdf,docx解析为文本内容的调用示例
	include './office2text/doc2textAutoloader.php';
	use office2text\OfficeToText;
	OfficeToText::config(['base_bath'=>__DIR__,'filter_pattern'=>'/\w+|[\\/{}\-\^\$\|=*#@~&:]/']);
	if(!$txt = OfficeToText::text('/docDocxPdf/test.docx')){
		 echo OfficeToText::$error;
	}

	print_r($txt);
/*************************************************************************************************************/
	
	//调用文智api的示例
	
