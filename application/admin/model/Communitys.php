<?php
/**
 * Created by PhpStorm.
 * User: sessionliang
 * Date: 2018/6/27
 * Time: 14:32
 */

namespace app\admin\model;

use think\Model;

/*
 * 小区数据模型
 * */
class Communitys extends Model
{

    protected $table = "tp_communitys";

    /**
     * 根据搜索条件获取所有的小区
     * @param $where/查询条件
     */
    public function getCommunityByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的小区
     * @param $where/查询条件
     */
    public function getAllCommunity($where)
    {
        return $this->where($where)->select();
    }



    /**
     * 根据搜索条件获取所有的小区数量
     * @param $where/查询条件
     */
    public function getCommunityCount($where)
    {
        return $this->where($where)->count();
    }

    /*
     * 添加小区
     * */
    public function addCommunity($param){
        try{
            $validate = new \app\admin\validate\Community();
            $result = $validate->scene('add')->check($param);
            if(true !== $result){
                return msg( -1,'',$validate->getError());
            }
            $result = $this->save($param);
            if($result){
                adminLog('添加小区','小区：'.$param['cname']);
                return msg(1, url( 'community/index'),'添加小区成功');
            }
        }catch(\Exception $e){
            return msg(-2,'',$e->getMessage());
        }
    }

    /*
     * 通过id获取单个小区
     * */
    public function getOneById($id){
        return $this->where([
            'id'=>$id
        ])->find();
    }

    /*
     * 小区编辑
     * */
    public function communityEdit($param){
        try{
            $validate = new \app\admin\validate\Community();
            $result = $validate->scene('edit')->check($param);
            if(true !== $result){
                return msg( -1,'',$validate->getError());
            }
            $param['collect_sum'] = 0;
            $result = $this->save($param,['id'=>$param['id']]);
            if($result){
                adminLog('编辑小区','小区：'.$param['cname']);
                return msg(1, url( 'community/index'),'编辑小区成功');
            }
        }catch(\Exception $e){
            return msg(-2,'',$e->getMessage());
        }

    }

    /*
     * 删除小区
     * */
    public function communityDel($id){
        $one = $this->getOneById($id);
        if($one){
            $one->delete();
            return msg(1,url('community/index'),'删除小区成功');
        }
    }
}