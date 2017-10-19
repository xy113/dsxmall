<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 上午11:42
 */

namespace Data\Shop\Builder;


use Core\DSXObject;

class ShopRecordObject extends DSXObject
{
    protected $fields = array(
        'shop_id'=>'',
        'visit_num'=>'',
        'order_num'=>'',
        'turnovers'=>'',
        'datestamp'=>''
    );

    public $shop_id;
    public $visit_num;
    public $order_num;
    public $turnovers;
    public $datestamp;

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setFields($fields)
    {
        if (is_array($fields)) {
            foreach ($fields as $name=>$value){
                if (isset($this->fields[$name])) {
                    $this->$name = $value;
                    $this->fields[$name] = $value;
                }
            }
        }
        return $this;
    }

    /**
     * @param mixed $shop_id
     * @return $this
     */
    public function setShopId($shop_id)
    {
        $this->shop_id = $shop_id;
        $this->fields['shop_id'] = $shop_id;
        return $this;
    }

    /**
     * @param mixed $visit_num
     * @return $this
     */
    public function setVisitNum($visit_num)
    {
        $this->visit_num = $visit_num;
        $this->fields['visit_num'] = $visit_num;
        return $this;
    }

    /**
     * @param mixed $order_num
     * @return $this
     */
    public function setOrderNum($order_num)
    {
        $this->order_num = $order_num;
        $this->fields['order_num'] = $order_num;
        return $this;
    }

    /**
     * @param mixed $turnovers
     * @return $this
     */
    public function setTurnovers($turnovers)
    {
        $this->turnovers = $turnovers;
        $this->fields['turnovers'] = $turnovers;
        return $this;
    }

    /**
     * @param mixed $datestamp
     * @return $this
     */
    public function setDatestamp($datestamp)
    {
        $this->datestamp = $datestamp;
        $this->fields['datestamp'] = $datestamp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShopId()
    {
        return $this->shop_id;
    }

    /**
     * @return mixed
     */
    public function getVisitNum()
    {
        return $this->visit_num;
    }

    /**
     * @return mixed
     */
    public function getOrderNum()
    {
        return $this->order_num;
    }

    /**
     * @return mixed
     */
    public function getTurnovers()
    {
        return $this->turnovers;
    }

    /**
     * @return mixed
     */
    public function getDatestamp()
    {
        return $this->datestamp;
    }
}