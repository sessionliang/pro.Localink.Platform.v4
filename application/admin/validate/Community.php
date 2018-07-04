<?php
/**
 * Created by PhpStorm.
 * User: fq
 * Date: 2018/6/28
 * Time: 16:38
 */

namespace app\admin\validate;

use think\Validate;

class Community extends Validate
{
    protected $rule = [
        ['cname','require','小区名称不能为空'],
        ['address','require','地址不能为空'],
        ['lat','require','纬度不能为空'],
        ['lng','require','经度不能为空']
    ];

    protected $scene = [
        'add' => [
            'cname','address','lat','lng'
        ],
        'edit' => [
            'cname','address','lat','lng'
        ],
    ];

}