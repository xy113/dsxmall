<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/3
 * Time: 上午10:13
 */

namespace Model\Api;


class ApnsController extends BaseController
{
    public function index(){

    }

    /**
     * 更新deviceToken
     */
    public function update_token(){
        $old_device_token = preg_replace('/\<(.*?)\>/is', '\\1', trim($_GET['old_device_token']));
        $old_device_token = preg_replace('/\s/', '', $old_device_token);
        $new_device_token = preg_replace('/\<(.*?)\>/is', '\\1', trim($_GET['new_device_token']));
        $new_device_token = preg_replace('/\s/', '', $new_device_token);

        if ($old_device_token) {
            if (apns_get_token(array('device_token'=>$old_device_token))){
                apns_update_token(array('device_token'=>$old_device_token),array(
                    'uid'=>$this->uid,
                    'device_token'=>$new_device_token
                ));
            }else {
                apns_add_token(array(
                    'uid'=>$this->uid,
                    'device_token'=>$new_device_token
                ));
            }
        }else {
            if ($this->uid && apns_get_token(array('uid'=>$this->uid))) {
                apns_update_token(array('uid'=>$this->uid), array('device_token'=>$new_device_token));
            }else {
                apns_add_token(array(
                    'uid'=>$this->uid,
                    'device_token'=>$new_device_token
                ));
            }
        }
        $this->showAjaxReturn();
    }
}