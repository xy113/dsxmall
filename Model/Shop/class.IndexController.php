<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午4:52
 */
namespace Model\Shop;
use Data\Shop\ShopModel;

class IndexController extends BaseController{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $pagesize = 20;
        $condition = array('closed'=>'0');
        $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
        if ($q) $condition[] = "`shop_name` LIKE '%$q%'";

        $shopModel = new ShopModel();
        $totalcount = $shopModel->where($condition)->count();
        $pagecount = $totalcount < $pagesize ? 1 : ceil($totalcount/$pagesize);
        $shoplist = $shopModel->where($condition)->page($_G['page'], $pagesize)->select();
        $pagination = $this->pagination($_G['page'], $pagecount, $totalcount, "q=$q", true);

        $_G['title'] = '企业店铺';
        include template('index');
    }
}