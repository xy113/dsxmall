<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:46
 */

namespace Data\Trade;


use Core\Model;
use Data\Trade\Builder\WalletContentBuilder;

class WalletModel extends Model
{
    protected $table = 'wallet';

    /**
     * @return WalletModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param WalletContentBuilder $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function insertObject(WalletContentBuilder $object){
        if (!$object->getUid()){
            throw new \Exception('Empty uid value');
        }

        if (!$object->getBalance()){
            $object->setBalance(0);
        }

        return $this->add($object->getBizContent());
    }

    /**
     * @param $uid
     * @return WalletContentBuilder
     */
    public function getObject($uid){
        return new WalletContentBuilder($this->getWallet($uid));
    }

    /**
     * @param $uid
     * @return array|null
     */
    public function getWallet($uid){
        $data = $this->where(array('uid'=>$uid))->getOne();
        if (!$data) {
            $object = new WalletContentBuilder();
            $object->setUid($uid);
            $object->setBalance(0);
            $object->setTotal_income(0);
            $object->setTotal_cost(0);
            $this->insertObject($object);
            return $this->getWallet($uid);
        }else {
            return $data;
        }
    }

    /**
     * 增加余额
     * @param $uid
     * @param $amount
     * @return bool
     */
    public function increase($uid, $amount){
        $amount = floatval($amount);
        if ($uid && $amount){
            $wallet = $this->getWallet($uid);
            $balance = $wallet['balance'] + $amount;
            $total_income = $wallet['total_income'] + $amount;
            return $this->where(array('uid'=>$uid))->update(array('balance'=>$balance, 'total_income'=>$total_income));
        }else {
            return false;
        }
    }

    /**
     * 扣除余额
     * @param $uid
     * @param $amount
     * @return bool|int
     */
    public function deduction($uid, $amount){
        $amount = floatval($amount);
        if ($uid && $amount){
            $wallet = $this->getWallet($uid);
            if ($wallet['balance'] >= $amount){
                $balance = $wallet['balance'] - $amount;
                $total_cost = $wallet['total_cost'] + $amount;
                return $this->where(array('uid'=>$uid))->update(array('balance'=>$balance, 'total_cost'=>$total_cost));
            }else {
                return false;
            }

        }else {
            return false;
        }
    }
}