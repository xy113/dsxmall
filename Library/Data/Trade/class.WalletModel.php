<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:46
 */

namespace Data\Trade;


use Core\Model;

class WalletModel extends Model
{
    protected $table = 'wallet';

    /**
     * WalletModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}