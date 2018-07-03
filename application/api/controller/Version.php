<?php
namespace app\api\controller;

use app\admin\model\Cashiers;
use app\admin\model\Goodcategorys;
use app\admin\model\Members;
use app\admin\model\Salespersons;
use app\admin\validate\MemberPoints;
use app\admin\validate\ReturnPoints;
use app\common\model\MemberReturns;
use think\Db;
use think\Exception;
use think\Loader;

Loader::import("weixin/common", APP_PATH, EXT);
/**
 * Created by PhpStorm.
 * User: bobingxin
 * Date: 2017/12/8
 * Time: 下午4:36
 */
class Version extends Base{
    public function index(){
        return THINK_VERSION;
    }
}