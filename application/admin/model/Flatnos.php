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
 * 门牌号数据模型
 * */
class Flatnos extends Model
{

    protected $table = "tp_flatnos";

    /**
     * 根据搜索条件获取所有的门牌号
     * @param $where/查询条件
     */
    public function getFlatnoByWhere($where, $offset, $limit)
    {
        return $this->alias('f')
                ->field('f.*, c.cname, b.bname')
                ->join('communitys c','f.community_id=c.id','LEFT')
                ->join('buildings b','f.building_id=b.id','LEFT')
                ->where($where)->limit($offset, $limit)->order('f.id desc')->select();
    }


    /**
     * 根据搜索条件获取所有的门牌号数量
     * @param $where/查询条件
     */
    public function getAllFlatno($where)
    {
        return $this->where($where)->count();
    }

    /*
     * 添加门牌号
     * */
    public function addFlatno($param){
        try{
            $validate = new \app\admin\validate\Flatno();
            $result = $validate->scene('add')->check($param);
            if(true !== $result){
                return msg( -1,'',$validate->getError());
            }
            $result = $this->save($param);
            if($result){
                adminLog('添加门牌号','门牌号：'.$param['flatno']);
                return msg(1, url( 'flatno/index'),'添加门牌号成功');
            }
        }catch(\Exception $e){
            return msg(-2,'',$e->getMessage());
        }
    }

    /*
     * 通过id获取单个门牌号
     * */
    public function getOneById($id){
        return $this->where([
            'id'=>$id
        ])->find();
    }

    /*
     * 门牌号编辑
     * */
    public function flatnoEdit($param){
        try{
            $validate = new \app\admin\validate\Flatno();
            $result = $validate->scene('edit')->check($param);
            if(true !== $result){
                return msg( -1,'',$validate->getError());
            }
            $param['collect_sum'] = 0;
            $result = $this->save($param,['id'=>$param['id']]);
            if($result){
                adminLog('编辑门牌号','门牌号：'.$param['flatno']);
                return msg(1, url( 'flatno/index'),'编辑门牌号成功');
            }
        }catch(\Exception $e){
            return msg(-2,'',$e->getMessage());
        }

    }

    /*
     * 删除门牌号
     * */
    public function flatnoDel($id){
        $one = $this->getOneById($id);
        if($one){
            $one->delete();
            return msg(1,url('flatno/index'),'删除门牌号成功');
        }
    }
}