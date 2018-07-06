<?php
/**
 * Created by PhpStorm.
 * User: sessionliang
 * Date: 2018/6/27
 * Time: 11:54
 */

namespace app\admin\controller;

use app\admin\model;

/*
 * 单元楼控制器
 * */

class Building extends Base
{
    /*
     * 单元楼列表
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
                $where['bname'] = ['like', '%' . $param['searchText'] . '%'];
            }

            $buildingModel = new model\Buildings();
            $selectResult = $buildingModel->getBuildingByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $buildingModel->getBuildingCount($where);  // 总数据
            $return['rows'] = $selectResult;   //数据列表

            return json($return);

        }

        return view();
    }

    /*
     * 单元楼添加
     * */
    public function buildingAdd()
    {
        if (request()->isPost()) {

            $param = input('post.');

            $bnames = explode("\n",$param['bname']);
            foreach($bnames as $key=>$vo){
                $param['bname'] = $vo;
                $buildingModel = new model\Buildings();
                //保存到数据库
                $flag = $buildingModel->addBuilding($param);
            }
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
     * 单元楼详情
     * */
    public function detail()
    {
        //获取单个单元楼
        $buildingModel = new model\Buildings();
        $id = input('id');
        $building = $buildingModel->getOneById($id);
        $building->door_types = explode(',',$building->door_types);
        $this->assign([
            'building' => $building
        ]);

        return view();
    }

    /*
     * 单元楼编辑
     * */
    public function buildingEdit()
    {
        if (request()->isPost()) {
            $buildingModel = new model\Buildings();
            $param = input('post.');
            //保存到数据库
            $flag = $buildingModel->buildingEdit($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }


        $communityModel = new model\Communitys();
        $communitys = $communityModel->getAllCommunity([]);

        $buildingModel = new model\Buildings();
        $id = input('id');
        $building = $buildingModel->getOneById($id);

        $this->assign([
            'communitys' => $communitys,
            'building' => $building,
        ]);
        return view();
    }

    /*
     * 单元楼删除
     * */
    public function buildingDel()
    {
        if (request()->isPost()) {
            $buildingModel = new model\Buildings();
            $id = input('id');
            $flag = $buildingModel->buildingDel($id);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
    }

    private function makeButton($id)
    {

        return [
            '编辑' => [
                'auth' => 'building/buildingedit',
                'href' => url('building/buildingedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'building/buildingdel',
                'href' => "javascript:buildingDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }
}


