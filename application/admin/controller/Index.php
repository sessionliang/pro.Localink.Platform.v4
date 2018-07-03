<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use app\admin\model\Nodes;
use think\Config;
use think\Loader;

class Index extends Base
{
    public function index()
    {
        // 获取权限菜单
        $node = new Nodes();
        $this->assign([
            'menu' => $node->getMenu(session('rule'))
        ]);

        return $this->fetch('/index');
    }

    /**
     * 后台默认首页
     * @return mixed
     */
    public function indexPage()
    {
        $version = Config::load(APP_PATH.'version.php')['version'];
        $lastLoginTime = date('Y-m-d H:i:s',session('lastlogintime'));
        return $this->fetch('index',[
            'version' => $version,
            'lastlogintime' => $lastLoginTime
        ]);
    }
}
