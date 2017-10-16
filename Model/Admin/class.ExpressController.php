<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/5
 * Time: 下午5:55
 */

namespace Model\Admin;


use Data\Common\ExpressModel;

class ExpressController extends BaseController
{
    /**
     * 快递管理
     */
    public function index(){
        global $_G,$_lang;

        $model = new ExpressModel();
        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete && is_array($delete)){
                foreach ($delete as $id){
                    $model->where(array('id'=>$id))->delete();
                }
            }
            $express_list = $_GET['express_list'];
            if ($express_list && is_array($express_list)){
                foreach ($express_list as $id=>$express){
                    if ($express['name']) {
                        if ($id > 0) {
                            $model->where(array('id'=>$id))->data($express)->save();
                        }else {
                            $model->data($express)->add();
                        }
                    }
                }
            }
            $this->showSuccess('save_succeed');
        }else {
            $express_list = $model->select();
            include template('common/express');
        }
    }
}