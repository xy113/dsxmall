<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/18
 * Time: 下午3:30
 */

namespace Data\Common\Object;


use Core\DSXObject;

class BlockObject extends DSXObject
{
    protected $fields = array(
        'block_id'=>'',
        'block_name'=>'',
        'block_desc'=>''
    );

    private $block_id;
    private $block_name;
    private $block_desc;

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setFields($fields)
    {
        if (is_array($fields)) {
            foreach ($fields as $name=>$value){
                if (isset($this->fields[$name])) {
                    $this->$name = $value;
                    $this->fields[$name] = $value;
                }
            }
        }
        return $this;
    }

    /**
     * @param mixed $block_id
     * @return BlockObject
     */
    public function setBlockId($block_id)
    {
        $this->block_id = $block_id;
        $this->fields['block_id'] = $block_id;
        return $this;
    }

    /**
     * @param mixed $block_name
     * @return BlockObject
     */
    public function setBlockName($block_name)
    {
        $this->block_name = $block_name;
        $this->fields['block_name'] = $block_name;
        return $this;
    }

    /**
     * @param mixed $block_desc
     * @return BlockObject
     */
    public function setBlockDesc($block_desc)
    {
        $this->block_desc = $block_desc;
        $this->fields['block_desc'] = $block_desc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBlockId()
    {
        return $this->block_id;
    }

    /**
     * @return mixed
     */
    public function getBlockName()
    {
        return $this->block_name;
    }

    /**
     * @return mixed
     */
    public function getBlockDesc()
    {
        return $this->block_desc;
    }
}