<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/23
 * Time: 上午9:55
 */

namespace Model\Plugin;


use Core\Captcha;

class CaptchaController extends BaseController
{
    /**
     *
     */
    public function index(){
        $captcha = new Captcha();
        $captcha->createCode();
    }
}