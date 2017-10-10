<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午5:20
 */

namespace Data\Item;


use Core\Model;
use Data\Item\Builder\ItemCatlogContentBuilder;

class ItemCatlogModel extends Model
{
    /**
     * ItemCatlogController constructor.
     * @param string $name
     */
    function __construct($name = 'item_catlog')
    {
        parent::__construct($name);
    }

    /**
     * @param ItemCatlogContentBuilder $object
     * @return bool|int|\mysqli_result|string
     * @throws \Exception
     */
    public function insertObject(ItemCatlogContentBuilder $object){
        if (!$object->getName()){
            throw new \Exception('Empty name value');
        }
        return $this->add($object->getData(), true);
    }

    /**
     * @return bool|mixed
     */
    public function updateCache(){
        $catloglist = $this->order('displayorder ASC, catid ASC')->select();
        $datalist = array();
        foreach ($catloglist as $catlog){
            $catlog[$catlog['catid']] = $catlog;
        }
        return cache('item_catlog', $catloglist);
    }

    /**
     * @return bool|mixed
     */
    public function getCache(){
        $catloglist = cache('item_catlog');
        if (!is_array($catloglist)){
            $this->updateCache();
            return $this->getCache();
        }else {
            return $catloglist;
        }
    }

    /**
     * @param $catid
     * @return array|null
     */
    public function getCatlog($catid){
        $data = $this->where(array('catid'=>$catid))->getOne();
        return $data ? $data : array();
    }

    /**
     * 获取目录树
     * @return array
     */
    public function getCatlogTree(){
        $catloglist = array();
        foreach ($this->getCache() as $catlog){
            $catloglist[$catlog['fid']][$catlog['catid']] = $catlog;
        }
        return $catloglist;
    }

    /**
     * @param $catid
     * @return array
     */
    public function getAllChildIds($catid, &$childCatids=array()){
        static $catloglist;
        if (!$childCatids) $childCatids = array($catid);
        if (!$catloglist) $catloglist = $this->getCache();
        foreach ($catloglist as $catlog){
            if ($catlog['fid'] == $catid){
                $childCatids[] = $catlog['catid'];
                $this->getAllChildIds($catlog['catid'], $childCatids);
            }
        }
        return $childCatids;
    }

    /**
     * @param $catid
     * @param array $childCatlog
     * @return array
     */
    public function getAllChilds($catid, &$childCatlog=array()){
        static $catloglist;
        if (!$catloglist) $catloglist = $this->getCache();
        if (!$childCatlog) $childCatlog[] = $catloglist[$catid];
        foreach ($catloglist as $catlog){
            if ($catlog['fid'] == $catid){
                $childCatlog[] = $catlog;
                $this->getAllChilds($catlog['catid'], $childCatlog);
            }
        }
        return $childCatlog;
    }

    /**
     * @param $catid
     * @param $parentCatids
     * @return mixed
     */
    public function getParentIds($catid, &$parentCatids=array()){
        static $catloglist;
        if (!$catloglist) $catloglist = $this->getCache();
        if (!$parentCatids) $parentCatids = array($catid);

        $curCatlog = $catloglist[$catid];
        if ($curCatlog['fid']) {
            foreach ($catloglist as $catlog){
                if ($catlog['catid'] == $curCatlog['fid']){
                    $parentCatids[] = $catlog['catid'];
                    $this->getParentIds($catlog['catid'], $parentCatids);
                }
            }
        }
        return $parentCatids;
    }

    /**
     * @param $catid
     * @param array $parents
     * @return array
     */
    public function getParents($catid, &$parents=array()){
        static $catloglist;
        if (!$catloglist) $catloglist = $this->getCache();

        $curCatlog = $catloglist[$catid];
        if (!$parents) $parents = array($curCatlog);
        if ($curCatlog['fid']) {
            foreach ($catloglist as $catlog){
                if ($catlog['catid'] == $curCatlog['fid']){
                    $parents[] = $catlog['catid'];
                    $this->getParents($catlog['catid'], $parents);
                }
            }
        }
        return $parents;
    }
}