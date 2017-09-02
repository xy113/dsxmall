<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/25
 * Time: 下午4:10
 */

namespace Model\Api;


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
            if (collection_get_count(array('uid'=>$this->uid, 'dataid'=>$dataid, 'datatype'=>$datatype))){
                $this->showAjaxReturn();
            }else {
                //商品收藏
                if ($datatype == 'item'){
                    $item = item_get_data(array('id'=>$dataid), 'name, thumb');
                    collection_add_data(array(
                        'uid'=>$this->uid,
                        'dataid'=>$dataid,
                        'datatype'=>$datatype,
                        'title'=>$item['name'],
                        'image'=>$item['thumb'],
                        'create_time'=>time()
                    ));
                    item_update_data(array('id'=>$dataid), '`collection_num`=`collection_num`+1');
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
            $this->showAjaxError('2001', 'invalid_parameter');
        }
    }
}