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

use think\Controller;
use think\Db;

class Base extends Controller
{
    //管理员id
    public $admin_id;
    //管理员username
    public $admin_username;
    public function _initialize()
    {
        //获取管理员UserName
        if(!$this->admin_username = getAdminName()){
            $loginUrl = url('login/index');
            if(request()->isAjax()){
                return msg(111, $loginUrl, '登录超时');
            }
            $this->redirect($loginUrl);
        }
        //设置管理员ID
        $this->admin_id = getAdminID();

        // 检测权限
        $control = lcfirst(request()->controller());
        $action = lcfirst(request()->action());
        if(empty(authCheck($control . '/' . $action))){
            if(request()->isAjax()){
                return msg(403, '', '您没有权限');
            }
            $this->error('403 您没有权限');
        }

        $this->assign([
            'username' => $this->admin_username,
            'rolename' => session('role')
        ]);
    }
}