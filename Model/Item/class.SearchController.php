<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/9
 * Time: 上午10:39
 */
namespace Model\Item;
use Data\Item\ItemCatlogModel;
use Data\Item\ItemModel;

class SearchController extends BaseController{
    /**
     *
     */
    public function index(){
        $this->itemlist();
    }

    /**
     * 商品搜索结果
     */
    public function itemlist(){
        global $_G,$_lang;

        $condition = 'i.on_sale=1';
        $params = array();
        $catid = intval($_GET['catid']);
        if ($catid) {
            $params['catid'] = $catid;
            $condition.= " AND i.catid='$catid'";
            $catlog = (new ItemCatlogModel())->where(array('catid'=>$catid))->getOne();
        }
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) {
            $params['q'] = $q;
            $condition.= " AND (i.title LIKE '%$q%' OR s.shop_name LIKE '%$q%')";
        }
        $itemModel = new ItemModel();

        $pagesize = 20;
        $db = DB();
        $sql = "SELECT COUNT(*) AS total_count FROM ".$db->table('item')." i LEFT JOIN ".$db->table('shop').
            " s ON s.shop_id=i.shop_id WHERE $condition LIMIT 0, 1";
        $query = $db->query($sql);
        $data = $db->fetch_array($query);
        $totalnum = $data['total_count'];
        $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $offset = ($_G['page'] - 1) * $pagesize;

        $orderby = 'i.sold DESC';
        $sort = $_GET['sort'] ? htmlspecialchars($_GET['sort']) : 'default';
        if ($sort == 'price-asc'){
            $orderby = 'i.price ASC';
        }elseif ($orderby == 'sale-desc'){
            $orderby = 'i.sold DESC';
        }
        $sql = "SELECT i.*,s.shop_name,s.username AS seller_username,s.city,s.county FROM ".$db->table('item')." i LEFT JOIN ".$db->table('shop').
            " s ON s.shop_id=i.shop_id WHERE $condition ORDER  BY $orderby LIMIT $offset,$pagesize";
        $query = $db->query($sql);
        $itemlist = array();
        while ($item = $db->fetch_array($query)){
            $item['url'] = U('m=item&c=item&itemid='.$item['itemid']);
            $itemlist[$item['itemid']] = $item;
        }
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, http_build_query($params), true);
        unset($sql, $query, $data, $item, $condition, $params, $orderby);

        //掌柜热卖
        if ($catid) {
            $hot_sale_list = $itemModel->where("`on_sale`=1 AND catid='$catid'")->limit(0, 9)->order('sold DESC')->select();
        }else {
            $hot_sale_list = $itemModel->where(array('on_sale'=>1))->limit(0, 9)->order('sold DESC')->select();
        }

        $_G['title'] = $_lang['search_result'];
        include template('item_list');
    }
}