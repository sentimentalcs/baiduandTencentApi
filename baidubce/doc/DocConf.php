<?php
/*
* Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
*
* Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with
* the License. You may obtain a copy of the License at
*
* Http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on
* an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the
* specific language governing permissions and limitations under the License.
*/


// 报告所有 PHP 错误
error_reporting(-1);

$my_credentials = array(
		'ak' => '485d1f5568754266bd8043617e5ddd70',    //修改成自己的BCE AK
		'sk' => 'cc78cb5aa71a48778f50e70865473207',    //修改成自己的BCE SK
);
$g_doc_configs = array(
		'credentials' => $my_credentials,
		'endpoint' => 'doc.baidubce.com',
);
