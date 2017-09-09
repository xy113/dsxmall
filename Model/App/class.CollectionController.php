<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/29
 * Time: 下午10:21
 */

namespace Model\App;


class CollectionController extends BaseController
{
    /**
     *
     */
    public function index(){
        $this->item();
    }

    /**
     *
     */
    public function item(){
        global $_G,$_lang;

        $pagesize = 10;
        $condition = array('uid'=>$this->uid, 'datatype'=>'item');
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition['title'] = array('LIKE', $q);

        $totalnum  = collection_get_count($condition);
        $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $collection_list = collection_get_list($condition, $pagesize, ($_G['page'] - 1) * $pagesize);
        if ($collection_list) {
            $datalist = $itemids = array();
            foreach ($collection_list as $coll){
                $datalist[$coll['dataid']] = $coll;
                $itemids[] = $coll['dataid'];
            }
            $collection_list = $datalist;
            unset($datalist, $coll);

            $itemids = $itemids ? implodeids($itemids) : 0;
            if ($itemids) {
                $itemlist = item_get_list(array('itemid'=>array('IN', $itemids)), 0, 0, null, 'itemid,title,price,thumb,sold');
                foreach ($itemlist as $item){
                    $collection_list[$item['itemid']]['title'] = $item['title'];
                    $collection_list[$item['itemid']]['price'] = $item['price'];
                    $collection_list[$item['itemid']]['thumb'] = image($item['thumb']);
                    $collection_list[$item['itemid']]['sold']  = $item['sold'];
                }
            }
            unset($itemids, $itemlist, $item);
        }
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "", true);

        $_G['title'] = $_lang['item_collection'];
        include template('collection_item');
    }

    /**
     * 商品收藏
     */
    public function goods(){
        $this->item();
    }

    /**
     * 店铺收藏
     */
    public function shop(){
        global $_G,$_lang;

        $pagesize = 10;
        $condition = array('uid'=>$this->uid, 'datatype'=>'shop');
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition['title'] = array('LIKE', $q);

        $totalnum  = collection_get_count($condition);
        $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $itemlist = collection_get_list($condition, $pagesize, ($_G['page'] - 1) * $pagesize);
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "", true);

        $_G['title'] = $_lang['shop_collection'];
        include template('collection_shop');
    }
}