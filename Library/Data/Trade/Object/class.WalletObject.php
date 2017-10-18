<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午12:33
 */

namespace Data\Trade\Object;


use Core\DSXObject;

class WalletObject extends DSXObject
{
    protected $fields = array(
        'uid'=>'',
        'balance'=>'',
        'total_income'=>'',
        'total_cost'=>''
    );

    private $uid;
    private $balance;
    private $total_income;
    private $total_cost;

    /**
     * @param mixed $uid
     * @return $this
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        $this->fields['uid'] = $uid;
        return $this;
    }

    /**
     * @param mixed $balance
     * @return $this
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
        $this->fields['balance'] = $balance;
        return $this;
    }

    /**
     * @param mixed $total_income
     * @return $this
     */
    public function setTotalIncome($total_income)
    {
        $this->total_income = $total_income;
        $this->fields['total_income'];
        return $this;
    }

    /**
     * @param mixed $total_cost
     * @return $this
     */
    public function setTotalCost($total_cost)
    {
        $this->total_cost = $total_cost;
        $this->fields['total_cost'] = $total_cost;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return mixed
     */
    public function getTotalIncome()
    {
        return $this->total_income;
    }

    /**
     * @return mixed
     */
    public function getTotalCost()
    {
        return $this->total_cost;
    }
}