<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午5:35
 */

namespace Data\Item\Builder;


use Core\Builder;

class ItemCatlogContentBuilder extends Builder
{
    private $data = array(
        'catid'=>'',
        'fid'=>'',
        'name'=>'',
        'identifer'=>'',
        'icon'=>'',
        'displayorder'=>'',
        'level'=>'',
        'enable'=>'',
        'available'=>'',
        'keywords'=>'',
        'description'=>''
    );

    /**
     * @param $value
     */
    public function setCatid($value){
        $this->data['catid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getCatid(){
        return $this->data['catid'];
    }

    /**
     * @param $value
     */
    public function setFid($value){
        $this->data['fid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getFid(){
        return $this->data['fid'];
    }

    /**
     * @param $value
     */
    public function setName($value){
        $this->data['name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getName(){
        return $this->data['name'];
    }

    /**
     * @param $value
     */
    public function setIdentifer($value){
        $this->data['identifer'] = $value;
    }

    /**
     * @return mixed
     */
    public function getIdentifer(){
        return $this->data['identifer'];
    }

    /**
     * @param $value
     */
    public function setIcon($value){
        $this->data['icon'] = $value;
    }

    /**
     * @return mixed
     */
    public function getIcon(){
        return $this->data['icon'];
    }

    /**
     * @param $value
     */
    public function setDisplayorder($value){
        $this->data['displayorder'] = $value;
    }

    /**
     * @return mixed
     */
    public function getDisplayorder(){
        return $this->data['displayorder'];
    }

    /**
     * @param $value
     */
    public function setLevel($value){
        $this->data['level'] = $value;
    }

    /**
     * @return mixed
     */
    public function getLevel(){
        return $this->data['level'];
    }

    /**
     * @param $value
     */
    public function setEnable($value){
        $this->data['enable'] = $value;
    }

    /**
     * @return mixed
     */
    public function getEnable(){
        return $this->data['enable'];
    }

    /**
     * @param $value
     */
    public function setAvailable($value){
        $this->data['available'] = $value;
    }

    /**
     * @return mixed
     */
    public function getAvailable(){
        return $this->data['available'];
    }

    /**
     * @param $value
     */
    public function setKeywords($value){
        $this->data['keywords'] = $value;
    }

    /**
     * @return mixed
     */
    public function getKeywords(){
        return $this->data['keywords'];
    }

    /**
     * @param $value
     */
    public function setDescription($value){
        $this->data['description'] = $value;
    }

    /**
     * @return mixed
     */
    public function getDescription(){
        return $this->data['description'];
    }
}