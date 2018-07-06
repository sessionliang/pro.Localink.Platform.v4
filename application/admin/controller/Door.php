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
 * 门禁控制器
 * */

class Door extends Base
{
    /*
     * 门禁列表
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
                $where['door_name|pid'] = ['like', '%' . $param['searchText'] . '%'];
            }
            if (!empty($param['door_type'])) {
                $where['door_type'] = $param['door_type'];
            }
            if (!empty($param['community_id'])) {
                $where['d.community_id'] = $param['community_id'];
            }

            $doorModel = new model\Doors();
            $selectResult = $doorModel->getDoorByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                //获取门禁类型
                $selectResult[$key]['door_type'] = $this->getDoorTypeName($selectResult[$key]['door_type']);
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $doorModel->getAllDoor($where);  // 总数据
            $return['rows'] = $selectResult;   //数据列表

            return json($return);

        }

        $communityModel = new model\Communitys();
        $communitys = $communityModel->getAllCommunity([]);

        $this->assign([
            'communitys' => $communitys
        ]);

        return view();
    }

    /*
     * 获取所有的单元楼
     * */
    public function getDoorTypes(){
        $communityModel = new model\Communitys();
        $community = $communityModel->getOneById(input('community_id'));
        $data = explode(',',$community->door_types);
        foreach($data as $key=>$vo){
            $data[$key] = ['id'=>$vo, 'name'=>$this->getDoorTypeName($vo)];
        }
        return json(msg(1, $data, ''));
    }

    public function getDoorTypeName($id){
        switch ($id){
            case 1:
                return "Gate";
            case 2:
                return "Main Entuance";
            case 3:
                return "Carpark Basement";
            case 4:
                return "MailBox";
            case 5:
                return "Building Entrance";
            case 6:
                return "Storage Room";
            case 7:
                return "Utility Room";
        }
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
     * 获取所有的门牌号
     * */
    public function getFlatnos(){
        $flatnoModel = new model\Flatnos();
        $flatnos = $flatnoModel->getAllFlatno(['building_id'=>input('building_id')]);
        return json(msg(1, $flatnos, ''));
    }

    /*
     * 门禁添加
     * */
    public function doorAdd()
    {
        if (request()->isPost()) {
            $doorModel = new model\Doors();
            $param = input('post.');
            //保存到数据库
            $flag = $doorModel->addDoor($param);

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
     * 门禁详情
     * */
    public function detail()
    {
        //获取单个门禁
        $doorModel = new model\Doors();
        $id = input('id');
        $door = $doorModel->getOneById($id);
        $door->door_types = explode(',',$door->door_types);
        $this->assign([
            'door' => $door
        ]);

        return view();
    }

    /*
     * 门禁编辑
     * */
    public function doorEdit()
    {
        if (request()->isPost()) {
            $doorModel = new model\Doors();
            $param = input('post.');
            //保存到数据库
            $flag = $doorModel->doorEdit($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }


        $communityModel = new model\Communitys();
        $communitys = $communityModel->getAllCommunity([]);

        $doorModel = new model\Doors();
        $id = input('id');
        $door = $doorModel->getOneById($id);

        $this->assign([
            'communitys' => $communitys,
            'door' => $door,
        ]);
        return view();
    }

    /*
     * 门禁删除
     * */
    public function doorDel()
    {
        if (request()->isPost()) {
            $doorModel = new model\Doors();
            $id = input('id');
            $flag = $doorModel->doorDel($id);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
    }

    private function makeButton($id)
    {

        return [
            '编辑' => [
                'auth' => 'door/dooredit',
                'href' => url('door/dooredit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'door/doordel',
                'href' => "javascript:doorDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }
}


