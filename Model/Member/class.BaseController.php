<?php
namespace Model\Member;
use Core\Controller;
class BaseController extends Controller{
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->islogin) {
            $this->redirect(U('m=account&c=login&continue='.strval(rawurlencode(curPageURL()))));
        }
    }
}