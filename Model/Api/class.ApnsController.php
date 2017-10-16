<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/3
 * Time: 上午10:13
 */

namespace Model\Api;


use Data\Common\ApnsTokenModel;

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

        if (!$new_device_token || $new_device_token == '(null)'){
            $this->showAjaxReturn();
        }

        $model = new ApnsTokenModel();
        if ($this->uid) {
            if ($model->where(array('uid'=>$this->uid))->count()){
                $model->where(array('uid'=>$this->uid))->data(array('device_token'=>$new_device_token))->save();
            }else {
                $model->data(array('uid'=>$this->uid, 'device_token'=>$new_device_token))->add();
            }
        }else {
            if ($model->where(array('device_token'=>$old_device_token))->count()){
                $model->where(array('device_token'=>$old_device_token))->data(array('device_token'=>$new_device_token))->save();
            }else {
                $model->data(array('device_token'=>$new_device_token))->add();
            }
        }
        $this->showAjaxReturn();
    }
}