<?php
namespace Model\Admin;
class SettingController extends BaseController{
    /**
     * 保存配置信息
     */
    public function save(){
		if ($this->checkFormSubmit()){
			$settingnew = $_GET['settingnew'];
			foreach ($settingnew as $key=>$value){
				if(is_array($value)) $value = serialize($value);
				M('setting')->insert(array('skey'=>$key, 'svalue'=>$value), 0, true);
			}
			$this->updatecache();
			$this->showSuccess('update_succeed');
		}else {
			$this->showError('undefined_action');
		}
	}

    /**
     * 更新配置缓存
     */
    public function updatecache(){
		$settings = $this->getSettings();
		cache('settings', $settings);
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
        $settinglist = M('setting')->field('skey,svalue')->select();
        foreach ($settinglist as $list){
            $val = unserialize($list['svalue']);
            if(is_array($val)){
                $list['svalue'] = $val;
            }
            $settings[$list['skey']] = $list['svalue'];
        }
        return $settings;
    }
}