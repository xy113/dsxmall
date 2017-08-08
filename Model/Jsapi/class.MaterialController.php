<?php
namespace Model\Jsapi;
class MaterialController extends BaseController{
    /**
     *
     */
    public function index(){
		
	}
	
	/**
	 * 添加素材
	 */
	public function add_material(){
		global $_lang;
		$type = $_GET['type'] ? trim($_GET['type']) : 'image';
		if (!in_array($type, array('image', 'video', 'voice', 'doc', 'file'))) $type = 'file';
		//图片
		if ($type == 'image'){
            $this->uploadimg();
		}else {
			$upload = new \Core\UploadFile('filedata');
			if ($type == 'voice'){
				$upload->allowtypes = array('mp3','wma');
			}elseif ($type == 'video'){
				$upload->allowtypes = array('mp4');
			}else {
				$upload->allowtypes = array();
			}
			$upload->savepath = C('ATTACHDIR').$type.'/';
			@mkdir($upload->savepath, 0777, true);
			if ($filedata = $upload->save()){
				$material = array(
						'uid'=>$this->uid,
						'name'=>$filedata['name'],
						'type'=>$type,
						'path'=>$filedata['file'],
						'extension'=>$filedata['type'],
						'size'=>$filedata['size'],
						'dateline'=>TIMESTAMP
				);
				$data = material_add_data($material, true);
				$data['url'] = material($data['path'], $data['type']);
				$data['formatted_size'] = formatSize($data['size']);
				$data['formatted_time'] = formatTime($data['dateline'], 'Y-m-d H:i:s');
				unset($data['path']);
				$this->showAjaxReturn($data);
			}else {
				$this->showAjaxError($upload->errno, $_lang['upload_error'][$upload->errno]);
			}
		}
	}

    /**
     * 上传图片
     */
    public function uploadimg(){
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
            $data = material_add_data($material, true);
            $data['image'] = $data['path'];
            $data['imageurl'] = image($data['image']);
            $data['thumburl'] = image($data['thumb']);
            $data['formatted_size'] = formatSize($data['size']);
            $data['formatted_time'] = formatTime($data['dateline'], 'Y-m-d H:i:s');
            unset($data['path']);
            $this->showAjaxReturn($data);
        }else {
            $this->showAjaxError($upload->errno, $_lang['upload_error'][$upload->errno]);
        }
    }
	
	/**
	 * 删除素材信息
	 */
	public function del_material(){
		$id = intval($_GET['id']);
		$this->showAjaxReturn(array('uid'=>$this->uid,'id'=>$id));
	}
	
	/**
	 * 获取素材信息
	 */
	public function get_material(){
		$id = intval($_GET['id']);
		$this->showAjaxReturn(material_get_data(array('uid'=>$this->uid, 'id'=>$id)));
	}
	
	/**
	 * 获取素材数量
	 */
	public function get_count(){
		$type = $_GET['type'] ? trim($_GET['type']) : '';
		if ($type){
			$this->showAjaxReturn(array('count'=>material_get_count(array('uid'=>$this->uid,'type'=>$type))));
		}else {
			$count = array(
					'total_count'=>material_get_count(array('uid'=>$this->uid)),
					'image_count'=>material_get_count(array('uid'=>$this->uid, 'type'=>'image')),
					'video_count'=>material_get_count(array('uid'=>$this->uid, 'type'=>'video')),
					'voice_count'=>material_get_count(array('uid'=>$this->uid, 'type'=>'voice')),
					'doc_count'=>material_get_count(array('uid'=>$this->uid, 'type'=>'doc')),
					'file_count'=>material_get_count(array('uid'=>$this->uid, 'type'=>'file'))
			);
			$this->showAjaxReturn($count);
		}
	}
	
	/**
	 * 批量获取素材
	 */
	public function batchget_material(){
		$type = $_GET['type'] ? trim($_GET['type']) : 'image';
		$count = isset($_GET['count']) ? intval($_GET['count']) : 20;
		$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
		
		$condition = array('uid'=>$this->uid);
		if ($type == 'all') {
			$condition['type'] = array('<>','image');
		}else {
			$condition['type'] = $type;
		}
		if ($type == 'image' && $_GET['albumid'] > 0) {
			$condition['albumid'] = intval($_GET['albumid']);
		}
		
		$itemlist = material_get_list($condition, $count, $offset, 'id DESC');
		if ($itemlist) {
			$datalist = array();
			foreach ($itemlist as $item){
				if ($item['type'] == 'image'){
					$item['image'] = $item['path'];
					$item['imageurl'] = image($item['image']);
					$item['thumburl'] = image($item['thumb']);
					unset($item['path']);
				}
				$item['formatted_time'] = formatTime($item['dateline'], 'Y-m-d H:i:s');
				$item['formatted_size'] = formatSize($item['size']);
				$datalist[] = $item;
			}
			$itemlist = $datalist;
		}
		$this->showAjaxReturn($itemlist);
	}
}