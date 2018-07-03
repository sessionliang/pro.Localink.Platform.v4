<?php
/**
 * Created by PhpStorm.
 * User: sessionliang
 * Date: 2018/4/20
 * Time: 18:16
 */

/**
 * @SWG\Definition(definition="res_json")
 */
class ResJson
{
    /**
     * @SWG\Property(title="返回码", type="int32", description="code为1时，表示接口访问成功")
     * @var int
     */
    public $code;

    /**
     * @SWG\Property(title="返回结果", type="string", description="code为1时，data为返回结果")
     * @var string
     */
    public $data;

    /**
     * @SWG\Property(title="错误信息", type="string", description="code不为1时，msg为错误信息")
     * @var string
     */
    public $msg;
}