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
 * 小区控制器
 * */

class Community extends Base
{
    /*
     * 小区列表
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
                $where['cname'] = ['like', '%' . $param['searchText'] . '%'];
            }

            $communityModel = new model\Communitys();
            $selectResult = $communityModel->getCommunityByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $communityModel->getCommunityCount($where);  // 总数据
            $return['rows'] = $selectResult;   //数据列表

            return json($return);

        }

        return view();
    }

    /*
     * 小区添加
     * */
    public function communityAdd()
    {
        if (request()->isPost()) {
            $communityModel = new model\Communitys();
            $param = input('post.');
            $param['door_types'] = implode(',', $param['door_types']);
            if(input('?images')){
                $param['images'] = implode(',', $param['images']);
            }
            else{
                $param['images'] = '';
            }
            //保存到数据库
            $flag = $communityModel->addCommunity($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        return view();
    }

    /*
     * 小区详情
     * */
    public function detail()
    {
        //获取单个小区
        $communityModel = new model\Communitys();
        $id = input('id');
        $community = $communityModel->getOneById($id);
        $community->door_types = explode(',', $community->door_types);
        $community->images = explode(',', $community->images);
        $this->assign([
            'community' => $community
        ]);

        return view();
    }

    /*
     * 小区编辑
     * */
    public function communityEdit()
    {
        if (request()->isPost()) {
            $communityModel = new model\Communitys();
            $param = input('post.');
            $param['door_types'] = implode(',', $param['door_types']);
            if(input('?images')){
                $param['images'] = implode(',', $param['images']);
            }
            else{
                $param['images'] = '';
            }

            //保存到数据库
            $flag = $communityModel->communityEdit($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $communityModel = new model\Communitys();
        $id = input('id');
        $community = $communityModel->getOneById($id);
        $community->door_types = explode(',', $community->door_types);

        $this->assign([
            'community' => $community,
        ]);
        return view();
    }

    /*
     * 小区删除
     * */
    public function communityDel()
    {
        if (request()->isPost()) {
            $communityModel = new model\Communitys();
            $id = input('id');
            $flag = $communityModel->communityDel($id);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
    }

    /*
     * 选择地址
     * */
    public function selectAddress()
    {

        $this->assign([
            'lat' => input("get.lat"),
            'lng' => input("get.lng")
        ]);

        return view();
    }

    /*
     * 上传图片
     * */
    public function uploadImg()
    {
        if ($this->request->isPost()) {
            $files = request()->file();
            $data = '';
            foreach ($files as $file) {
                // 移动到框架应用根目录/public/uploads/ 目录下
                if ($file) {
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'upload'. DS .'image');
                    if ($info) {
                        // 成功上传后 获取上传信息
                        $data = str_replace('\\','/',$info->getSaveName()) .','. $data;

                    } else {
                        // 上传失败获取错误信息
                    }
                }
            }
            return json(msg(1, $data, ''));
        }
    }

    private function makeButton($id)
    {

        return [
            '编辑' => [
                'auth' => 'community/communityedit',
                'href' => url('community/communityedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '详情' => [
                'auth' => 'community/detail',
                'href' => url('community/detail', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'community/communitydel',
                'href' => "javascript:communityDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }
}



