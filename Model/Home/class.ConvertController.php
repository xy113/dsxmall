<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/3
 * Time: 下午12:11
 */
namespace Model\Home;

class ConvertController extends BaseController{
    /**
     *
     */
    public function index(){

    }

    private function convertMember(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('member')." ORDER BY uid ASC";
        $query = $db->query($sql);
        //$itemlist = array();
        while ($data = $db->fetch_array($query)){
            if ($data['uid'] != '1000000'){
                member_add_data($data);
            }
        }

        $sql = "SELECT * FROM ".$db->table('member_status')." ORDER BY uid ASC";
        $query = $db->query($sql);
        //$itemlist = array();
        while ($data = $db->fetch_array($query)){
            if ($data['uid'] != '1000000'){
                member_add_status($data);
            }
        }

        $sql = "SELECT * FROM ".$db->table('member_info')." ORDER BY uid ASC";
        $query = $db->query($sql);
        //$itemlist = array();
        while ($data = $db->fetch_array($query)){
            if ($data['uid'] != '1000000'){
                member_add_info($data);
            }
        }
        echo 'complete!';
    }

    private function convartCat(){
        $db = $this->getDB();
        $sql = "SELECT catid,fid,`name`,`level`,`enable`,`available` FROM ".$db->table('goods_cat')." ORDER BY catid ASC";
        $query = $db->query($sql);
        //$itemlist = array();
        while ($data = $db->fetch_array($query)){
            goods_delete_cat(array('catid'=>$data['catid']));
            goods_add_cat($data);
        }
        goods_update_cat_cache();
        echo 'complete!';
    }

