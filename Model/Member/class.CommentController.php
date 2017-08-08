<?php
namespace Model\Member;
class CommentController extends BaseController{
	public function index(){
		global $_G,$_lang;
		
		include template('comment_list');
	}
}