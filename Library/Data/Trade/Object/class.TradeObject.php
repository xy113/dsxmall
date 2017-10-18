<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午1:32
 */

namespace Data\Trade\Object;


use Core\DSXObject;

class TradeObject extends DSXObject
{
    protected $fields = array(
        'trade_id'=>'',
        'payer_uid'=>'',
        'payer_name'=>'',
        'payee_uid'=>'',
        'payee_name'=>'',
        'pay_type'=>'',
        'pay_status'=>'',
        'trade_no'=>'',
        'trade_name'=>'',
        'trade_desc'=>'',
        'trade_fee'=>'',
        'trade_type'=>'',
        'trade_time'=>'',
        'out_trade_no'=>''
    );

    private $trade_id;
    private $payer_uid;
    private $payer_name;
    private $payee_uid;
    private $payee_name;
    private $pay_type;
    private $pay_status;
    private $trade_no;
    private $trade_name;
    private $trade_desc;
    private $trade_fee;
    private $trade_type;
    private $trade_time;
    private $out_trade_no;

    /**
     * @param mixed $trade_id
     * @return $this
     */
    public function setTradeId($trade_id)
    {
        $this->trade_id = $trade_id;
        $this->fields['trade_id'] = $trade_id;
        return $this;
    }

    /**
     * @param mixed $payer_uid
     * @return $this
     */
    public function setPayerUid($payer_uid)
    {
        $this->payer_uid = $payer_uid;
        $this->fields['payer_uid'] = $payer_uid;
        return $this;
    }

    /**
     * @param mixed $payer_name
     * @return $this
     */
    public function setPayerName($payer_name)
    {
        $this->payer_name = $payer_name;
        $this->fields['payer_name'] = $payer_name;
        return $this;
    }

    /**
     * @param mixed $payee_uid
     * @return $this
     */
    public function setPayeeUid($payee_uid)
    {
        $this->payee_uid = $payee_uid;
        $this->fields['payee_uid'] = $payee_uid;
        return $this;
    }

    /**
     * @param mixed $payee_name
     * @return $this
     */
    public function setPayeeName($payee_name)
    {
        $this->payee_name = $payee_name;
        $this->fields['payee_name'] = $payee_name;
        return $this;
    }

    /**
     * @param mixed $pay_type
     * @return $this
     */
    public function setPayType($pay_type)
    {
        $this->pay_type = $pay_type;
        $this->fields['pay_type'] = $pay_type;
        return $this;
    }

    /**
     * @param mixed $pay_status
     * @return $this
     */
    public function setPayStatus($pay_status)
    {
        $this->pay_status = $pay_status;
        $this->fields['pay_status'] = $pay_status;
        return $this;
    }

    /**
     * @param mixed $trade_no
     * @return $this
     */
    public function setTradeNo($trade_no)
    {
        $this->trade_no = $trade_no;
        $this->fields['trade_no'] = $trade_no;
        return $this;
    }

    /**
     * @param mixed $trade_name
     * @return $this
     */
    public function setTradeName($trade_name)
    {
        $this->trade_name = $trade_name;
        $this->fields['trade_name'] = $trade_name;
        return $this;
    }

    /**
     * @param mixed $trade_desc
     * @return $this
     */
    public function setTradeDesc($trade_desc)
    {
        $this->trade_desc = $trade_desc;
        $this->fields['trade_desc'] = $trade_desc;
        return $this;
    }

    /**
     * @param mixed $trade_fee
     * @return $this
     */
    public function setTradeFee($trade_fee)
    {
        $this->trade_fee = $trade_fee;
        $this->fields['trade_fee'] = $trade_fee;
        return $this;
    }

    /**
     * @param mixed $trade_type
     * @return $this
     */
    public function setTradeType($trade_type)
    {
        $this->trade_type = $trade_type;
        $this->fields['trade_type'] = $trade_type;
        return $this;
    }

    /**
     * @param mixed $trade_time
     * @return $this
     */
    public function setTradeTime($trade_time)
    {
        $this->trade_time = $trade_time;
        $this->fields['trade_time'] = $trade_time;
        return $this;
    }

    /**
     * @param mixed $out_trade_no
     * @return $this
     */
    public function setOutTradeNo($out_trade_no)
    {
        $this->out_trade_no = $out_trade_no;
        $this->fields['out_trade_no'] = $out_trade_no;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTradeId()
    {
        return $this->trade_id;
    }

    /**
     * @return mixed
     */
    public function getPayerUid()
    {
        return $this->payer_uid;
    }

    /**
     * @return mixed
     */
    public function getPayerName()
    {
        return $this->payer_name;
    }

    /**
     * @return mixed
     */
    public function getPayeeUid()
    {
        return $this->payee_uid;
    }

    /**
     * @return mixed
     */
    public function getPayeeName()
    {
        return $this->payee_name;
    }

    /**
     * @return mixed
     */
    public function getPayType()
    {
        return $this->pay_type;
    }

    /**
     * @return mixed
     */
    public function getPayStatus()
    {
        return $this->pay_status;
    }

    /**
     * @return mixed
     */
    public function getTradeNo()
    {
        return $this->trade_no;
    }

    /**
     * @return mixed
     */
    public function getTradeName()
    {
        return $this->trade_name;
    }

    /**
     * @return mixed
     */
    public function getTradeDesc()
    {
        return $this->trade_desc;
    }

    /**
     * @return mixed
     */
    public function getTradeFee()
    {
        return $this->trade_fee;
    }

    /**
     * @return mixed
     */
    public function getTradeType()
    {
        return $this->trade_type;
    }

    /**
     * @return mixed
     */
    public function getTradeTime()
    {
        return $this->trade_time;
    }

    /**
     * @return mixed
     */
    public function getOutTradeNo()
    {
        return $this->out_trade_no;
    }
}