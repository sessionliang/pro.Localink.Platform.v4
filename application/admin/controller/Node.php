<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Nodes;

class Node extends Base
{
    // 节点列表
    public function index()
    {
        if(request()->isAjax()){

            $node = new Nodes();
            $nodes = $node->getNodeList();

            $nodes = getTree(objToArray($nodes), false);
            return json(msg(1, $nodes, 'ok'));
        }

        return $this->fetch();
    }

    // 添加节点
    public function nodeAdd()
    {
        $param = input('post.');

        $node = new Nodes();
        $flag = $node->insertNode($param);

        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    // 编辑节点
    public function nodeEdit()
    {
        $param = input('post.');

        $node = new Nodes();
        $flag = $node->editNode($param);

        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    // 删除节点
    public function nodeDel()
    {
        $id = input('param.id');

        $role = new Nodes();
        $flag = $role->delNode($id);
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }
}