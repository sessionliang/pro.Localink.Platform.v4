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
 * 业主数据模型
 * */
class Homeowners extends Model
{
    //用户称谓枚举
    public $titles = [
        '1' => 'Mr',
        '2' => 'Mrs',
        '3' => 'Miss'
    ];


    //用户类型枚举
    public $user_groups = [
        '1' => 'ManagingAgent',
        '2' => 'Owner',
        '3' => 'OwnerOccupier',
        '4' => 'Tenant'
    ];

    //用户状态枚举
    public $statuss = [
        '1' => 'Initial',//未提交审核申请
        '2' => 'Waiting',//审核中
        '3' => 'Reject',//拒绝
        '4' => 'Done'//审核通过
    ];



    protected $table = "tp_homeowners";

    /**
     * 根据搜索条件获取所有的业主
     * @param $where/查询条件
     */
    public function getHomeownerByWhere($where, $offset, $limit)
    {
        return $this->fetchSql(false)->alias('h')
                ->field('h.*, c.cname, b.bname, f.flatno')
                ->join('communitys c','h.community_id=c.id','LEFT')
                ->join('buildings b','h.building_id=b.id','LEFT')
                ->join('flatnos f','h.flatno_id=f.id','LEFT')
                ->where($where)->limit($offset, $limit)->order('h.id desc')->select();
    }


    /**
     * 根据搜索条件获取所有的业主数量
     * @param $where/查询条件
     */
    public function getAllHomeowner($where)
    {
        return $this->fetchSql(false)->alias('h')
            ->field('h.*, c.cname, b.bname, f.flatno')
            ->join('communitys c','h.community_id=c.id','LEFT')
            ->join('buildings b','h.building_id=b.id','LEFT')
            ->join('flatnos f','h.flatno_id=f.id','LEFT')
            ->where($where)->order('h.id desc')->count();
    }

    /*
     * 添加业主
     * */
    public function addHomeowner($param){
        try{

            $param['name'] = $param['forename'] .' '. $param['surname'];
            $param['status'] = 1;

            $validate = new \app\admin\validate\Homeowner();
            $result = $validate->scene('add')->check($param);
            if(true !== $result){
                return msg( -1,'',$validate->getError());
            }
            $result = $this->save($param);
            if($result){
                adminLog('添加业主','业主：'.$param['name']);
                return msg(1, url( 'homeowner/index'),'添加业主成功');
            }
        }catch(\Exception $e){
            return msg(-2,'',$e->getMessage());
        }
    }

    /*
     * 通过id获取单个业主
     * */
    public function getOneById($id){
        return $this->where([
            'id'=>$id
        ])->find();
    }

    /*
     * 业主编辑
     * */
    public function homeownerEdit($param){
        try{

            $param['name'] = $param['forename'] .' '. $param['surname'];
            unset($param['status']);


            $validate = new \app\admin\validate\Homeowner();
            $result = $validate->scene('edit')->check($param);
            if(true !== $result){
                return msg( -1,'',$validate->getError());
            }
            $result = $this->save($param,['id'=>$param['id']]);
            if($result){
                adminLog('编辑业主','业主：'.$param['name']);
                return msg(1, url( 'homeowner/index'),'编辑业主成功');
            }
        }catch(\Exception $e){
            return msg(-2,'',$e->getMessage());
        }

    }

    /*
     * 删除业主
     * */
    public function homeownerDel($id){
        $one = $this->getOneById($id);
        if($one){
            $one->delete();
            return msg(1,url('homeowner/index'),'删除业主成功');
        }
    }
}