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
        $this->copyImg();
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

    private function convertShop(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('shop')." ORDER BY shopid ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            if ($data['uid'] == '1040240' || $data['uid'] == '1040446'){
                continue;
            }
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
            goods_delete_item(array('goods_sn'=>$data['goods_sn']));
            goods_delete_item(array('id'=>$data['id']));
            goods_add_item(array(
                'id'=>$data['id'],
                'uid'=>$data['uid'],
                'shop_id'=>$data['shopid'],
                'catid_1'=>$data['catid'],
                'goods_sn'=>$data['goods_sn'],
                'goods_name'=>$data['goods_name'],
                'goods_price'=>$data['goods_price'],
                'goods_thumb'=>$data['goods_image'],
                'goods_image'=>$data['goods_image'],
                'create_time'=>$data['goods_time'],
                'stock'=>$data['goods_stock'],
                'sold'=>$data['sold'],
                'on_sale'=>1
            ));
        }
        echo 'complete!';
    }

    private function convertGoodsDesc(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('goods_desc')." ORDER BY goods_id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            //print_array($data);
            goods_delete_desc(array('goods_id'=>$data['goods_id']));
            goods_add_desc(array(
                'uid'=>$data['uid'],
                'goods_id'=>$data['goods_id'],
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
            goods_delete_image(array('goods_id'=>$data['dataid']));
            goods_add_image(array(
                'goods_id'=>$data['dataid'],
                'thumb'=>$data['thumb'],
                'image'=>$data['image']
            ));
        }
        echo 'complete!';
    }

    public function copyImg(){
        $db = $this->getDB();

        $sql = "SELECT * FROM ".$db->table('image')." ORDER BY id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            $srcfile = '/www/wwwroot/www.zhangwoo.cn/assets/image/'.$data['image'];
            $dstfile = C('ATTACHDIR').'image/'.$data['image'];
            @mkdir(dirname($dstfile), 0777, true);
            if (is_file($srcfile)){
                copy($srcfile, $dstfile);
            }else {
                echo 'file:'.$srcfile.'不存在<br>';
            }
            $srcfile = '/www/wwwroot/www.zhangwoo.cn/assets/image/'.$data['thumb'];
            $dstfile = C('ATTACHDIR').'image/'.$data['thumb'];
            @mkdir(dirname($dstfile), 0777, true);
            if (is_file($srcfile)) {
                @copy($srcfile, $dstfile);
            }else {
                echo 'file:'.$srcfile.'不存在<br>';
            }
        }


        $sql = "SELECT goods_image FROM ".$db->table('goods_item')." WHERE goods_image<>'' ORDER BY id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            $srcfile = '/www/wwwroot/www.zhangwoo.cn/assets/image/'.$data['goods_image'];
            $dstfile = C('ATTACHDIR').'image/'.$data['goods_image'];
            @mkdir(dirname($dstfile), 0777, true);
            if (is_file($srcfile)){
                @copy($srcfile, $dstfile);
            }else {
                echo 'file:'.$srcfile.'不存在<br>';
            }
        }

        echo 'complete!';
    }

    private function convertTrade(){
        $db = $this->getDB();
        $sql = "SELECT * FROM ".$db->table('trade')." ORDER BY trade_id ASC";
        $query = $db->query($sql);
        while ($data = $db->fetch_array($query)){
            //print_array($data);
            trade_add_data(array(
                'trade_id'=>$data['trade_id'],
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