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
namespace app\common\validate;

use think\Validate;

class AdminLogs extends Validate
{
    protected $rule = [
        ['user_name', 'require', '管理员名称不能为空'],
        ['title', 'require', '标题不能为空']
    ];

}