<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:26
 */

namespace Data\Member;


use Core\Model;

class MemberGroupModel extends Model
{
    protected $table = 'member_group';

    /**
     * @return bool|mixed
     */
    public function updateCache(){
        $grouplist = array();
        foreach ($this->select() as $group){
            $grouplist[$group['gid']] = $group;
        }
        return cache('member_groups', $grouplist);
    }

    /**
     * @return bool|mixed
     */
    public function getCache(){
        $grouplist = cache('member_groups');
        if (is_array($grouplist)){
            return $grouplist;
        }else {
            $this->updateCache();
            return $this->getCache();
        }
    }
}