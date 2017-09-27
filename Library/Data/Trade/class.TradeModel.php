<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:13
 */

namespace Data\Trade;


use Core\Model;

class TradeModel extends Model
{
    protected $table = 'trade';

    /**
     * TradeModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}