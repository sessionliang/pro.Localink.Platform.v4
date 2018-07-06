<?php
/**
 * Created by PhpStorm.
 * User: fq
 * Date: 2018/6/28
 * Time: 16:38
 */

namespace app\admin\validate;

use think\Validate;

class Door extends Validate
{
    protected $rule = [
        ['community_id','require','小区不能为空'],
        ['building_id','require','单元楼不能为空'],
        ['flatno_id','require','门牌号不能为空'],
        ['door_name','require','门禁名称不能为空'],
        ['door_type','require','门禁类型不能为空']
    ];

    protected $scene = [
        'add' => [
            'community_id','door_name','door_type'
        ],
        'edit' => [
            'community_id','door_name','door_type'
        ],
    ];

}