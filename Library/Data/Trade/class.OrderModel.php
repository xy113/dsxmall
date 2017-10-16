<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:12
 */

namespace Data\Trade;


use Core\Model;
use Data\Trade\Builder\OrderContentBuilder;

class OrderModel extends Model
{
    protected $table = 'order';

    /**
     * @param OrderContentBuilder $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function addObject(OrderContentBuilder $object){
        if (!$object->getBuyer_uid()) {
            throw new \Exception('Empty buyer_uid value');
        }

        if (!$object->getBuyer_name()){
            throw new \Exception('Empty buyer_name value');
        }

        if (!$object->getSeller_uid()){
            throw new \Exception('Empty seller_uid value');
        }

        if (!$object->getSeller_name()){
            throw new \Exception('Empty seller_name value');
        }

        if (!$object->getShop_id()){
            throw new \Exception('Empty shop_id value');
        }

        if (!$object->getShop_name()){
            throw new \Exception('Empty shop_name value');
        }

        if (!$object->getOrder_no()){
            throw new \Exception('Empty order_no value');
        }

        if (!$object->getOrder_fee()){
            throw new \Exception('Empty order_fee value');
        }

        if (!$object->getTotal_fee()){
            throw new \Exception('Empty total_fee value');
        }

        if (!$object->getPay_type()){
            throw new \Exception('Empty pay_type value');
        }

        if (!$object->getPay_status()){
            $object->setPay_status(0);
        }

        if (!$object->getCreate_time()){
            $object->setCreate_time(time());
        }

        if (!$object->getTrade_no()){
            throw new \Exception('Empty trade_no value');
        }

        if (!$object->getConsignee()){
            throw new \Exception('Empty consignee value');
        }

        if (!$object->getPhone()){
            throw new \Exception('Empty phone value');
        }

        if (!$object->getAddress()){
            throw new \Exception('Empty address value');
        }

        return $this->data($object->getBizContent())->add();
    }

    /**
     * @return OrderContentBuilder
     */
    public function getObject(){
        $data = $this->getOne();
        $object = new OrderContentBuilder();
        $object->setData($data);
        return $object;
    }

    /**
     * @param $order_id
     */
    public function deleteAllData($order_id){
        $condition = array('order_id'=>$order_id);
        if ($this->where($condition)->delete()){
            (new OrderItemModel())->where($condition)->delete();
            (new OrderActionModel())->where($condition)->delete();
            (new OrderShippingModel())->where($condition)->delete();
            (new OrderRefundModel())->where($condition)->delete();
        }
    }

    /**
     * 生成订单号
     * @param $uid
     * @param string $type
     * @return string
     */
    public function createNo($uid, $type='6'){
        return $type.time().substr($uid, -5);
    }
}