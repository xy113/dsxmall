<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:13
 */

namespace Data\Trade;


use Core\Model;
use Data\Trade\Builder\TradeContentBuilder;

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
     * @param TradeContentBuilder $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function addObject(TradeContentBuilder $object){
        if (!$object->getPayer_uid()){
            throw new \Exception('Empty payer_uid value');
        }

        if (!$object->getPayer_name()){
            throw new \Exception('Empty payer_name value');
        }

        if (!$object->getPayee_uid()){
            throw new \Exception('Empty payee_uid value');
        }

        if (!$object->getPayee_name()){
            throw new \Exception('Empty payee_name value');
        }

        if (!$object->getPay_status()){
            $object->setPay_status(0);
        }

        if (!$object->getTrade_no()){
            throw new \Exception('Empty trade_no value');
        }

        if (!$object->getTrade_name()){
            throw new \Exception('Empty trade_name value');
        }

        if (!$object->getTrade_desc()){
            throw new \Exception('Empty trade_desc value');
        }

        if (!$object->getTrade_fee()){
            throw new \Exception('Empty trade_fee value');
        }

        if (!$object->getTrade_type()){
            throw new \Exception('Empty trade_type value');
        }

        if (!$object->getTrade_time()){
            $object->setTrade_time(time());
        }
        return $this->data($object->getBizContent())->add();
    }

    public function createNo(){
        return date('YmdHis').rand(100,999).rand(100,999);
    }
}