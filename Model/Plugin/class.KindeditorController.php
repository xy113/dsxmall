<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/13
 * Time: 下午12:07
 */

namespace Model\Plugin;


use Data\Common\AlbumModel;
use Data\Common\MaterialModel;

class KindeditorController extends BaseController
{
    /**
     * KindeditorController constructor.
     */
    function __construct(){
        parent::__construct();
        if ($_GET['uploadtype'] == 'swfupload'){
            $uid = intval($_GET['uid']);
            $token = trim($_GET['token']);
            if (sha1($uid.formhash()) == $token){
                $this->uid = $uid;
            }
        }
        if (!$this->uid){
            echo json_encode(array('error'=>-100, 'message'=>L('login_expired')));
            exit();
        }
    }
    public function upload(){
        global $G,$lang;
        @header('Content-type: application/json; charset=UTF-8');
        if ($_GET['dir'] == 'image'){
            $upload = new \Core\UploadImage('imgFile');
            if ($filedata = $upload->save()){
                $material = array(
                    'uid'=>$this->uid,
                    'albumid'=>0,
                    'name'=>$filedata['name'],
                    'type'=>'image',
                    'path'=>$filedata['image'],
                    'thumb'=>$filedata['thumb'],
                    'width'=>$filedata['width'],
                    'height'=>$filedata['height'],
                    'extension'=>$filedata['type'],
                    'size'=>$filedata['size'],
                    'dateline'=>TIMESTAMP
                );
                (new MaterialModel())->data($material)->add();
                echo json_encode(array('error'=>0,'url'=>image($filedata['image'])));
                exit();
            }else {
                echo json_encode(array('error'=>$upload->errCode,'message'=>$lang['upload_error'][$upload->errCode]));
                exit();
            }
        }else {
            $upload = new \Core\UploadFile('imgFile');
            $upload->savepath = C('ATTACHDIR').'file/';
            if ($filedata = $upload->save()){
                $material = array(
                    'uid'=>$this->uid,
                    'name'=>$filedata['name'],
                    'type'=>'file',
                    'path'=>$filedata['file'],
                    'extension'=>$filedata['type'],
                    'size'=>$filedata['size'],
                    'dateline'=>TIMESTAMP
                );
                (new MaterialModel())->data($material)->add();
                echo json_encode(array('error'=>0,'url'=>material($filedata['file']), 'file'));
                exit();
            }else {
                echo json_encode(array('error'=>$upload->errCode,'message'=>$lang['upload_error'][$upload->errCode]));
                exit();
            }
        }
    }

    public function manager(){
        global $_G, $orderby;
        $orderby = strtolower($_GET['orderby']);
        $condition = array('uid'=>$this->uid);
        if ($_GET['dir'] == 'image'){
            if ($_GET['datatype'] == 'album'){
                $album_list = (new AlbumModel())->where(array('uid'=>$this->uid))->select();
                echo json_encode(array('album_list'=>array_values($album_list)));
                exit();
            }else {
                $file_list = array();
                $albumid = intval($_GET['albumid']);
                if ($albumid) $condition['albumid'] = $albumid;
                $condition['type'] = 'image';
                $photolist = (new MaterialModel())->where($condition)->limit(0, 100)->order('id DESC')->select();
                usort($photolist, "self::cmp");

                foreach ($photolist as $photo){
                    $file_list[] = array(
                        'isimage'=>1,
                        'filetype'=>$photo['extension'],
                        'filename'=>$photo['name'],
                        'filesize'=>formatSize($photo['size']),
                        'imageurl'=>image($photo['path']),
                        'datetime'=>@date('Y-m-d H:i:s', $photo['dateline'])
                    );
                }
                echo json_encode(array(
                    'file_list'=>$file_list,
                    'total_count'=>count($file_list),
                    'total_page'=>10
                ));
                exit();
            }
        }else {
            $file_list = array();
            $condition['type'] = array('<>', 'image');
            $attach_list = (new MaterialModel())->where($condition)->limit(0, 100)->order('id DESC')->select();
            usort($attach_list, "self::cmp");

            foreach ($attach_list as $attach){
                $file_list[] = array(
                    'isimage'=>0,
                    'filetype'=>$attach['type'],
                    'filename'=>$attach['name'],
                    'filesize'=>formatSize($attach['size']),
                    'fileurl'=>material($attach['path'], $attach['type']),
                    'datetime'=>@date('Y-m-d H:i:s', $attach['dateline'])
                );
            }
            echo json_encode(array(
                'file_list'=>$file_list,
                'total_count'=>count($file_list),
                'total_page'=>10
            ));
            exit();
        }
    }

    public static function cmp($a,$b){
        global $orderby;
        if ($orderby == 'size') {
            if ($a['size'] > $b['size']) {
                return 1;
            } else if ($a['size'] < $b['size']) {
                return -1;
            } else {
                return 0;
            }
        } else if ($orderby == 'type') {
            return strcmp($a['type'], $b['type']);
        } else {
            return strcmp($a['name'], $b['name']);
        }
    }
}