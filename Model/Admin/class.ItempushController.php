<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/13
 * Time: 下午4:50
 */

namespace Model\Admin;


use Data\Item\ItemPushGroupModel;
use Data\Item\ItemPushModel;

class ItempushController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $items = $_GET['items'];
            $model = new ItemPushModel();
            foreach ($items as $push_id){
                $model->where(array('push_id'=>$push_id))->delete();
            }
            $this->showSuccess('delete_succeed');
        }else {
            $pagesize = 20;
            $condition = array();
            $groupid = intval($_GET['groupid']);
            if ($groupid) $condition[] = "p.groupid='$groupid'";

            $totalnum = M('item_push p')->join('item i', 'i.itemid=p.itemid')->where($condition)->count();
            $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $_G['page'] = min(array($_G['page'], $pagecount));
            $fileds = 'p.push_id,i.itemid,i.title,i.thumb,i.image,i.price,i.sold,i.on_sale,i.create_time';
            $itemlist   = M('item_push p')->field($fileds)->join('item i', 'i.itemid=p.itemid')
                ->where($condition)->order('p.push_id DESC')->page($_G['page'], $pagesize)->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, "groupid=$groupid", true);
            unset($condition, $queryParams);

            $grouplist = (new ItemPushGroupModel())->getCache();
            include template('item/push_list');
        }
    }

    /**
     *
     */
    public function add(){
        global $_G,$_lang;

        $groupid = intval($_GET['groupid']);
        if ($this->checkFormSubmit()){
            $itemid = intval($_GET['itemid']);
            if ($groupid && $itemid){
                (new ItemPushModel())->data(array(
                    'uid'=>$this->uid,
                    'itemid'=>$itemid,
                    'groupid'=>$groupid,
                    'create_time'=>time()
                ))->add();
                $this->showAjaxReturn();
            }else {
                $this->showAjaxError(1, 'invalid_parameter');
            }
        }else {

            $grouplist = (new ItemPushGroupModel())->getCache();
            include template('item/push_add');
        }
    }

    /**
     *
     */
    public function grouplist(){
        global $_G,$_lang;

        $model = new ItemPushGroupModel();
        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete) {
                foreach ($delete as $groupid){
                    $model->where(array('groupid'=>$groupid))->delete();
                }
            }
            $grouplist = $_GET['grouplist'];
            foreach ($grouplist as $groupid=>$group){
                if ($group['grouptitle']) {
                    if ($groupid > 0){
                        $model->data($group)->where(array('groupid'=>$groupid))->save();
                    }else {
                        $model->data($group)->add();
                    }
                }
            }
            $model->setCache();
            $this->showSuccess('update_succeed');
        }else {

            $grouplist = $model->select();
            include template('item/push_group');
        }
    }
}