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
namespace app\api\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Exception;
use app\weixin;
use app\common;

/*
 * 基础父类
 * */
class Base extends Controller
{
    public $member_id = 0;//平台用户id
    public $member = null;//平台用户

    public function _initialize()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods:GET, POST'); // 允许get，post请求
        header('Access-Control-Allow-Headers:Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With'); // 允许x-requested-with请求头

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
            exit;
        }
    }


    /*
     * 校验token
     * 机制：校验多个token机制，例如微信token，配送员token，收银员token
     * */
    protected  function checkToken(){
        //result在左，意味着先判断result是否为true，如果是true那么说明上一个检测token已经成功，不会执行下一个检测
        $result = $this->checkMemberToken();//检测平台用户
        $result = $result || $this->checkCashierToken();//检测收银员
        $result = $result || $this->checkDelivererToken();//检测配送员
        $result = $result || $this->checkSalepersonToken();//检测售货员
        return $result;
    }

    /*
     * 校验平台用户token
     * */
    protected function checkMemberToken(){
        //获取token
        $token = Request::instance()->header('ds-token');
        if(empty($token)){
            return false;
        }
        //获取用户session数据
        $user_cache = cache($token);
        if($user_cache == null){
            return false;
        }
        //获取平台用户
        if(isset($user_cache['member'])) {
            $this->member = $user_cache['member'];
        }
        if($this->member == null){
            return false;
        }
        //获取平台用户id
        if(isset($this->member->id)){
            $this->member_id = $this->member->id;
        }
        if($this->member_id == 0){
            return false;
        }
        return true;
    }

    /*
     * 校验配送员token
     * */
    protected function checkDelivererToken(){

    }

    /*
     * 校验收银员token
     * */
    protected function checkCashierToken(){

    }

    /*
     * 校验售货员token
     * */
    protected function checkSalepersonToken(){

    }
}