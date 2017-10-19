<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/6
 * Time: 下午5:30
 */

namespace Model\Home;


use Core\Download;

class AppController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G, $_lang;

        $platform = '';
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            //$this->redirect("https://itunes.apple.com/us/app/%E7%B2%97%E8%80%95%E5%86%9C%E5%93%81%E9%9B%86%E5%B8%82/id1276972461?l=zh&ls=1&mt=8");
            $platform = 'ios';
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')){
                $platform = 'weixin';
            }else {
                //Download::downFile(DATA_PATH.'apk/lastest.apk');
                $this->redirect('http://cg.liaidi.com/data/apk/lastest.apk');
            }
            //$this->redirect('http://cg.liaidi.com/data/apk/lastest.apk');
            //Download::downFile(DATA_PATH.'apk/lastest.apk');
            //$platform = 'android';
        }else{
            echo '<h3 style="text-align: center;">请用手机扫码打开此链接</h3>';
            exit();
        }

        $this->var['title'] = '下载粗耕APP';
        include template('app');
    }

    public function down_apk(){
        Download::downFile(DATA_PATH.'apk/lastest.apk');
    }
}