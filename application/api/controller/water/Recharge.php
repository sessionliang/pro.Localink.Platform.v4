<?php
/**
 * Created by PhpStorm.
 * User: sessionliang
 * Date: 2018/4/25
 * Time: 18:19
 */

namespace app\api\controller\water;

use app\admin\model\Discounts;
use app\admin\model\Shippingaddresss;
use app\admin\model\water\Recharges;

/**
 * @SWG\Tag(
 *     name="Recharge",
 *     description="充值记录相关操作"
 * )
 */
class Recharge extends Base
{
    /**
     * @SWG\Get(
     *     path="/water.recharge/index",
     *     tags={"Recharge"},
     *     description="获取充值记录列表",
     *     operationId="recharge_index",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *     name="ds-token",
     *     description="访问令牌，通过login接口获取",
     *     in="header",
     *     required=true,
     *     type="string"
     *     ),
     *     @SWG\Parameter(
     *     name="start_date",
     *     description="开始日期",
     *     in="query",
     *     required=false,
     *     type="string"
     *     ),
     *     @SWG\Parameter(
     *     name="end_date",
     *     description="结束日期",
     *     in="query",
     *     required=false,
     *     type="string"
     *     ),
     *     @SWG\Parameter(
     *     name="page_size",
     *     description="页大小",
     *     in="query",
     *     required=true,
     *     type="string"
     *     ),
     *     @SWG\Parameter(
     *     name="page_number",
     *     description="第几页",
     *     in="query",
     *     required=true,
     *     type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="当code=1,返回用户充值记录；当code<0时，报错。
     *                      充值记录状态pay_status，0：未支付，1：已支付",
     *         ref="$/definitions/res_json"
     *     )
     * )
     */
    public function index(){
        try{
            if($this->checkToken()){
                $param = input('param.');

                $limit = $param['page_size'];
                $offset = ($param['page_number'] - 1) * $limit;

                $where = [];
                $where['member_id'] = $this->member_id;

                if (input("?get.start_date")&&input("?get.end_date")) {
                    $where['c.create_time'] = ['between time', [input('start_date'),input('end_date')]];
                }
                else if(input("?get.start_date")){
                    $where['c.create_time'] = ['>= time', input('start_date')];
                }
                else if(input("?get.end_date")){
                    $where['c.create_time'] = ['<= time', input('end_date')];
                }

                $recharge = new Recharges();
                $selectResult = $recharge->getRechargesByWhere($where, $offset, $limit);

//            foreach($selectResult as $key=>$vo){
//                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
//            }

                $total = $recharge->getAllRecharges($where);  // 总数据
                $rows = $selectResult;

                return resJson(1,['total' => $total, 'rows'=> $rows],'');
            }
            else{
                return resJson(-401,'','用户鉴权失败');
            }
        }
        catch (\Exception $ex){
            return resJson(-500,'','内部错误：'.$ex->getMessage());
        }
    }

    /**
     * @SWG\Post(
     *     path="/water.recharge/add",
     *     tags={"Recharge"},
     *     description="添加充值记录",
     *     operationId="recharge_add",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *     name="ds-token",
     *     description="访问令牌，通过login接口获取",
     *     in="header",
     *     required=true,
     *     type="string"
     *     ),
     *     @SWG\Parameter(
     *     name="change_count",
     *     description="购买桶数",
     *     in="formData",
     *     required=true,
     *     type="integer"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="当code=1,返回用户充值记录；当code<0时，报错。",
     *         ref="$/definitions/res_json"
     *     )
     * )
     */
    public function add(){
        try{
            if($this->checkToken()){
                $rechargeModel = new Recharges();
                $param = input('post.');
                $param['member_id'] = $this->member_id;
                $param['creator_id'] = -1 * $this->member_id;
                $result = $rechargeModel->addRecharge($param);
                return resJson($result['code'], $result['data'], $result['msg']);
            }
            else{
                return resJson(-401,'','用户鉴权失败');
            }
        }
        catch (\Exception $ex){
            return resJson(-500,'','内部错误：'.$ex->getMessage());
        }
    }


    /**
     * @SWG\Post(
     *     path="/water.recharge/paysuccess",
     *     tags={"Recharge"},
     *     description="充值已付款",
     *     operationId="recharge_paysuccess",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *     name="ds-token",
     *     description="访问令牌，通过login接口获取",
     *     in="header",
     *     required=true,
     *     type="string"
     *     ),
     *     @SWG\Parameter(
     *     name="code",
     *     description="订单号",
     *     in="formData",
     *     required=true,
     *     type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="当code=1,返回用户充值记录；当code<0时，报错。",
     *         ref="$/definitions/res_json"
     *     )
     * )
     */
    public function paysuccess(){
        try{
            if($this->checkToken()){
                $rechargeModel = new Recharges();
                $param = input('post.');
                $result = $rechargeModel->payRecharge($param['code']);
                return resJson($result['code'], $result['data'], $result['msg']);
            }
            else{
                return resJson(-401,'','用户鉴权失败');
            }
        }
        catch (\Exception $ex){
            return resJson(-500,'','内部错误：'.$ex->getMessage());
        }
    }

    /**
     * @SWG\Get(
     *     path="/water.recharge/pricerule",
     *     tags={"Recharge"},
     *     description="获取定价标准",
     *     operationId="recharge_pricerule",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *     name="ds-token",
     *     description="访问令牌，通过login接口获取",
     *     in="header",
     *     required=true,
     *     type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="当code=1,返回用户充值记录；当code<0时，报错。
     *                      types: recharge-充值，buy-直接购买",
     *         ref="$/definitions/res_json"
     *     )
     * )
     */
    public function pricerule(){
        try{
            if($this->checkToken()){
                $param = input('param.');

                $discountModel = new Discounts();
                $discounts = $discountModel->getDiscountsByWhere([],0,100);

                return resJson(1,$discounts,'');
            }
            else{
                return resJson(-401,'','用户鉴权失败');
            }
        }
        catch (\Exception $ex){
            return resJson(-500,'','内部错误：'.$ex->getMessage());
        }
    }
}