    /**
     *
     */
    private function convertShop(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('shop')." ORDER BY shopid ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            if ($data['uid'] == '1040240' || $data['uid'] == '1040446'){
                continue;
            }
            $check = shop_get_count("`shop_id`='".$data['shopid']."' OR owner_uid='".$data['uid']."'");
            if ($check){
                continue;
            }else {
                shop_delete_data(array('shop_id'=>$data['shopid']));
                shop_delete_owner(array('owner_uid'=>$data['uid']));
                shop_delete_info(array('shop_id'=>$data['shopid']));
                shop_add_data(array(
                    'shop_id'=>$data['shopid'],
                    'shop_name'=>$data['shopname'],
                    'owner_uid'=>$data['uid'],
                    'owner_username'=>$data['username'],
                    'create_time'=>$data['dateline'],
                    'auth_status'=>'SUCCESS',
                    'shop_status'=>'OPEN',
                    'shop_logo'=>$data['image']
                ));
                shop_add_owner(array(
                    'owner_uid'=>$data['uid'],
                    'owner_name'=>$data['username']
                ));
                shop_add_info(array(
                    'shop_id'=>$data['shopid']
                ));
            }
        }
        echo 'complete!';
    }

    /**
     *
     */
    private function convertGoods(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('goods_item')." ORDER BY id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            //print_array($data);
            if (item_get_count(array('id'=>$data['id']))){
                continue;
            }else {
                item_add_data(array(
                    'id'=>$data['id'],
                    'uid'=>$data['uid'],
                    'shop_id'=>$data['shopid'],
                    'catid_1'=>$data['catid'],
                    'sn'=>$data['goods_sn'],
                    'name'=>$data['goods_name'],
                    'price'=>$data['goods_price'],
                    'thumb'=>$data['goods_image'],
                    'image'=>$data['goods_image'],
                    'create_time'=>$data['goods_time'],
                    'stock'=>$data['goods_stock'],
                    'sold'=>$data['sold'],
                    'on_sale'=>1
                ));
            }

        }
        echo 'complete!';
    }

    private function convertGoodsDesc(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('goods_desc')." ORDER BY goods_id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            //print_array($data);
            //goods_delete_desc(array('goods_id'=>$data['goods_id']));
            item_add_desc(array(
                'uid'=>$data['uid'],
                'itemid'=>$data['goods_id'],
                'content'=>addslashes($data['description'])
            ));
        }
        echo 'complete!';
    }

    private function convertGoodsImg(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('image')." WHERE `datatype`='goods' ORDER BY id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            item_delete_image(array('itemid'=>$data['dataid']));
            item_add_image(array(
                'itemid'=>$data['dataid'],
                'thumb'=>$data['thumb'],
                'image'=>$data['image']
            ));
        }
        echo 'complete!';
    }

    public function copyImg(){
        /*
        $itemlist = item_get_list(0, 0, 0, null,'id,thumb,image');
        //print_array($itemlist);exit();
        foreach ($itemlist as $item){
            //print_array($item);
            if (!$item['thumb']) continue;
            $dstfile = C('ATTACHDIR').'image/'.$item['image'];
            if (!is_file($dstfile)){
                echo 'dist:'.$dstfile.'<br>';
                $srcfile = '/www/wwwroot/www.zhangwoo.cn/assets/image/'.$item['image'];
                echo 'src:'.$srcfile.'<br>';
                @mkdir(dirname($dstfile), 0777, true);
                copy($srcfile, $dstfile);
            }
            $dstfile = C('ATTACHDIR').'image/'.$item['thumb'];
            if (!is_file($dstfile)){
                $srcfile = '/www/wwwroot/www.zhangwoo.cn/assets/image/'.$item['thumb'];
                @mkdir(dirname($dstfile), 0777, true);
                copy($srcfile, $dstfile);
            }
        }
        */
        $itemlist = item_get_image_list(0);
        foreach ($itemlist as $item){
            if (!$item['thumb']) continue;
            $dstfile = C('ATTACHDIR').'image/'.$item['image'];
            if (!is_file($dstfile)){
                echo 'dist:'.$dstfile.'<br>';
                $srcfile = '/www/wwwroot/www.zhangwoo.cn/assets/image/'.$item['image'];
                echo 'src:'.$srcfile.'<br>';
                @mkdir(dirname($dstfile), 0777, true);
                copy($srcfile, $dstfile);
            }
            $dstfile = C('ATTACHDIR').'image/'.$item['thumb'];
            if (!is_file($dstfile)){
                $srcfile = '/www/wwwroot/www.zhangwoo.cn/assets/image/'.$item['thumb'];
                @mkdir(dirname($dstfile), 0777, true);
                copy($srcfile, $dstfile);
            }
        }
//        $db = $this->getDB();
//
//        $sql = "SELECT * FROM ".$db->table('image')." ORDER BY id ASC";
//        $query = $db->query($sql);
//        while ($data = $db->fetch_array($query)){
//            $srcfile = '/www/wwwroot/www.zhangwoo.cn/assets/image/'.$data['image'];
//            $dstfile = C('ATTACHDIR').'image/'.$data['image'];
//            @mkdir(dirname($dstfile), 0777, true);
//            if (is_file($srcfile)){
//                copy($srcfile, $dstfile);
//            }else {
//                echo 'file:'.$srcfile.'不存在<br>';
//            }
//            $srcfile = '/www/wwwroot/www.zhangwoo.cn/assets/image/'.$data['thumb'];
//            $dstfile = C('ATTACHDIR').'image/'.$data['thumb'];
//            @mkdir(dirname($dstfile), 0777, true);
//            if (is_file($srcfile)) {
//                @copy($srcfile, $dstfile);
//            }else {
//                echo 'file:'.$srcfile.'不存在<br>';
//            }
//        }


//        $sql = "SELECT goods_image FROM ".$db->table('goods_item')." WHERE goods_image<>'' ORDER BY id ASC";
//        $query = $db->query($sql);
//        while ($data = $db->fetch_array($query)){
//            $srcfile = '/www/wwwroot/www.zhangwoo.cn/assets/image/'.$data['goods_image'];
//            $dstfile = C('ATTACHDIR').'image/'.$data['goods_image'];
//            @mkdir(dirname($dstfile), 0777, true);
//            if (is_file($srcfile)){
//                @copy($srcfile, $dstfile);
//            }else {
//                echo 'file:'.$srcfile.'不存在<br>';
//            }
//        }

        echo 'complete!';
    }

    private function convertTrade(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('trade')." ORDER BY trade_id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            //print_array($data);
            if (trade_get_count(array('trade_no'=>$data['trade_no']))){
                continue;
            }else {
                trade_add_data(array(
                    //'trade_id'=>$data['trade_id'],
                    'uid'=>$data['uid'],
                    'payee_uid'=>$data['rec_uid'],
                    'pay_type'=>'wxpay',
                    'trade_no'=>$data['trade_no'],
                    'trade_name'=>$data['trade_name'],
                    'trade_desc'=>$data['trade_desc'],
                    'trade_fee'=>$data['trade_fee'],
                    'trade_type'=>'shopping',
                    'trade_status'=>$data['trade_status'],
                    'trade_time'=>$data['trade_time']
                ));
            }

        }

        echo 'complete!';
    }

    public function convertPostCat(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('post_cat')." ORDER BY catid ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            post_delete_category(array('catid'=>$data['catid']));
            post_add_category($data);
        }

        echo 'complete!';
    }

    private function convertPostTitle(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('post_title')." ORDER BY id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            post_delete_item(array('id'=>$data['id']));
            post_add_item($data);
        }

        echo 'complete!';
    }

    private function convertPostContent(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('post_content')." ORDER BY aid ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            post_delete_content(array('aid'=>$data['aid']));
            post_add_content(array(
                'aid'=>$data['aid'],
                'uid'=>$data['uid'],
                'pageorder'=>1,
                'content'=>addslashes($data['content'])
            ));
        }

        echo 'complete!';
    }

    private function convertOrder(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('order_item')." ORDER BY order_id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            if (order_get_count(array('order_no'=>$data['order_no']))){
                continue;
            }else{
                order_add_data(array(
                    'order_id'=>$data['order_id'],
                    'uid'=>$data['uid'],
                    'order_no'=>$data['order_no'],
                    'shop_id'=>$data['shopid'],
                    'shop_name'=>$data['shopname'],
                    'order_fee'=>$data['order_fee'],
                    'create_time'=>$data['order_time'],
                    'address'=>$data['receipt_address']
                ));
            }

        }

        echo 'complete!';
    }

    private function convertOrderItem(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('order_goods')." ORDER BY order_goods_id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            $order = order_get_data(array('order_no'=>$data['order_no']), 'order_id');
            order_add_item(array(
                'order_id'=>$order['order_id'],
                'uid'=>$data['uid'],
                'itemid'=>$data['goods_id'],
                'name'=>$data['goods_name'],
                'price'=>$data['goods_price'],
                'market_price'=>$data['goods_price'],
                'thumb'=>$data['goods_image'],
                'image'=>$data['goods_image'],
                'quantity'=>$data['goods_number']
            ));
        }

        echo 'complete!';
    }

    /**
     * @return \Core\DB_Mysqli
     */
    private function getDB(){
        return new \Core\DB_Mysqli(array(
            'db_name'=>'db_npjs',
            'db_user'=>'db_npjs',
            'db_pwd' =>'bkTzT0njDeRDseRJ'
        ));
    }
}