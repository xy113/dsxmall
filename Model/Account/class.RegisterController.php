<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/25
 * Time: 下午2:27
 */
namespace Model\Account;
use Core\Validate;
use Data\Member\MemberGroupModel;
use Data\Member\MemberInfoModel;
use Data\Member\MemberModel;
use Data\Member\MemberStatusModel;

class RegisterController extends BaseController{
    /**
     * RegisterController constructor.
     */
    function __construct(){
        parent::__construct();
        if ($this->uid) $this->redirect(U('/'));
    }

    public function index(){
        if ($this->checkFormSubmit()){
            $this->save();
        }else {
            member_show_register();
        }
    }

    /**
     * 保存注册信息
     */
    function save(){
        $username = htmlspecialchars($_GET['username_'.FORMHASH]);
        $password = trim($_GET['password_'.FORMHASH]);
        $mobile   = trim($_GET['mobile_'.FORMHASH]);

        $memberModel = new MemberModel();
        if ($memberModel->where(array('username'=>$username))->count()){
            $this->showAjaxError(1, 'username_be_occupied');
        }

        if (!Validate::ismobile($mobile)){
            $this->showAjaxError(2, 'mobile_incorrect');
        }

        if ($memberModel->where(array('mobile'=>$mobile))->count()){
            $this->showAjaxError(3, 'mobile_be_occupied');
        }

        if (strlen($password)<6 || strlen($password)>20){
            $this->showAjaxError(4, 'password_input_incorrect');
        }

        $group = (new MemberGroupModel())->where(array('type'=>'member'))->order('creditslower', 'ASC')->getOne();
        $uid = $memberModel->data(array('gid'=>$group['gid'],'username'=>$username, 'password'=>getPassword($password), 'mobile'=>$mobile))->add();
        (new MemberStatusModel())->data(array('uid'=>$uid,'regdate'=>time(),'regip'=>getIp()))->add();
        (new MemberInfoModel())->data(array('uid'=>$uid))->add();

        cookie('uid', $uid, 1800);
        cookie('username', $username, 1800);

        $this->showAjaxReturn();
    }
}