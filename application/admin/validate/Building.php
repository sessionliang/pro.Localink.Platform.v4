<?php
/**
 * Created by PhpStorm.
 * User: fq
 * Date: 2018/6/28
 * Time: 16:38
 */

namespace app\admin\validate;

use think\Validate;

class Building extends Validate
{
    protected $rule = [
        ['community_id','require','小区不能为空'],
        ['bname','require','单元楼名称不能为空']
    ];

    protected $scene = [
        'add' => [
            'community_id','bname'
        ],
        'edit' => [
            'community_id','bname'
        ],
    ];

}