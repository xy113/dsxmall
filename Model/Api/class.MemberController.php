<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 下午11:32
 */

namespace Model\Api;
use Core\Validate;
use Data\Member\MemberInfoModel;
use Data\Member\MemberModel;

class MemberController extends BaseController
{
    /**
     * 获取用户信息
     */
    public function get_info(){
        $member = (new MemberModel())->where(array('uid'=>$this->uid))->getOne();
        $info = (new MemberInfoModel())->where(array('uid'=>$this->uid))->getOne();
        $this->showAjaxReturn(array(
            'username'=>$member['username'],
            'mobile'=>$member['mobile'],
            'email'=>$member['email'],
            'usersex'=>$info['usersex'],
            'birthday'=>$info['birthday'],
            'province'=>$info['province'],
            'city'=>$info['city'],
            'county'=>$info['county'],
            'street'=>$info['street'],
            'headimg'=>avatar($this->uid)
        ));
    }

    /**
     *
     */
    public function set_headimg(){

        $upload = new \Core\UploadImage();
        if ($filedata = $upload->save()){
            $source = $upload->savepath.$filedata['image'];
            $avatardir    = C('AVATARDIR').$this->uid;
            $avatarsmall  = $this->uid.'_avatar_small.jpg';
            $avatarmiddle = $this->uid.'_avatar_middle.jpg';
            $avatarbig    = $this->uid.'_avatar_big.jpg';

            @mkdir($avatardir,0777,true);
            $image = new \Core\Image($source);
            if ($image->width() > $image->height()){
                $x = ($image->width() - $image->height())/2;
                $y = 0;
                $w = $h = $image->height();
            }else {
                $x = 0;
                $y = ($image->height() - $image->width())/2;
                $w = $h = $image->width();
            }
            $image->crop($w, $h,$x,$y,320,320);
            $image->save($avatardir.'/'.$avatarbig);
            $image->thumb(160, 160);
            $image->save($avatardir.'/'.$avatarmiddle);
            $image->thumb(100, 100);
            $image->save($avatardir.'/'.$avatarsmall);
            $this->showAjaxReturn(array('headimg'=>avatar($this->uid)));
        }else {
            $this->showAjaxError($upload->errCode);
        }
    }

    /**
     * 修改用户名
     */
    public function edit_username(){
        $memberModel = new MemberModel();
        $username = htmlspecialchars($_GET['username']);
        if ($username == $this->username || $username == ''){
            $this->showAjaxReturn();
        }else {
            if ($memberModel->where(array('username'=>$username))->count()){
                $this->showAjaxError(1, 'username_be_occupied');
            }else {
                $memberModel->where(array('uid'=>$this->uid))->data(array('username'=>$username))->save();
                $this->showAjaxReturn();
            }
        }
    }

    /**
     * 修改手机号
     */
    public function edit_mobile(){
        $memberModel = new MemberModel();
        $mobile = trim($_GET['mobile']);
        $member = $memberModel->where(array('uid'=>$this->uid))->getOne();
        if ($mobile == $member['mobile']){
            $this->showAjaxReturn();
        }else {
            $ismobile = Validate::ismobile($mobile);
            if (!$ismobile) {
                $this->showAjaxError(1, 'mobile_incorrect');
            }

            if ($memberModel->where(array('mobile'=>$mobile))->count()){
                $this->showAjaxError(2, 'mobile_be_occupied');
            }

            $memberModel->where(array('uid'=>$this->uid))->data(array('mobile'=>$mobile))->save();
            $this->showAjaxReturn();
        }
    }

    /**
     * 修改邮箱地址
     */
    public function edit_email(){
        $email = trim($_GET['email']);
        $memberModel = new MemberModel();
        $member = $memberModel->where(array('uid'=>$this->uid))->getOne();
        if ($email == $member['email']){
            $this->showAjaxReturn();
        }else {
            $isemail = Validate::isemail($email);
            if (!$isemail) {
                $this->showAjaxError(1, 'email_incorrect');
            }

            if ($memberModel->where(array('email'=>$email))->count()) {
                $this->showAjaxError(2, 'email_be_occupied');
            }
            $memberModel->where(array('uid'=>$this->uid))->data(array('email'=>$email))->save();
            $this->showAjaxReturn();
        }
    }

    /**
     * 修改密码
     */
    public function edit_password(){
        $oldpassword = trim($_GET['oldpassword']);
        $newpassword = trim($_GET['newpassword']);
        if (strlen($oldpassword) < 6 || strlen($oldpassword) > 20){
            $this->showAjaxError(1, 'old_password_incorrect');
        }
        if (strlen($newpassword) < 6 || strlen($newpassword) > 20){
            $this->showAjaxError(2, 'new_password_incorrect');
        }

        $memberModel = new MemberModel();
        $member = $memberModel->where(array('uid'=>$this->uid))->field('password')->getOne();
        if ($member['password'] !== getPassword($oldpassword)){
            $this->showAjaxError(3, 'password_incorrect');
        }else {
            $memberModel->where(array('uid'=>$this->uid))->data(array('password'=>getPassword($newpassword)))->save();
            $this->showAjaxReturn();
        }
    }

    /**
     * 修改用户资料
     */
    public function edit_info(){
        $userinfo = $_GET['userinfo'];
        if ($userinfo && is_array($userinfo)){
            $userinfo['modified'] = time();
            $res = (new MemberInfoModel())->where(array('uid'=>$this->uid))->data($userinfo)->save();
            if (!$res) {
                $userinfo['uid'] = $this->uid;
                (new MemberInfoModel())->data($userinfo)->add();
            }
        }
        $this->showAjaxReturn();
    }
}