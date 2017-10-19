<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午10:17
 */

namespace Data\Member;


use Core\Model;
use Data\Member\Object\AddressObject;

class AddressModel extends Model
{
    protected $table = 'address';

    /**
     * @return AddressModel
     */
    public static function getInstance(){
        static $instance;
        if (!is_object($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param AddressObject $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function AddObject(AddressObject $object){
        if (!$object->getUid()) {
            throw new \Exception('Empty uid value');
        }

        if (!$object->getConsignee()) {
            throw new \Exception('Empty consignee value');
        }

        if (!$object->getPhone()) {
            throw new \Exception('Empty phone value');
        }

        if (!$object->getProvince()) {
            throw new \Exception('Empty province value');
        }

        if (!$object->getCity()) {
            throw new \Exception('Empty city value');
        }

        if (!$object->getCounty()) {
            throw new \Exception('Empty county value');
        }

        if (!$object->getStreet()) {
            throw new \Exception('Empty street value');
        }
        return $this->data($object->getBizContent())->add();
    }

    /**
     * @return AddressObject
     */
    public function getObject(){
        $data = $this->getOne();
        $object = new AddressObject();
        return $object->initWithData($data);
    }
}