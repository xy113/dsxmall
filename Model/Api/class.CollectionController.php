<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 下午4:10
 */

namespace Model\Api;


use Data\Common\CollectionModel;
use Data\Item\ItemModel;
use Data\Post\PostItemModel;
use Data\Shop\ShopModel;

class CollectionController extends BaseController
{
    /**
     * 添加到收藏夹
     */
    public function add(){

        $dataid = intval($_GET['dataid']);
        $datatype = trim($_GET['datatype']);
        if ($datatype == 'goods') $datatype = 'item';
        if ($dataid && $datatype) {
            $model = new CollectionModel();
            if ($model->where(array('uid'=>$this->uid, 'dataid'=>$dataid, 'datatype'=>$datatype))->count()){
                $this->showAjaxReturn();
            }else {
                //商品收藏
                if ($datatype == 'item'){
                    $itemModel = new ItemModel();
                    $item = $itemModel->where(array('itemid'=>$dataid))->field('title, thumb')->getOne();
                    $model->data(array(
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
                    $shopModel = new ShopModel();
                    $shop = $shopModel->where(array('shop_id'=>$dataid))->field('shop_name,shop_logo')->getOne();
                    $model->data(array(
                        'uid'=>$this->uid,
                        'dataid'=>$dataid,
                        'datatype'=>$datatype,
                        'title'=>$shop['shop_name'],
                        'image'=>$shop['shop_logo'],
                        'create_time'=>time()
                    ))->add();
                    $shopModel->where(array('shop_id'=>$dataid))->data('`collection_num`=`collection_num`+1')->save();
                }

                //文章收藏
                if ($datatype == 'article'){
                    $article = (new PostItemModel())->where(array('aid'=>$dataid))->field('title,image')->getOne();
                    $model->data(array(
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
            $this->showAjaxError('2001', 'invalid_parameter');
        }
    }
}