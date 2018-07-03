<?php

/**
 * 登录tpshop系统用户相关配置
 */
return [
    'ENABLE' => true,
    'USER' => [
        'username' => 'wx.dunbaigo.com',
        'password' => 'dxvasre1s4eee',
        'unique_id' => 'wx.dunbaigo.com'
    ],
    'API_SECRET_KEY' => '!!www.dunbaigo.com',
    'BASE_URL' => 'https://pro.tpshop:8443',
    'getServerTime' => '/index.php/Api/Base/getServerTime',
    'sqlApi' => '/index.php/Api/Base/sqlApi',
    'thirdLogin' => '/index.php/Api/User/thirdLogin',
    'sendValidateCode' => '/index.php/Home/Api/send_validate_code',
    'updateUserInfo' => '/index.php/Api/User/updateUserInfo'
];