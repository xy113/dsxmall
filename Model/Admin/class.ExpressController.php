<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/5
 * Time: 下午5:55
 */

namespace Model\Admin;


class ExpressController extends BaseController
{
    /**
     * 快递管理
     */
    public function index(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete && is_array($delete)){
                $deleteids = implodeids($delete);
                express_delete_data(array('id'=>array('IN', $deleteids)));
            }
            $express_list = $_GET['express_list'];
            if ($express_list && is_array($express_list)){
                foreach ($express_list as $id=>$express){
                    if ($express['name']) {
                        if ($id > 0) {
                            express_update_data(array('id'=>$id), $express);
                        }else {
                            express_add_data($express);
                        }
                    }
                }
            }
            $this->showSuccess('save_succeed');
        }else {
            $express_list = express_get_list(0, 0);
            include template('common/express');
        }
    }
}