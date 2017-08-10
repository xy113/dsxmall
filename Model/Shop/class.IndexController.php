<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午4:52
 */
namespace Model\Shop;
class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $pagesize = 20;
        $condition = array('shop_status'=>'OPEN', 'auth_status'=>'SUCCESS');
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition[] = "shop_name LIKE '%$q%'";

        $totalnum  = shop_get_count($condition);
        $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
        $itemlist = shop_get_list($condition, $pagesize, ($_G['page'] - 1) * $pagesize);
        $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "", true);

        $_G['title'] = '企业店铺';
        include template('index');
    }
}