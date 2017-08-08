<?php
namespace Model\Common;
class CaptchaController extends BaseController{
	public function index(){
		$captcha = new \Core\Captcha();
	}
}