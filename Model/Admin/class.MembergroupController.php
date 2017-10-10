<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/4
 * Time: 上午11:19
 */

namespace Model\Admin;


use Data\Member\MemberGroupModel;

class MembergroupController extends BaseController
{
    /**
     * 会员分组管理
     */
    public function index(){
        global $_G,$_lang;

        $model = new MemberGroupModel();
        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete) {
                foreach ($delete as $gid){
                    $model->where(array('gid'=>$gid))->delete();
                }
            }

            $grouplist = $_GET['grouplist'];
            if ($grouplist) {
                foreach ($grouplist as $gid=>$group){
                    if ($group['title']) {
                        if ($gid > 0){
                            $model->where(array('gid'=>$gid))->data($group)->save();
                        }else {
                            $model->data($group)->add();
                        }
                    }
                }
            }
            $model->updateCache();
            $this->showSuccess('update_succeed');
        }else {

            $grouplist = array();
            foreach ($model->select() as $group){
                $grouplist[$group['type']][$group['gid']] = $group;
            }
            include template('member/group_list');
        }
    }
}