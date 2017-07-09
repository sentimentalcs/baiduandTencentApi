<?php
/*
* Copyright 2014 Baidu, Inc.
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

error_reporting(-1);
date_default_timezone_set('UTC');

define('__BOS_CLIENT_ROOT', dirname(__DIR__));

$BOS_TEST_CONFIG =
    array(
        'credentials' => array(
//            'accessKeyId' => '485d1f5568754266bd8043617e5ddd70',
//            'secretAccessKey' => 'cc78cb5aa71a48778f50e70865473207',

            'accessKeyId' => '246391499a5e4e8c9ec91c977f5234b1',
            'secretAccessKey' => '70819eb3d3e348aaac802224a4d6932c',
//            'sessionToken' => 'your session token'
        ),
        'endpoint' => 'http://bj.bcebos.com',
//        'stsEndpoint' => 'sts host',
    );
$STDERR = fopen('php://stderr', 'w+');
$__handler = new \Monolog\Handler\StreamHandler($STDERR, \Monolog\Logger::DEBUG);
$__handler->setFormatter(
    new \Monolog\Formatter\LineFormatter(null, null, false, true)
);
\BaiduBce\Log\LogFactory::setInstance(
    new \BaiduBce\Log\MonoLogFactory(array($__handler))
);
\BaiduBce\Log\LogFactory::setLogLevel(\Psr\Log\LogLevel::DEBUG);
