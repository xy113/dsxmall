<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/25
 * Time: 下午5:56
 */

namespace Model\Plugin;


class AvatarController extends BaseController
{
    /**
     *
     */
    public function index(){
        $uid  = intval($_GET['uid']);
        $size = trim($_GET['size']);
        $size = in_array($size, array('middel','small')) ? $size : 'big';
        $avatar = $uid.'/'.$uid.'_avatar_'.$size.'.jpg';
        $avatar2 = $uid.'/'.$size.'.png';
        if (is_file(C('AVATARDIR').$avatar2)){
            $avatar = C('AVATARDIR').$avatar2;
        }elseif (is_file(C('AVATARDIR').$avatar)){
            $avatar = C('AVATARDIR').$avatar;
        }else {
            $avatar = ROOT_PATH.'static/images/common/avatar_default.png';
        }
        $size = getimagesize($avatar);
        $fp = fopen($avatar, "rb");
        if ($size && $fp) {
            header("Content-type: {$size['mime']}");
            fpassthru($fp);
        }
        exit();
    }
}