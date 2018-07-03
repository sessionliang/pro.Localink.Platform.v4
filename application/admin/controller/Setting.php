<?php
/**
 * Created by PhpStorm.
 * User: sessionliang
 * Date: 2017/12/12
 * Time: 15:14
 */

namespace app\admin\controller;
use think\Db;

/*
 * 平台配置
 * */
class Setting extends Base
{
    public function Index($type = 'sms'){
        if (request()->isPost()) {
            $input = input('post.');
            Db::name('settings')->where(['name' => $input['setting_name']])->delete();
            $data['name'] = $input['setting_name'];
            $data['value'] = json_encode($input);
            $data['create_time'] = time();
            $date['creator_id'] = $this->admin_id;
            if (Db::name('settings')->insert($data)) {
                return json(msg(1, '', '配置成功'));
            } else {
                return json(msg(1, '', '配置失败了'));
            }
        } else {
            switch ($type) {
                case 'wxpay':
                    $result = Db::name('settings')->where(['name' => $type])->find();
                    $arr1 = [
                        'appid' => '',
                        'appsecret' => '',
                        'mchid' => '',
                        'paysignkey' => '',
                        'apiclient_cert' => '',
                        'apiclient_key' => '',
                        'setting_name' => '',
                    ];
//                    if (empty($result)) {
//                        $config = $arr1;
//                    } else {
//                        $config = diffArrayValue($arr1, json_decode($result['value'], true));
//                    }
                    $array=json_decode($result['value'], true);
                    $arr2=$array?$array:[];
                    $config=array_merge($arr1,$arr2);
                    $this->assign('payUrl',getHostDomain().url('service/Payment/wxPay','',false));
                    $this->assign('config', $config);
                    break;
                case 'uploadjsfile':

                    break;
                case 'sms':
                    $result = Db::name('settings')->where(['name' => $type])->find();

                    $arr1 = [
                        'txsms' => [
                            'appid' => '',
                            'appsecret' => '',
                        ],
                        'alisms' => [
                            'appid' => '',
                            'appsecret' => ''
                        ]
                    ];
                    $config = json_decode($result['value'], true);
                    foreach ($arr1 as $key=>$val){
                        if(isset($config[$key])){
                            $config[$key]=array_merge($arr1[$key],$config[$key]);
                        }
                    }
                    $this->assign('config', $config);
                    break;
                case 'wechat':
                    $result = Db::name('settings')->where(['name' => $type])->find();

                    $arr1 = [
                        'wxmini' => [
                            'appid' => '',
                            'secret' => '',
                        ]
                    ];
                    $config = json_decode($result['value'], true);
                    foreach ($arr1 as $key=>$val){
                        if(isset($config[$key])){
                            $config[$key]=array_merge($arr1[$key],$config[$key]);
                        }
                    }
                    $this->assign('config', $config);
                    break;
                case 'cloud':
                    $result = Db::name('settings')->where(['name' => $type])->find();

                    $arr1 = [
                        'qiniu' => [
                            'accessKey' => '',
                            'secretKey' => '',
                            'bucke'=>'',
                            'domain'=>'',
                            'status'=>'',
                        ],

                    ];
                    $config = json_decode($result['value'], true);
                    foreach ($arr1 as $key=>$val){
                        if(isset($config[$key])){
                            $config[$key]=array_merge($arr1[$key],$config[$key]);
                        }
                    }
                    $this->assign('config', $config);
                    break;
            }
            $this->assign('type', $type);
            return view();
        }
    }
}