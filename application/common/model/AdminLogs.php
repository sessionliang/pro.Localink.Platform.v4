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
namespace app\common\model;

use think\Model;
use think\Db;
use depstore\UserCode;

/*
 * 管理员日志
 * */
class AdminLogs extends Model
{
    /**
     * 查询管理员日志
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getAdminlogsByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的管理员日志数量
     * @param $where
     */
    public function getAllAdminlogs($where)
    {
        return $this->where($where)->count();
    }

    /**
     * 清空管理员日志
     * @param $id
     */
    public function delAdminlog()
    {
        try{

            $this->where('id','>', 0)->delete();
            return msg(1, '', '清空管理员日志成功');

        }catch(\Exception $e){
            return msg(-1, '', $e->getMessage());
        }
    }
}