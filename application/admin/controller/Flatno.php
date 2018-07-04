<?php
/**
 * Created by PhpStorm.
 * User: sessionliang
 * Date: 2018/6/27
 * Time: 11:54
 */

namespace app\admin\controller;

use app\admin\model;
use think\Build;

/*
 * 门牌号控制器
 * */

class Flatno extends Base
{
    /*
     * 门牌号列表
     * */
    public function index()
    {

        if (request()->isAjax()) {
            //获取列表数据
            $param = input('param.');

            //分页条件
            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            //查询条件
            $where = [];
            if (!empty($param['searchText'])) {
                $where['flatno'] = ['like', '%' . $param['searchText'] . '%'];
            }

            $flatnoModel = new model\Flatnos();
            $selectResult = $flatnoModel->getFlatnoByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $flatnoModel->getAllFlatno($where);  // 总数据
            $return['rows'] = $selectResult;   //数据列表

            return json($return);

        }

        return view();
    }


    /*
     * 获取所有的单元楼
     * */
    public function getBuildings(){
        $buildingModel = new model\Buildings();
        $buildings = $buildingModel->getAllBuilding(['community_id'=>input('community_id')]);
        return json(msg(1, $buildings, ''));
    }

    /*
     * 门牌号添加
     * */
    public function flatnoAdd()
    {
        if (request()->isPost()) {
            $flatnoModel = new model\Flatnos();
            $param = input('post.');
            //保存到数据库
            $flag = $flatnoModel->addFlatno($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $communityModel = new model\Communitys();
        $communitys = $communityModel->getAllCommunity([]);
        $this->assign([
            'communitys' => $communitys
        ]);
        return view();
    }

    /*
     * 门牌号详情
     * */
    public function detail()
    {
        //获取单个门牌号
        $flatnoModel = new model\Flatnos();
        $id = input('id');
        $flatno = $flatnoModel->getOneById($id);
        $flatno->door_types = explode(',',$flatno->door_types);
        $this->assign([
            'flatno' => $flatno
        ]);

        return view();
    }

    /*
     * 门牌号编辑
     * */
    public function flatnoEdit()
    {
        if (request()->isPost()) {
            $flatnoModel = new model\Flatnos();
            $param = input('post.');
            //保存到数据库
            $flag = $flatnoModel->flatnoEdit($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }


        $communityModel = new model\Communitys();
        $communitys = $communityModel->getAllCommunity([]);

        $flatnoModel = new model\Flatnos();
        $id = input('id');
        $flatno = $flatnoModel->getOneById($id);

        $this->assign([
            'communitys' => $communitys,
            'flatno' => $flatno,
        ]);
        return view();
    }

    /*
     * 门牌号删除
     * */
    public function flatnoDel()
    {
        if (request()->isPost()) {
            $flatnoModel = new model\Flatnos();
            $id = input('id');
            $flag = $flatnoModel->flatnoDel($id);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
    }

    private function makeButton($id)
    {

        return [
            '编辑' => [
                'auth' => 'flatno/flatnoedit',
                'href' => url('flatno/flatnoedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'flatno/flatnodel',
                'href' => "javascript:flatnoDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }
}


