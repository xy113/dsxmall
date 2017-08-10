<?php
namespace Model\Admin;
class MemberController extends BaseController{
	public function index(){
		$this->memberlist();
	}

	/**
	 * 显示会员列表
	 */
	public function memberlist(){
		global $_G, $_lang;
		if ($this->checkFormSubmit()){
			$uids = $_GET['uid'];
			if ($uids && is_array($uids)){
				$uids = implode(',', $uids);
				$condition = array('uid'=>array('IN', $uids));
				switch ($_GET['option']){
					case 'delete':
						member_delete_data($condition);
						member_delete_info($condition);
						member_delete_status($condition);
						member_delete_stat($condition);
						member_delete_field($condition);
						member_delete_log($condition);
						member_delete_connect($condition);
						member_delete_perm($condition);
						break;

					case 'move':
						$usergrouplist = usergroup_get_list(0);
						include template('member_move');
						exit();
						break;

					case 'normal':
						member_update_data($condition, array('status'=>0));
						break;

					case 'nologin':
						member_update_data($condition, array('status'=>-1));
						break;

					case 'nopost':
						member_update_data($condition, array('status'=>-2));
						break;
					default:;
				}
				$this->showSuccess('update_succeed');
			}else {
				$this->showError('no_select');
			}
		}else {

			$pagesize = 20;
			$condition = array();

			$field   = isset($_GET['field']) ? trim($_GET['field']) : '';
			$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
			if ($field && $keyword){
				switch ($field) {
					case 'uid': $condition['uid'] = $keyword;
					break;

					case 'username': $condition['username'] = array('LIKE', $keyword);
					break;

					case 'mobile' : $condition['mobile'] = array('LIKE', $keyword);
					break;

					case 'email' : $condition['email'] = array('LIKE', $keyword);
					break;
					 default: $condition['username'] = array('LIKE', $keyword);
				}
			}

			$totalnum   = member_get_count($condition);
			$pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$memberlist = member_get_list($condition, $pagesize, ($_G['page'] - 1)*$pagesize, 'uid ASC');
			$grouplist  = member_get_group_list();

			$uids = array_keys($memberlist);
			$uids = !empty($uids) ? implode(',', $uids) : 0;
			$memberstatuslist = $this->t('member_status')->where("uid IN($uids)")->select();
			if ($memberstatuslist) {
				foreach ($memberstatuslist as $status){
					$memberlist[$status['uid']]['regdate'] = @date('Y-m-d H:i', $status['regdate']);
					$memberlist[$status['uid']]['regip'] = $status['regip'];
					$memberlist[$status['uid']]['lastvisit'] = @date('Y-m-d H:i', $status['lastvisit']);
					$memberlist[$status['uid']]['lastvisitip'] = $status['lastvisitip'];
				}
			}
			unset($memberstatuslist, $status);
			$pages = $this->showPages($_G['page'], $pagecount, $totalnum, "field=$field&keyword=$keyword", 1);

            $_G['title'] = 'memberlist';
			include template('member_list');
		}
	}

	/**
	 * 添加用户
	 */
	public function add(){
		global $_G,$_lang;
		if ($this->checkFormSubmit()) {
			$errno = 0;
			$membernew = $_GET['membernew'];
			cookie('membernew',serialize($membernew),600);
			if ($membernew['username'] && $membernew['password']) {
				$returns = member_register($membernew);
				if ($returns['errno']) {
					$this->showError($returns['error']);
				}else {
					$this->showSuccess('member_add_succeed');
				}
			}else {
				$this->showError('invalid_parameter');
			}
		}else {

			$_Grouplist = usergroup_get_list(0);
			$member = unserialize(cookie('membernew'));

            $_G['title'] = 'memberlist';
			include template('member_form');
		}
	}

	/**
	 * 编辑用户
	 */
	public function edit(){
		$uid = intval($_GET['uid']);
		if ($this->checkFormSubmit()) {

			$membernew = $_GET['membernew'];
			if (member_get_num(array('username'=>$membernew['username'])) > 1){
				$this->showError('username_be_occupied');
			}

			if ($membernew['email']) {
				if (member_get_num(array('email'=>$membernew['email'])) > 1){
					$this->showError('email_be_occupied');
				}
			}

			if ($membernew['mobile']) {
				if (member_get_num(array('mobile'=>$membernew['mobile'])) > 1){
					$this->showError('mobile_be_occupied');
				}
			}

			if ($membernew['password']) {
				$membernew['password'] = getPassword($membernew['password']);
			}else {
				unset($membernew['password']);
			}

			member_update_data(array('uid'=>$uid), $membernew);
			$this->showSuccess('update_succeed');
		}else {
			global $_G,$_lang;
			$member = member_get_data(array('uid'=>$uid));
			$_Grouplist  = usergroup_get_list(0);

            $_G['title'] = 'memberlist';
			include template('member_form');
		}
	}

	/**
	 * 移动到分组
	 */
	public function moveto(){
		$uids = trim($_GET['uids']);
		$target = intval($_GET['target']);
		member_update_data(array('uid'=>array('IN', $uids)), array('gid'=>$target));
		$this->showSuccess('update_succeed', U('a=member_list&gid='.$target));
	}

	public function grouplist(){
		global $_G,$_lang;
		if($this->checkFormSubmit()){
			$delete = $_GET['delete'];
			if ($delete && is_array($delete)) {
				$deleteids = implodeids($delete);
				usergroup_delete_data(array('gid'=>array('IN', $deleteids), 'type'=>'custom'));
				$_Group = M('member_group')->where(array('type'=>'custom'))->order('creditslower ASC')->getOne();
				member_update_data(array('gid'=>array('IN', $deleteids)), array('gid'=>$_Group['gid']));
			}

			$_Grouplist = $_GET['grouplist'];
			if ($_Grouplist && is_array($_Grouplist)) {
				foreach ($_Grouplist as $_Gid=>$_Group){
					if ($_Group['title']) {
						$_Group['perm'] = serialize($_Group['perm']);
						if ($_Gid > 0){
							usergroup_update_data(array('gid'=>$_Gid), $_Group);
						}else {
							usergroup_add_data($_Group);
						}
					}
				}
			}

			$this->showSuccess('update_succeed');
		}else{
			$grouplist = array();
			foreach (member_get_group_list() as $_Group){
				$usergrouplist[$_Group['type']][$_Group['gid']] = $_Group;
			}
			include template('member_group');
		}
	}
}