<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:21
 */

namespace Data\Member;


use Core\Model;
use Data\Member\Builder\MemberContentBuilder;

class MemberModel extends Model
{
    protected $table = 'member';

    /**
     * @param MemberContentBuilder $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function addObject(MemberContentBuilder $object){
        if (!$object->getUsername()) {
            throw new \Exception('Empty username value');
        }

        if (!$object->getMobile()){
            throw new \Exception('Empty mobile value');
        }

        if (!$object->getPassword()) {
            throw new \Exception('Empty password value');
        }

        return $this->data($object->getBizContent())->add();
    }

    /**
     * @return MemberContentBuilder
     */
    public function getObject(){
        $data = $this->getOne();
        $object = new MemberContentBuilder($data);
        return $object;
    }

    /**
     * @param $uid
     */
    public function deleteAllData($uid){
        $condition = array('uid'=>$uid);
        $this->where($condition)->delete();
        (new MemberStatusModel())->where($condition)->delete();
        (new MemberInfoModel())->where($condition)->delete();
        (new MemberFieldModel())->where($condition)->delete();
        (new MemberLogModel())->where($condition)->delete();
        (new MemberConnectModel())->where($condition)->delete();
        (new MemberStatModel())->where($condition)->delete();
    }
}