<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:37
 */

namespace Data\Post;


use Core\Model;

class PostCatlogModel extends Model
{
    protected $table = 'post_catlog';

    /**
     * PostCatlogController constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
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
     * @return bool|mixed
     */
    public function updateCache(){
        $catloglist = array();
        foreach ($this->where(array('available'=>1))->order('displayorder ASC,catid ASC')->select() as $catlog){
            $catloglist[$catlog['catid']] = $catlog;
        }
        return cache('post_catlog', $catloglist);
    }

    /**
     * @return bool|mixed
     */
    public function getCache(){
        $catloglist = cache('post_catlog');
        if (!is_array($catloglist)) {
            $this->updateCache();
            return $this->getCache();
        }else {
            return $catloglist;
        }
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