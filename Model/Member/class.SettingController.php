<?php
namespace Model\Member;
use Core\UploadImage;
use Core\Validate;
use Data\Member\MemberInfoModel;
use Data\Member\MemberModel;

class SettingController extends BaseController{
    function __construct()
    {
        parent::__construct();
        G('menu', 'userinfo');
    }

    public function index(){
		$this->userinfo();
	}
	
	/**
	 * 用户基本信息
	 */
	public function userinfo(){
		global $_G,$_lang;

		$infoModel = new MemberInfoModel();
		if ($this->checkFormSubmit()) {
			$userinfo = $_GET['userinfo'];
			if ($userinfo && is_array($userinfo)) {
				$userinfo['modified'] = TIMESTAMP;
				$infoModel->where(array('uid'=>$this->uid))->data($userinfo)->save();
				$this->showAjaxReturn(0);
			}else {
				$this->showAjaxError(101, L('invalid_parameter'));
			}
		}else {
			$userinfo = $infoModel->where(array('uid'=>$this->uid))->getOne();
				
			$_G['title'] = $_lang['title_userinfo'];
			include template('setting_userinfo');
		}
	}
	
	/**
	 * 绑定手机号
	 */
	public function bindmobile(){
		$mobile = htmlspecialchars($_GET['mobile']);
		$captchacode = trim($_GET['captchacode']);
		
		$this->checkCaptchacode($captchacode, 1);
		if (!$this->checkFormSubmit()) {
			$this->showAjaxError(301, L('undefined_action'));
		}

		if (Validate::ismobile($mobile)) {
		    $memberModel = new MemberModel();
			if ($memberModel->where(array('mobile'=>$mobile))->count()){
				$this->showAjaxError(102, L('mobile_be_occupied'));
			}else {
			    $memberModel->where(array('uid'=>$this->uid))->data(array('mobile'=>$mobile))->save();
				$this->showAjaxReturn(0);
			}
		}else {
			$this->showAjaxError(101, L('mobile_incorrect'));
		}
	}
	
	/**
	 * 绑定邮箱
	 */
	public function bindemail(){
		$email = htmlspecialchars($_GET['email']);
		$captchacode = trim($_GET['captchacode']);
		
		$this->checkCaptchacode($captchacode, 1);
		if (!$this->checkFormSubmit()) {
			$this->showAjaxError(301, L('undefined_action'));
		}
		
		if (Validate::isemail($email)) {
            $memberModel = new MemberModel();
			if ($memberModel->where(array('email'=>$email))->count()){
				$this->showAjaxError(202, L('email_be_occupied'));
			}else {
			    $memberModel->where(array('uid'=>$this->uid))->data(array('email'=>$email))->save();
				$this->showAjaxReturn(0);
			}
		}else {
			$this->showAjaxError(201, L('email_incorrect'));
		}
	}
	
	/**
	 * 更新密码
	 */
	public function password(){
		$password = trim($_GET['password']);
		$newpassword = trim($_GET['newpassword']);
		$captchacode = trim($_GET['captchacode']);
		
		$this->checkCaptchacode($captchacode, 1);
		if (!$this->checkFormSubmit()) {
			$this->showAjaxError(301, L('undefined_action'));
		}

        $memberModel = new MemberModel();
		$member = $memberModel->where(array('uid'=>$this->uid))->getOne();
		if ($member['password'] !== getPassword($password)){
			$this->showAjaxError(302, L('password_incorrect'));
		}else {
		    $memberModel->where(array('uid'=>$this->uid))->data(array('password'=>getPassword($newpassword)))->save();
			$this->showAjaxReturn(0);
		}
	}
	
	/**
	 * 上传头像
	 */
	public function uploadavatar(){
	    $upload = new UploadImage();
	    if ($filedata = $upload->save()){
            $source = C('IMAGEDIR').$filedata['image'];
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
            (new MemberModel())->where(array('uid'=>$this->uid))->data(array('avatarstatus'=>1))->save();
            $this->showAjaxReturn(array('avatar'=>avatar($this->uid)));
        }
	}
	
	public function verify(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()) {
			
		}else {
			
			$_G['title'] = $_lang['title_verify'];
			include template('setting_verify');
		}
	}

    /**
     *
     */
    public function security(){
		global $_G,$_lang;
        G('menu', 'security');
		
		$userinfo = (new MemberModel())->where(array('uid'=>$this->uid))->getOne();
		if ($userinfo['mobile']) {
			$userinfo['mobile'] = substr($userinfo['mobile'], 0, 3).'****'.substr($userinfo['mobile'], -4, strlen($userinfo['mobile']));
		}
		
		if ($userinfo['email']) {
			$userinfo['email'] = substr($userinfo['email'], 0, 3).'****'.substr($userinfo['email'], strrpos($userinfo['email'], '@'));
		}

		$_G['title'] = $_lang['title_security'];
		include template('setting_security');
	}
}