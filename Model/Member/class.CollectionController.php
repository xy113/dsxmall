<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午11:44
 */

namespace Model\Member;


use Data\Common\CollectionModel;
use Data\Item\ItemModel;
use Data\Post\PostItemModel;
use Data\Shop\ShopModel;

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
        $this->item();
    }

    /**
     * 商品收藏列表
     */
    public function item(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()) {

        }else {

            $pagesize = 10;
            $condition = array('uid'=>$this->uid, 'datatype'=>'item');
            $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
            if ($q) $condition['title'] = array('LIKE', $q);

            $model = new CollectionModel();
            $totalnum   = $model->where($condition)->count();
            $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $itemlist   = $model->where($condition)->page($_G['page'], $pagesize)->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, "q=$q", true);

            $_G['title'] = $_lang['item_collection'];
            include template('collection_item');
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

            $model = new CollectionModel();
            $totalnum   = $model->where($condition)->count();
            $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $itemlist   = $model->where($condition)->page($_G['page'], $pagesize)->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, "q=$q", true);

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

            $pagesize = 10;
            $condition = array('uid'=>$this->uid, 'datatype'=>'article');
            $q = $_GET['q'] ? htmlspecialchars($_GET['q']) : '';
            if ($q) $condition['title'] = array('LIKE', $q);

            $model = new CollectionModel();
            $totalnum   = $model->where($condition)->count();
            $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $itemlist   = $model->where($condition)->page($_G['page'], $pagesize)->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, "q=$q", true);

            $_G['title'] = $_lang['article_collection'];
            include template('collection_article');
        }
    }

    /**
     * 删除收藏
     */
    public function delete(){
        $id = intval($_GET['id']);
        (new CollectionModel())->where(array('uid'=>$this->uid, 'id'=>$id))->delete();
        $this->showAjaxReturn();
    }

    /**
     * 添加收藏
     */
    public function add(){
        $dataid = intval($_GET['dataid']);
        $datatype = trim($_GET['datatype']);
        if ($dataid && $datatype) {
            $collectionModel = new CollectionModel();
            if ($collectionModel->where(array('uid'=>$this->uid, 'dataid'=>$dataid, 'datatype'=>$datatype))->count()){
                $this->showAjaxReturn();
            }else {
                //商品收藏
                if ($datatype == 'item'){
                    $itemModel = new ItemModel();
                    $item = $itemModel->where(array('itemid'=>$dataid), 'title, thumb')->getOne();
                    $collectionModel->data(array(
                        'uid'=>$this->uid,
                        'dataid'=>$dataid,
                        'datatype'=>$datatype,
                        'title'=>$item['title'],
                        'image'=>$item['thumb'],
                        'create_time'=>time()
                    ))->add();
                    $itemModel->where(array('itemid'=>$dataid))->data('`collection_num`=`collection_num`+1')->save();
                }

                //店铺收藏
                if ($datatype == 'shop'){
                    $shoModel = new ShopModel();
                    $shop = $shoModel->where(array('shop_id'=>$dataid))->field('shop_name,shop_logo')->getOne();
                    $collectionModel->data(array(
                        'uid'=>$this->uid,
                        'dataid'=>$dataid,
                        'datatype'=>$datatype,
                        'title'=>$shop['shop_name'],
                        'image'=>$shop['shop_logo'],
                        'create_time'=>time()
                    ))->add();
                    $shoModel->where(array('shop_id'=>$dataid))->data('`collection_num`=`collection_num`+1')->save();
                }

                //文章收藏
                if ($datatype == 'article'){
                    $article = (new PostItemModel())->where(array('aid'=>$dataid))->field('title,image')->getOne();
                    $collectionModel->data(array(
                        'uid'=>$this->uid,
                        'dataid'=>$dataid,
                        'datatype'=>$datatype,
                        'title'=>$article['title'],
                        'image'=>$article['image'],
                        'create_time'=>time()
                    ))->add();
                }
                $this->showAjaxReturn();
            }
        }else {
            $this->showAjaxError('FAIL', 'invalid_parameter');
        }
    }
}