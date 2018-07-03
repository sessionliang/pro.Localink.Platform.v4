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
use think\Db;
use depstore\UserCode;

/*
 * 设置
 * */
class Settings extends Model
{
    /**
     * 根据配置类型获取配置数据
     * @param $type 配置类型: sms, water
     * @param $conArr 返回的配置节点，是一个数组
     */
    public function getSettingsByType($type, $conArr)
    {
        $result = Db::name('settings')->where(['name' => $type])->find();
        $config = json_decode($result['value'], true);
        //数据库不存在，返回原数组
        if(!isset($config)){
            return $conArr;
        }

        //给原数组赋值
        if($conArr){
            foreach ($conArr as $key=>$val){
                if(isset($config[$key])){
                    if(is_array ($conArr[$key]) && is_array ($config[$key])){
                        $conArr[$key]=array_merge($conArr[$key],$config[$key]);
                    }else{
                        $conArr[$key] = $config[$key];
                    }
                }
            }
        }

        return $conArr;
    }

    /**
     * 保存设置
     * @param $param
     */
    public function saveSettings($param)
    {
        try{
            $result = Db::name('settings')->where(['name' => $param['setting_name']])->find();
            $config = json_decode($result['value'], true);
            //保留原配置
            if(isset($config)){
                $param = array_merge($config, $param);
            }
            Db::name('settings')->where(['name' => $param['setting_name']])->delete();
            $data['name'] = $param['setting_name'];
            $data['value'] = json_encode($param);
            $data['create_time'] = time();
            $date['creator_id'] = $param['creator_id'];
            $result = Db::name('settings')->insert($data);
            return msg(1, '', '保存成功');

        }catch (\Exception $e){
            return msg(-1, '', $e->getMessage());
        }
    }
}