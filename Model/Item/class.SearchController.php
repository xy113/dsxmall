<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/9
 * Time: 上午10:39
 */
namespace Model\Item;
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

        $pagesize = 20;
        $condition = 'i.on_sale=1';
        $params = array();
        $catid = intval($_GET['catid']);
        if ($catid) {
            $params['catid'] = $catid;
            $condition.= " AND (i.catid_1='$catid' OR i.catid_2='$catid' OR i.catid_3='$catid')";
            $item_cat = item_get_cat(array('catid'=>$catid));
        }
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) {
            $params['q'] = $q;
            $condition.= " AND (i.goods_name LIKE '%$q%' OR s.shop_name LIKE '%$q%')";
        }
        $db = DB();
        $sql = "SELECT COUNT(*) AS total_count FROM ".$db->table('item')." i LEFT JOIN ".$db->table('shop').
            " s ON s.shop_id=i.shop_id WHERE $condition LIMIT 0, 1";
        $query = $db->query($sql);
        $data = $db->fetch_array($query);
        $totalnum = $data['total_count'];
        $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $offset = ($_G['page'] - 1) * $pagesize;

        $sql = "SELECT i.*,s.shop_name,s.owner_username AS seller_username,s.city,s.county FROM ".$db->table('item')." i LEFT JOIN ".$db->table('shop').
            " s ON s.shop_id=i.shop_id WHERE $condition ORDER  BY i.sold DESC LIMIT $offset,$pagesize";
        $query = $db->query($sql);
        $itemlist = array();
        while ($item = $db->fetch_array($query)){
            $item['url'] = U('m=item&c=item&id='.$item['id']);
            $itemlist[$item['id']] = $item;
        }
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, http_build_query($params), true);
        unset($sql, $query, $data, $item, $condition, $params);

        //掌柜热卖
        if ($catid) {
            $hot_sale_list = item_get_list("`on_sale`=1 AND (catid_1='$catid' OR catid_2='$catid' OR catid_3='$catid')", 9, 0, 'sold DESC');
        }else {
            $hot_sale_list = item_get_list(array('on_sale'=>1), 9, 0, 'sold DESC');
        }

        $_G['title'] = $_lang['search_result'];
        include template('item_list');
    }
}