<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午11:44
 */

namespace Model\Member;


class CollectionController extends BaseController
{

    /**
     * CollectionController constructor.
     */
    function __construct()
    {
        parent::__construct();
        G('menu', 'collection');
    }

    /**
     * 收藏列表
     */
    public function index(){
        $this->goods();
    }

    /**
     * 商品收藏列表
     */
    public function goods(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()) {

        }else {

            $pagesize = 10;
            $condition = array('uid'=>$this->uid, 'datatype'=>'goods');
            $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
            if ($q) $condition['title'] = array('LIKE', $q);

            $totalnum  = collection_get_count($condition);
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $itemlist = collection_get_list($condition, $pagesize, ($_G['page'] - 1) * $pagesize);
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "", true);

            $_G['title'] = $_lang['goods_collection'];
            include template('collection_goods');
        }
    }

    /**
     *
     */
    public function shop(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()) {

        }else {

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

    /**
     *
     */
    public function article(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()) {

        }else {

            $pagesize = 20;
            $condition = array('uid'=>$this->uid, 'datatype'=>'article');
            $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
            if ($q) $condition['title'] = array('LIKE', $q);

            $totalnum  = collection_get_count($condition);
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $itemlist = collection_get_list($condition, $pagesize, ($_G['page'] - 1) * $pagesize);
            $pages = $this->showPages($_G['page'], $pagecount, $totalnum, "", true);

            $_G['title'] = $_lang['article_collection'];
            include template('collection_article');
        }
    }

    /**
     * 删除收藏
     */
    public function delete(){
        $id = intval($_GET['id']);
        collection_delete_data(array('uid'=>$this->uid, 'id'=>$id));
        $this->showAjaxReturn();
    }

    /**
     * 添加收藏
     */
    public function add(){
        $dataid = intval($_GET['dataid']);
        $datatype = trim($_GET['datatype']);
        if ($dataid && $datatype) {
            if (collection_get_count(array('uid'=>$this->uid, 'dataid'=>$dataid, 'datatype'=>$datatype))){
                $this->showAjaxReturn();
            }else {
                //商品收藏
                if ($datatype == 'goods'){
                    $goods = goods_get_item(array('id'=>$dataid), 'goods_name, goods_thumb');
                    collection_add_data(array(
                        'uid'=>$this->uid,
                        'dataid'=>$dataid,
                        'datatype'=>$datatype,
                        'title'=>$goods['goods_name'],
                        'image'=>$goods['goods_thumb'],
                        'create_time'=>time()
                    ));
                    goods_update_item(array('id'=>$dataid), '`collection_num`=`collection_num`+1');
                }

                //店铺收藏
                if ($datatype == 'shop'){
                    $shop = shop_get_data(array('shop_id'=>$dataid), 'shop_name,shop_logo');
                    collection_add_data(array(
                        'uid'=>$this->uid,
                        'dataid'=>$dataid,
                        'datatype'=>$datatype,
                        'title'=>$shop['shop_name'],
                        'image'=>$shop['shop_logo'],
                        'create_time'=>time()
                    ));
                    shop_update_data(array('shop_id'=>$dataid), '`collection_num`=`collection_num`+1');
                }

                //文章收藏
                if ($datatype == 'article'){
                    $article = post_get_item(array('id'=>$dataid), 'title,image');
                    collection_add_data(array(
                        'uid'=>$this->uid,
                        'dataid'=>$dataid,
                        'datatype'=>$datatype,
                        'title'=>$article['title'],
                        'image'=>$article['image'],
                        'create_time'=>time()
                    ));
                }
                $this->showAjaxReturn();
            }
        }else {
            $this->showAjaxError('FAIL', 'invalid_parameter');
        }
    }
}