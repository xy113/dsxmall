<?php
namespace Model\Admin;
use Data\Common\SettingModel;

class SettingController extends BaseController{
    /**
     * 保存配置信息
     */
    public function save(){
		if ($this->checkFormSubmit()){
		    $model = new SettingModel();
			$settingnew = $_GET['settingnew'];
			foreach ($settingnew as $skey=>$svalue){
				if(is_array($svalue)) $value = serialize($svalue);
				$model->data(array('skey'=>$skey, 'svalue'=>$svalue))->add(null, false, true);
			}
			$model->updateCache();
			$this->showSuccess('update_succeed');
		}else {
			$this->showError('undefined_action');
		}
	}

    /**
     * @param $name
     * @param $args
     */
    function __call($name, $args){
		global $_G, $_lang;
		$setting = $this->getSettings();

        $_G['title'] = '系统配置';
        $_G['menu'] = 'setting_'.$name;
		include template('setting/setting_'.$name);
	}

    /**
     * 获取系统配置内容
     * @return array
     */
    private function getSettings(){
        $settings = array();
        foreach ((new SettingModel())->select() as $list){
            $val = unserialize($list['svalue']);
            if(is_array($val)){
                $list['svalue'] = $val;
            }
            $settings[$list['skey']] = $list['svalue'];
        }
        return $settings;
    }
}