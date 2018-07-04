<?php
/**
 * Created by PhpStorm.
 * User: fq
 * Date: 2018/6/28
 * Time: 16:38
 */

namespace app\admin\validate;

use think\Validate;

class Flatno extends Validate
{
    protected $rule = [
        ['community_id','require','小区不能为空'],
        ['building_id','require','单元楼不能为空'],
        ['flatno','require','门牌号不能为空']
    ];

    protected $scene = [
        'add' => [
            'community_id','building_id','flatno'
        ],
        'edit' => [
            'community_id','building_id','flatno'
        ],
    ];

}