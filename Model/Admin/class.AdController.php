<?php
namespace Model\Admin;
use Data\Common\AdModel;

class AdController extends BaseController{
    /**
     * AdController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $_GET['menu'] = 'ad';
    }

    public function index(){
		$this->itemlist();
	}

    /**
     * 广告列表
     */
    public function itemlist(){
        global $_G,$_lang;

        $model = new AdModel();
		if ($this->checkFormSubmit()){
			$ads = $_GET['ads'];
			$eventType = trim($_GET['eventType']);
			if ($ads) {
			    if ($eventType === 'delete'){
                    foreach ($ads as $id){
                        $model->where(array('id'=>$id))->delete();
                    }
                }

                if ($eventType === 'enable'){
                    foreach ($ads as $id){
                        $model->where(array('id'=>$id))->data(array('available'=>1))->save();
                    }
                }

                if ($eventType === 'disable'){
                    foreach ($ads as $id){
                        $model->where(array('id'=>$id))->data(array('available'=>0))->save();
                    }
                }
                $this->showAjaxReturn();
            }
			if (!empty($ids) && is_array($ids)){
				$ids = implodeids($ids);
				switch ($_GET['option']) {
					case 'enable':
						ad_update_data("id IN($ids)", array('status'=>0));
						break;
					case 'disable':
						ad_update_data("id IN($ids)", array('status'=>-1));
						break;
					case 'unaudit':
						ad_update_data("id IN($ids)", array('status'=>-11));
						break;
					default:ad_delete_data("id IN($ids)");
				}
				$this->showSuccess('update_succeed');
			}else {
				$this->showError('no_select');
			}
		}else {

			$pagesize  = 30;
			$totalnum  = $model->count();
			$pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$adlist = $model->page($_G['page'], $pagesize)->select();
			$pagination = $this->pagination($_G['page'], $pagecount, $totalnum, null, true);
			include template('common/ad_list');
		}
	}

    /**
     * 添加广告
     */
    public function add(){
        global $_G,$_lang;

		if ($this->checkFormSubmit()){
			$adnew  = $_GET['adnew'];
			$addata = $_GET['addata'];
			if ($adnew['title']) {
				$adnew['data'] = serialize($addata[$adnew['type']]);
                (new AdModel())->data($adnew)->save();
				$this->showSuccess('save_succeed');
			}else {
				$this->showError('undefined_action');
			}
		}else {

			include template('common/ad_form');
		}
	}

    /**
     * 编辑广告
     */
    public function edit(){
        global $_G,$_lang;
		$id = intval($_GET['id']);

		$model = new AdModel();
		if ($this->checkFormSubmit()){
			$adnew  = $_GET['adnew'];
			$addata = $_GET['addata'];
			if ($adnew['title']) {
                $adnew['data'] = serialize($addata[$adnew['type']]);
				$model->where(array('id'=>$id))->data($adnew)->save();
				$this->showSuccess('update_succeed');
			}else {
				$this->showError('undefined_action');
			}	
		}else {

			$ad = $model->where(array('id'=>$id))->getOne();
			$addata[$ad['type']] = unserialize($ad['data']);
			include template('common/ad_form');
		}
	}
}