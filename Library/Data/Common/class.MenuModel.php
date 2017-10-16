<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:49
 */

namespace Data\Common;


use Core\Model;

class MenuModel extends Model
{
    protected $table = 'menu';

    /**
     * MenuModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }

    /**
     *
     */
    public function setCache(){
        $menulist = array();
        foreach ($this->where(array('type'=>'item'))->order('displayorder ASC,id ASC')->select() as $menu){
            $menulist[$menu['menuid']][$menu['id']] = $menu;
        }

        foreach ($menulist as $menuid=>$items){
            cache('menu_'.$menuid, $items);
        }
    }

    /**
     * @param $menuid
     * @return bool|mixed
     */
    public function getCache($menuid){
        $menulist = cache('menu_'.$menuid);
        if (is_array($menulist)) {
            return $menulist;
        }else {
            $this->setCache();
            return $this->getCache($menuid);
        }
    }
}