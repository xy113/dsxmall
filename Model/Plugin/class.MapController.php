<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/22
 * Time: 上午11:11
 */

namespace Model\Plugin;


class MapController extends BaseController
{
    /**
     *
     */
    public function index(){
        global $_G,$_lang;

        $address = htmlspecialchars($_GET['address']);
        include template('map');
    }
}