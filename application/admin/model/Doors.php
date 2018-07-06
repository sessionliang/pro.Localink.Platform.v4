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
 * 门禁数据模型
 * */
class Doors extends Model
{

    protected $table = "tp_doors";

    /**
     * 根据搜索条件获取所有的门禁
     * @param $where/查询条件
     */
    public function getDoorByWhere($where, $offset, $limit)
    {
        return $this->fetchSql(false)->alias('d')
                ->field('d.*, c.cname, b.bname, f.flatno')
                ->join('communitys c','d.community_id=c.id','LEFT')
                ->join('buildings b','d.building_id=b.id','LEFT')
                ->join('flatnos f','d.flatno_id=f.id','LEFT')
                ->where($where)->limit($offset, $limit)->order('d.id desc')->select();
    }


    /**
     * 根据搜索条件获取所有的门禁数量
     * @param $where/查询条件
     */
    public function getAllDoor($where)
    {
        return $this->fetchSql(false)->alias('d')
            ->field('d.*, c.cname, b.bname, f.flatno')
            ->join('communitys c','d.community_id=c.id','LEFT')
            ->join('buildings b','d.building_id=b.id','LEFT')
            ->join('flatnos f','d.flatno_id=f.id','LEFT')
            ->where($where)->order('d.id desc')->count();
    }

    /*
     * 添加门禁
     * */
    public function addDoor($param){
        try{
            $validate = new \app\admin\validate\Door();
            $result = $validate->scene('add')->check($param);
            if(true !== $result){
                return msg( -1,'',$validate->getError());
            }
            $result = $this->save($param);
            if($result){
                adminLog('添加门禁','门禁：'.$param['door_name']);
                return msg(1, url( 'door/index'),'添加门禁成功');
            }
        }catch(\Exception $e){
            return msg(-2,'',$e->getMessage());
        }
    }

    /*
     * 通过id获取单个门禁
     * */
    public function getOneById($id){
        return $this->where([
            'id'=>$id
        ])->find();
    }

    /*
     * 门禁编辑
     * */
    public function doorEdit($param){
        try{
            $validate = new \app\admin\validate\Door();
            $result = $validate->scene('edit')->check($param);
            if(true !== $result){
                return msg( -1,'',$validate->getError());
            }
            $result = $this->save($param,['id'=>$param['id']]);
            if($result){
                adminLog('编辑门禁','门禁：'.$param['door_name']);
                return msg(1, url( 'door/index'),'编辑门禁成功');
            }
        }catch(\Exception $e){
            return msg(-2,'',$e->getMessage());
        }

    }

    /*
     * 删除门禁
     * */
    public function doorDel($id){
        $one = $this->getOneById($id);
        if($one){
            $one->delete();
            return msg(1,url('door/index'),'删除门禁成功');
        }
    }
}