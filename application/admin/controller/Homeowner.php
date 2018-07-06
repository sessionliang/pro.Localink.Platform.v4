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
 * 业主控制器
 * */

class Homeowner extends Base
{
    /*
     * 业主列表
     * */
    public function index()
    {
        $homeownerModel = new model\Homeowners();
        if (request()->isAjax()) {
            //获取列表数据
            $param = input('param.');

            //分页条件
            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            //查询条件
            $where = [];
            if (!empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            if (!empty($param['user_group'])) {
                $where['user_group'] = $param['user_group'];
            }
            if (!empty($param['status'])) {
                $where['status'] = $param['status'];
            }
            if (!empty($param['community_id'])) {
                $where['h.community_id'] = $param['community_id'];
            }


            $selectResult = $homeownerModel->getHomeownerByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                //获取业主类型
                $selectResult[$key]['title'] = $homeownerModel->titles[$selectResult[$key]['title']];
                $selectResult[$key]['user_group'] = $homeownerModel->user_groups[$selectResult[$key]['user_group']];
                $selectResult[$key]['status'] = $homeownerModel->statuss[$selectResult[$key]['status']];
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $homeownerModel->getAllHomeowner($where);  // 总数据
            $return['rows'] = $selectResult;   //数据列表

            return json($return);

        }

        $communityModel = new model\Communitys();
        $communitys = $communityModel->getAllCommunity([]);

        $this->assign([
            'user_groups' => $homeownerModel->user_groups,
            'statuss' => $homeownerModel->statuss,
            'communitys' => $communitys
        ]);

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
     * 获取所有的门牌号
     * */
    public function getFlatnos(){
        $flatnoModel = new model\Flatnos();
        $flatnos = $flatnoModel->getAllFlatno(['building_id'=>input('building_id')]);
        return json(msg(1, $flatnos, ''));
    }

    /*
     * 业主添加
     * */
    public function homeownerAdd()
    {
        $homeownerModel = new model\Homeowners();
        if (request()->isPost()) {

            $param = input('post.');
            //保存到数据库
            $flag = $homeownerModel->addHomeowner($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $communityModel = new model\Communitys();
        $communitys = $communityModel->getAllCommunity([]);
        $this->assign([
            'titles' => $homeownerModel->titles,
            'user_groups' => $homeownerModel->user_groups,
            'communitys' => $communitys
        ]);
        return view();
    }

    /*
     * 业主详情
     * */
    public function detail()
    {
        //获取单个业主
        $homeownerModel = new model\Homeowners();
        $id = input('id');
        $homeowner = $homeownerModel->getOneById($id);
        $homeowner->homeowner_types = explode(',',$homeowner->homeowner_types);
        $this->assign([
            'homeowner' => $homeowner
        ]);

        return view();
    }

    /*
     * 业主编辑
     * */
    public function homeownerEdit()
    {
        if (request()->isPost()) {
            $homeownerModel = new model\Homeowners();
            $param = input('post.');
            //保存到数据库
            $flag = $homeownerModel->homeownerEdit($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }


        $communityModel = new model\Communitys();
        $communitys = $communityModel->getAllCommunity([]);

        $homeownerModel = new model\Homeowners();
        $id = input('id');
        $homeowner = $homeownerModel->getOneById($id);

        $this->assign([
            'titles' => $homeownerModel->titles,
            'user_groups' => $homeownerModel->user_groups,
            'communitys' => $communitys,
            'homeowner' => $homeowner,
        ]);
        return view();
    }

    /*
     * 业主删除
     * */
    public function homeownerDel()
    {
        if (request()->isPost()) {
            $homeownerModel = new model\Homeowners();
            $id = input('id');
            $flag = $homeownerModel->homeownerDel($id);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
    }

    private function makeButton($id)
    {

        return [
            '编辑' => [
                'auth' => 'homeowner/homeowneredit',
                'href' => url('homeowner/homeowneredit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'homeowner/homeownerdel',
                'href' => "javascript:homeownerDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }
}


