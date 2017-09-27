<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/27
 * Time: 下午9:53
 */

namespace Data\Common;


use Core\Model;

class FeedbackModel extends Model
{
    protected $table = 'feedback';

    /**
     * FeedbackModel constructor.
     * @param string $name
     */
    function __construct($name = '')
    {
        parent::__construct($name);
    }
}