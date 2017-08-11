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
            $redirect = urlencode(urlencode(curPageURL()));
            $this->redirect(U("m=account&c=login&redirect=$redirect"));
        }
    }
}