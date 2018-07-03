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
namespace app\admin\model;

use think\Model;
use think\Exception;

class Users extends Model
{
    /**
     * 根据搜索条件获取用户列表信息
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getUsersByWhere($where, $offset, $limit)
    {
        return $this->alias('u')
            ->field( 'u.*,r.role_name')
            ->join('roles r',  'u.role_id = r.id','LEFT')
            ->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的用户数量
     * @param $where
     */
    public function getAllUsers($where)
    {
        return $this->where($where)->count();
    }

    /**
     * 插入管理员信息
     * @param $param
     */
    public function insertUser($param)
    {
        try{

            $result =  $this->validate()->save($param);
            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }else{
                adminLog('添加管理员','管理员：'.$param['user_name']);
                return msg(1, url('user/index'), '添加管理员成功');
            }
        }catch(PDOException $e){

            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑管理员信息
     * @param $param
     */
    public function editUser($param)
    {
        try{

            $result =  $this->validate()->save($param, ['id' => $param['id']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }else{
                adminLog('编辑管理员','管理员：'.$param['user_name']);
                return msg(1, url('user/index'), '编辑管理员成功');
            }
        }catch(PDOException $e){
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据管理员id获取角色信息
     * @param $id
     */
    public function getOneUser($id)
    {
        return $this->where('id', $id)->find();
    }

    /**
     * 删除管理员
     * @param $id
     */
    public function delUser($id)
    {
        try{
            $user = $this->getOneUser($id);
            adminLog('删除管理员','管理员：'.$user['user_name']);
            $this->where('id', $id)->delete();
            return msg(1, '', '删除管理员成功');

        }catch( PDOException $e){
            return msg(-1, '', $e->getMessage());
        }
    }

    /**
     * 根据用户名获取管理员信息
     * @param $name
     */
    public function findUserByName($name)
    {
        return $this->where('user_name', $name)->find();
    }

    /**
     * 更新管理员状态
     * @param array $param
     */
    public function updateStatus($param = [], $uid)
    {
        try{

            $this->where('id', $uid)->update($param);
            return msg(1, '', 'ok');
        }catch (\Exception $e){

            return msg(-1, '', $e->getMessage());
        }
    }

    /**
     * 修改密码
     * @param $param
     */
    public function updatePwd($user_id, $old_pwd, $new_pwd)
    {
        try{
            $validate = new \app\admin\validate\Users();
            $result = $validate->scene('updatePwd')->check(input('param.'));
            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $validate->getError());
            }else{
                $user = $this->getOneUser($user_id);
                if($user['password'] != md5($old_pwd)){
                    return msg(-1, '', '密码不正确');
                }
                $user['password'] = md5($new_pwd);
                $user->save();
                return msg(1, url('admin/login/loginOut'), '密码修改成功');
            }
        }catch(Exception $e){
            return msg(-2, '', $e->getMessage());
        }
    }
}