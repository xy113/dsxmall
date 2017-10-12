<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/12
 * Time: 下午1:25
 */

namespace Data\Member\Builder;


use Core\Builder;

class MemberContentBuilder extends Builder
{
    protected $data = array(
        'uid'=>'',
        'gid'=>'',
        'adminid'=>'',
        'admincp'=>'',
        'username'=>'',
        'password'=>'',
        'email'=>'',
        'mobile'=>'',
        'status'=>'',
        'newpm'=>'',
        'emailstatus'=>'',
        'avatarstatus'=>'',
        'freeze'=>''
    );

    public function setUid($value){
        $this->data['uid'] = $value;
    }

    public function getUid(){
        return $this->data['uid'];
    }

    public function setGid($value){
        $this->data['gid'] = $value;
    }

    public function getGid(){
        return $this->data['gid'];
    }

    public function setAdminid($value){
        $this->data['adminid'] = $value;
    }

    public function getAdminid(){
        return $this->data['adminid'];
    }

    public function setAdmincp($value){
        $this->data['admincp'] = $value;
    }

    public function getAdmincp(){
        return $this->data['admincp'];
    }

    public function setUsername($value){
        $this->data['username'] = $value;
    }

    public function getUsername(){
        return $this->data['username'];
    }

    public function setPassword($value){
        $this->data['password'] = $value;
    }

    public function getPassword(){
        return $this->data['password'];
    }

    public function setEmail($value){
        $this->data['email'] = $value;
    }

    public function getEmail(){
        return $this->data['email'];
    }

    public function setMobile($value){
        $this->data['mobile'] = $value;
    }

    public function getMobile(){
        return $this->data['mobile'];
    }

    public function setStatus($value){
        $this->data['status'] = $value;
    }

    public function getStatus(){
        return $this->data['status'];
    }

    public function setNewpm($value){
        $this->data['newpm'];
    }

    public function getNewpm(){
        return $this->data['newpm'];
    }

    public function setEmailstatus($value){
        $this->data['emailstatus'] = $value;
    }


    public function getEmailstatus(){
        return $this->data['emailstatus'];
    }

    public function setAvatarstatus($value){
        $this->data['avatarstatus'] = $value;
    }

    public function getAvatarstatus(){
        return $this->data['avatarstatus'];
    }

    public function setFreeze($value){
        $this->data['freeze'] = $value;
    }

    public function getFreeze(){
        return $this->data['freeze'];
    }
}