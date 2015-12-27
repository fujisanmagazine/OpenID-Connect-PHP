<?php

/**
 *
 * Copyright MITRE 2012
 *
 * OpenIDConnectClient for PHP5
 * Author: Michael Jett <mjett@mitre.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 *
 */

require "vendor/autoload.php";

// 接続クラスを作成
$oidc = new OpenIDConnectClient('http://www.fms-alpha.com',
                                'testclient',
                                'testpass');

// 必要なスコープを指定
$oidc->addScope("openid");
$oidc->addScope("ProductID-1281681406");
$oidc->addScope("offline_access");

// 承認
$oidc->authenticate();

// 個人情報を取得
$name = $oidc->requestUserInfo('given_name');
$user_id = $oidc->requestUserInfo('user_id');

// 契約状態を取得
$scope = $oidc->requestUserInfo('product_id'); // 商品番号
$ismember = $oidc->requestUserInfo('ismember'); // 1なら契約中

?>

<html>
<head>
    <title>Example OpenID Connect Client Use</title>
    <style>
        body {
            font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div>
        Hello <?php echo $name . " @ " . $user_id . ' => ' . $scope . ' = ' . $ismember; ?><br/>

        <?php // トークンのリフレッシュのデモ ?>
        Refresh token is <?php echo $oidc->getRefreshToken(); ?><br/>
        Refresh token after refresh is <?php $oidc->refreshToken($oidc->getRefreshToken()); echo $oidc->getRefreshToken(); ?><br/>
    </div>
</body>
</html>

