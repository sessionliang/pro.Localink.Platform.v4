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
 * 系统日志
 * */
class SystemLogs extends Model
{
    /**
     * 查询系统日志
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getSystemlogsByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的系统日志数量
     * @param $where
     */
    public function getAllSystemlogs($where)
    {
        return $this->where($where)->count();
    }

    /**
     * 清空系统日志
     * @param $id
     */
    public function delSystemlog()
    {
        try{

            $this->where('id','>', 0)->delete();
            return msg(1, '', '清空系统日志成功');

        }catch(\Exception $e){
            return msg(-1, '', $e->getMessage());
        }
    }
}