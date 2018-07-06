<?php
/**
 * Created by PhpStorm.
 * User: fq
 * Date: 2018/6/28
 * Time: 16:38
 */

namespace app\admin\validate;

use think\Validate;

class Homeowner extends Validate
{
    protected $rule = [
        ['community_id','require','小区不能为空'],
        ['building_id','require','单元楼不能为空'],
        ['flatno_id','require','门牌号不能为空'],
        ['name','require','名称不能为空'],
        ['forename','require','名不能为空'],
        ['surname','require','姓不能为空'],
        ['country_code','require','手机号国家代码不能为空'],
        ['phone','require','手机号不能为空'],
        ['title','require','称谓不能为空'],
        ['status','require','业主状态不能为空'],
        ['user_group','require','业主类型不能为空']
    ];

    protected $scene = [
        'add' => [
            'community_id','building_id','flatno_id','name','forename','surname','country_code','phone','title','status','user_group'
        ],
        'edit' => [
            'community_id','building_id','flatno_id','name','forename','surname','country_code','phone','title','user_group'
        ],
    ];

}