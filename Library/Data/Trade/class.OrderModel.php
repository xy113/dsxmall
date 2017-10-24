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
use Data\Trade\Object\OrderObject;

class OrderModel extends Model
{
    protected $table = 'order';

    /**
     * @return OrderModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    public function addObject(OrderObject $object){
        if (!$object->getBuyerUid()) {
            throw new \Exception('Empty buyer_uid value');
        }

        if (!$object->getBuyerName()){
            throw new \Exception('Empty buyer_name value');
        }

        if (!$object->getSellerUid()){
            throw new \Exception('Empty seller_uid value');
        }

        if (!$object->getSellerName()){
            throw new \Exception('Empty seller_name value');
        }

        if (!$object->getShopId()){
            throw new \Exception('Empty shop_id value');
        }

        if (!$object->getShopName()){
            throw new \Exception('Empty shop_name value');
        }

        if (!$object->getOrderNo()){
            throw new \Exception('Empty order_no value');
        }

        if (!$object->getOrderFee()){
            throw new \Exception('Empty order_fee value');
        }

        if (!$object->getTotalFee()){
            throw new \Exception('Empty total_fee value');
        }

        if (!$object->getPayType()){
            throw new \Exception('Empty pay_type value');
        }

        if (!$object->getPayStatus()){
            $object->setPayStatus(0);
        }

        if (!$object->getCreateTime()){
            $object->setCreateTime(time());
        }

        if (!$object->getTradeNo()){
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