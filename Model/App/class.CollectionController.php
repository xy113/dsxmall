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
    public function index(){

    }

    public function goods(){
        global $_G,$_lang;

        $pagesize = 10;
        $condition = array('uid'=>$this->uid, 'datatype'=>'goods');
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition['title'] = array('LIKE', $q);

        $totalnum  = collection_get_count($condition);
        $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $itemlist = collection_get_list($condition, $pagesize, ($_G['page'] - 1) * $pagesize);
        if ($itemlist) {
            $datalist = $goods_ids = array();
            foreach ($itemlist as $item){
                $datalist[$item['dataid']] = $item;
                $goods_ids[] = $item['dataid'];
            }
            $itemlist = $datalist;
            unset($datalist, $item);

            $goods_ids = $goods_ids ? implodeids($goods_ids) : 0;
            if ($goods_ids) {
                $goods_list = goods_get_item_list(array('id'=>array('IN', $goods_ids)), 0, 0, null, 'id,goods_name,goods_price,goods_thumb,sold');
                foreach ($goods_list as $goods){
                    $itemlist[$goods['id']]['goods_name'] = $goods['goods_name'];
                    $itemlist[$goods['id']]['goods_price'] = $goods['goods_price'];
                    $itemlist[$goods['id']]['goods_thumb'] = image($goods['goods_thumb']);
                    $itemlist[$goods['id']]['sold'] = $goods['sold'];
                }
            }
            unset($goods_ids, $goods_list, $goods);
        }
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "", true);

        $_G['title'] = $_lang['goods_collection'];
        include template('collection_goods');
    }

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