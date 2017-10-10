<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:47
 */

namespace Data\Common;


use Core\Model;

class SettingModel extends Model
{
    protected $table = 'setting';

    /**
     * @return bool|mixed
     */
    public function updateCache(){
        $settings = array();
        foreach ($this->select() as $set){
            $settings[$set['skey']] = $set['svalue'];
        }
        return cache('settings', $settings);
    }

    /**
     * @return bool|mixed
     */
    public function getCache(){
        $settings = cache('settings');
        if (!is_array($settings)){
            $this->updateCache();
            return $this->getCache();
        }else {
            return $settings;
        }
    }
}