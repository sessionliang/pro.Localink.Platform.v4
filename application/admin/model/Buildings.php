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
 * 单元楼数据模型
 * */
class Buildings extends Model
{

    protected $table = "tp_buildings";

    /**
     * 根据搜索条件获取所有的单元楼
     * @param $where/查询条件
     */
    public function getBuildingByWhere($where, $offset, $limit)
    {
        return $this->alias('b')
                ->field('b.*, c.cname')
                ->join('communitys c','b.community_id=c.id','LEFT')
                ->where($where)->limit($offset, $limit)->order('b.id desc')->select();
    }


    /**
     * 根据搜索条件获取所有的单元楼数量
     * @param $where/查询条件
     */
    public function getBuildingCount($where)
    {
        return $this->where($where)->count();
    }

    /**
     * 根据搜索条件获取所有的单元楼数量
     * @param $where/查询条件
     */
    public function getAllBuilding($where)
    {
        return $this->where($where)->select();
    }

    /*
     * 添加单元楼
     * */
    public function addBuilding($param){
        try{
            $validate = new \app\admin\validate\Building();
            $result = $validate->scene('add')->check($param);
            if(true !== $result){
                return msg( -1,'',$validate->getError());
            }
            $result = $this->save($param);
            if($result){
                adminLog('添加单元楼','单元楼：'.$param['bname']);
                return msg(1, url( 'building/index'),'添加单元楼成功');
            }
        }catch(\Exception $e){
            return msg(-2,'',$e->getMessage());
        }
    }

    /*
     * 通过id获取单个单元楼
     * */
    public function getOneById($id){
        return $this->where([
            'id'=>$id
        ])->find();
    }

    /*
     * 单元楼编辑
     * */
    public function buildingEdit($param){
        try{
            $validate = new \app\admin\validate\Building();
            $result = $validate->scene('edit')->check($param);
            if(true !== $result){
                return msg( -1,'',$validate->getError());
            }
            $param['collect_sum'] = 0;
            $result = $this->save($param,['id'=>$param['id']]);
            if($result){
                adminLog('编辑单元楼','单元楼：'.$param['bname']);
                return msg(1, url( 'building/index'),'编辑单元楼成功');
            }
        }catch(\Exception $e){
            return msg(-2,'',$e->getMessage());
        }

    }

    /*
     * 删除单元楼
     * */
    public function buildingDel($id){
        $one = $this->getOneById($id);
        if($one){
            $one->delete();
            return msg(1,url('building/index'),'删除单元楼成功');
        }
    }
}