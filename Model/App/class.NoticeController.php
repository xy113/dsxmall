<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/29
 * Time: 下午10:46
 */

namespace Model\App;


class NoticeController extends BaseController
{
    /**
     * 显示通知列表
     */
    public function index(){
        global $_G,$_lang;

        $itemlist = notice_get_list(array('uid'=>$this->uid));
        include template('notice_list');
    }

    public function detail(){
        global $_G,$_lang;

        $id = intval($_GET['id']);
        $notice = notice_get_data(array('id'=>$id));
        include template('notice_detail');
    }

    private function addTest(){
        for ($i=0; $i<10; $i++){
            notice_add_data(array(
                'uid'=>$this->uid,
                'title'=>'测试消息',
                'message'=>'App上线喽，赶快现在测试吧',
                'dateline'=>time()
            ));
        }
    }
}