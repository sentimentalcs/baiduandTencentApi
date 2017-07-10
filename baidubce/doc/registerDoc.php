<?php
require 'DocConf.php';
require 'BceSign.php';

global $g_doc_configs;
global $my_credentials;

//注册文档

$host= $g_doc_configs['endpoint'];
$path = "/v2/document";
$method = "POST";
$parms = array("register"=>"");
date_default_timezone_set('UTC');
$timestamp = date("Y-m-d") . "T" . date("H:i:s") . "Z";
$Authorization = getSigner($host,$method,$path, $parms, $timestamp);

$httputil = new HttpUtil();
$parms = $httputil->getCanonicalQueryString($parms);
$url = "http://".$host.$path."?".$parms;
var_dump($url);
// exit;
$head = array(
    "Content-Type:application/json",
    //"Content-Length:{$filesize}",
    "Authorization:{$Authorization}",
    "x-bce-date:{$timestamp}",
);

//传入需要注册的文档格式和名称
$data = array("title"=>"my_test_doc","format"=>"doc");
$data_string = json_encode($data);


//发送HTTP请求

$curlp = curl_init();
curl_setopt($curlp, CURLOPT_URL, $url);
curl_setopt($curlp, CURLOPT_HTTPHEADER, $head);
curl_setopt($curlp, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($curlp, CURLOPT_POST, 1);
curl_setopt($curlp, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($curlp);
curl_close($curlp);
echo $output;
print "\n";
?>
