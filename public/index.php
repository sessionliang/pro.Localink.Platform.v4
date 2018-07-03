<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
if(!file_exists(__DIR__ . '/../data/install.lock')){
    define('BIND_MODULE', 'install');
}
//应用入口
define('ADDON_ROUTE','/app/');
//定义微信插件目录
define('ADDON_PATH', __DIR__ . '/../addons/');
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 定义应用缓存目录
define('RUNTIME_PATH', __DIR__ . '/../runtime/');
// 开启调试模式
define('APP_DEBUG', true);

define("API_HOST", (APP_DEBUG === false) ? "wx.dunbaigo.com" : "pro.eshop.admin:8080");

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';