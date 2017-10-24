<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:13
 */

namespace Data\Trade;


use Core\Model;
use Data\Trade\Object\TradeObject;

class TradeModel extends Model
{
    protected $table = 'trade';

    /**
     * @return TradeModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }


    /**
     * @param TradeObject $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function addObject(TradeObject $object){
        if (!$object->getPayerUid()){
            throw new \Exception('Empty payer_uid value');
        }

        if (!$object->getPayerName()){
            throw new \Exception('Empty payer_name value');
        }

        if (!$object->getPayeeUid()){
            throw new \Exception('Empty payee_uid value');
        }

        if (!$object->getPayeeName()){
            throw new \Exception('Empty payee_name value');
        }

        if (!$object->getPayStatus()){
            $object->setPayStatus(0);
        }

        if (!$object->getTradeNo()){
            throw new \Exception('Empty trade_no value');
        }

        if (!$object->getTradeName()){
            throw new \Exception('Empty trade_name value');
        }

        if (!$object->getTradeDesc()){
            throw new \Exception('Empty trade_desc value');
        }

        if (!$object->getTradeFee()){
            throw new \Exception('Empty trade_fee value');
        }

        if (!$object->getTradeType()){
            throw new \Exception('Empty trade_type value');
        }

        if (!$object->getTradeTime()){
            $object->setTradeTime(time());
        }
        return $this->data($object->getBizContent())->add();
    }

    public function createNo(){
        return date('YmdHis').rand(100,999).rand(100,999);
    }
}