<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/14
 * Time: 上午9:50
 */

namespace Model\Material;


use Data\Common\MaterialModel;

class ImageController extends BaseController
{
    /**
     *
     */
    public function index(){

    }

    /**
     * 弹窗选择
     */
    public function plugin(){
        global $_G,$_lang;

        $model = new MaterialModel();
        $pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 20;
        $condition  = array('uid'=>$this->uid, 'type'=>'image');
        $totalcount = $model->where($condition)->count();
        $pagecount  = $totalcount < $pagesize ? 1 : ceil($totalcount/$pagesize);
        $imagelist  = $model->where($condition)->page($_G['page'], $pagesize)->select();
        $pagination = $this->pagination($_G['page'], $pagecount, $totalcount);

        include template('image_plugin');
    }

    /**
     * 上传图片
     */
    public function upload(){
        global $_lang;
        $upload = new \Core\UploadImage();
        if ($filedata = $upload->save()){
            $material = array(
                'uid'=>$this->uid,
                'albumid'=>intval($_GET['albumid']),
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
            $model = new MaterialModel();
            $id = $model->data($material)->add();
            $data = $model->where(array('id'=>$id))->getOne();
            $data['image'] = $data['path'];
            $data['imageurl'] = image($data['image']);
            $data['thumburl'] = image($data['thumb']);
            $data['formatted_size'] = formatSize($data['size']);
            $data['formatted_time'] = formatTime($data['dateline'], 'Y-m-d H:i:s');
            unset($data['path']);
            $this->showAjaxReturn($data);
        }else {
            $this->showAjaxError($upload->errCode, $_lang['upload_error'][$upload->errCode]);
        }
    }
}