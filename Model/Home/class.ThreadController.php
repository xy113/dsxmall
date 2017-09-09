<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/6
 * Time: 上午12:41
 */

namespace Model\Home;

static $count = 0;
class ThreadController extends BaseController
{
    /**
     *
     */
    public function index(){
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $thread = new TestThread();
        $thread->start() && $thread->join();
        echo $thread->getCreatorId();
    }

    function fetch(){

    }
}

class TestThread extends \Thread{
    /**
     *
     */
    public function run() {
        echo "Hello World {$this->getThreadId()}\n";
    }
}