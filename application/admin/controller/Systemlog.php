<?php
/**
 * Created by PhpStorm.
 * User: sessionliang
 * Date: 2017/11/29
 * Time: 11:18
 */

namespace app\admin\controller;

use app\admin\model\Shops;
use app\common\model\SystemLogs;
/*
 * 系统日志
 * */
class Systemlog extends Base
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
                $where['title'] = ['like', '%' . $param['searchText'] . '%'];
            }

            $systemlog = new SystemLogs();
            $selectResult = $systemlog->getSystemlogsByWhere($where, $offset, $limit);

            $return['total'] = $systemlog->getAllSystemlogs($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    //删除
    public function systemlogDel()
    {
        $id = input('param.id');

        $systemlog = new SystemLogs();
        $flag = $systemlog->delSystemlog();
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }
}