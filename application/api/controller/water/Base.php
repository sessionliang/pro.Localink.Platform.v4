<?php
/**
 * Created by PhpStorm.
 * User: sessionliang
 * Date: 2018/4/20
 * Time: 17:33
 */
namespace app\api\controller\water;


use think\Controller;
use think\Request;
use app\weixin\model\Members;
use app\common;

/*
 * 矿泉水api父类
 * */
class Base extends Controller
{
    public $wxmember_id = 0;//微信用户id
    public $wxmember = null;//微信用户
    public $wxsession3rd = null;//微信用户openid,unionid,session_key

    public $member_id = 0;//平台用户id
    public $member = null;//平台用户

    public function _initialize()
    {
    }

    protected function checkToken(){
        $token = Request::instance()->header('ds-token');
        if(empty($token)){
            return false;
        }
        $this->wxsession3rd = cache($token);
        if($this->wxsession3rd == null){
            return false;
        }

        $wxmemberModel = new Members();
        $this->wxmember = $wxmemberModel->getMemberInfo(['unionid'=>$this->wxsession3rd['wxsession']['unionid']]);
        if($this->wxmember == null){
            return false;
        }
        $this->wxmember_id = $this->wxmember->member_id;
        if($this->wxmember_id == 0){
            return false;
        }

        //通过微信用户找到关联的平台用户
        $memberModel = new common\model\Members();
        $this->member = $memberModel->getMemberInfo(['id' => $this->wxmember->member_id]);
        if(isset($this->member->id)){
            $this->member_id = $this->member->id;
        }

        //更新缓存，把平台用户信息存入缓存
        $user_cache = cache($token);
        if(!isset($user_cache['member'])){
            $user_cache['member'] = $this->member;
            cache($token,$user_cache, 3600 * 24 * 2);//缓存保存两天
        }
        return true;
    }
}