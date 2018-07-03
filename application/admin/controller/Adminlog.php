<?php
/**
 * Created by PhpStorm.
 * User: sessionliang
 * Date: 2017/11/29
 * Time: 11:18
 */

namespace app\admin\controller;

use app\admin\model\Shops;
use app\common\model\AdminLogs;
/*
 * 管理员日志
 * */
class Adminlog extends Base
{
    // 列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['user_name|title'] = ['like', '%' . $param['searchText'] . '%'];
            }

            $adminlog = new AdminLogs();
            $selectResult = $adminlog->getAdminlogsByWhere($where, $offset, $limit);

            $return['total'] = $adminlog->getAllAdminlogs($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    //删除
    public function adminlogDel()
    {
        $id = input('param.id');

        $adminlog = new AdminLogs();
        $flag = $adminlog->delAdminlog();
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }
}