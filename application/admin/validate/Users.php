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
namespace app\admin\validate;

use think\Validate;

class Users extends Validate
{
    protected $rule = [
        ['user_name', 'unique:users', '管理员已经存在']
    ];

    protected $scene = [
        'login'  =>  [
            ['userName', 'require', '用户名不能为空'],
            ['password', 'require', '密码不能为空'],
            ['code', 'require', '验证码不能为空']
        ],
        'update_pwd' => [
            ['old_pwd', 'require', '旧密码不能为空'],
            ['new_pwd', 'require', '新密码不能为空']
        ]
    ];
}