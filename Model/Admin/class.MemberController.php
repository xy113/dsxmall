<?php
namespace Model\Admin;
use Data\Member\MemberConnectModel;
use Data\Member\MemberFieldModel;
use Data\Member\MemberGroupModel;
use Data\Member\MemberInfoModel;
use Data\Member\MemberLogModel;
use Data\Member\MemberModel;
use Data\Member\MemberStatModel;
use Data\Member\MemberStatusModel;
use Data\Member\MemberTokenModel;

class MemberController extends BaseController{
	public function index(){
		$this->memberlist();
	}

	/**
	 * 显示会员列表
	 */
	public function memberlist(){
		global $_G, $_lang;
		G('menu', 'memberlist');

		if ($this->checkFormSubmit()){
			$members = $_GET['members'];
			$eventType = trim($_GET['eventType']);
			if ($members && is_array($members)){
			    $model = new MemberModel();
			    if ($eventType == 'delete'){
			        foreach ($members as $uid){
			            $condition = array('uid'=>$uid);
			            $model->where($condition)->delete();
                        (new MemberInfoModel())->where($condition)->delete();
                        (new MemberFieldModel())->where($condition)->delete();
                        (new MemberLogModel())->where($condition)->delete();
                        (new MemberStatModel())->where($condition)->delete();
                        (new MemberStatusModel())->where($condition)->delete();
                        (new MemberConnectModel())->where($condition)->delete();
                        (new MemberTokenModel())->where($condition)->delete();
                    }
                    $this->showAjaxReturn();
                }

                if ($eventType == 'allow'){
			        foreach ($members as $uid){
			            $model->where(array('uid'=>$uid))->data(array('status'=>'1'))->save();
                    }
                    $this->showAjaxReturn();
                }

                if ($eventType == 'forbiden'){
                    foreach ($members as $uid){
                        $model->where(array('uid'=>$uid))->data(array('status'=>'-1'))->save();
                    }
                    $this->showAjaxReturn();
                }

			}else {
				$this->showError('no_select');
			}
		}else {

			$condition = $queryParams = array();

			$uid = htmlspecialchars($_GET['uid']);
			if ($uid) {
			    $condition[] = "m.uid='$uid'";
			    $queryParams['uid'] = $uid;
            }

            $username = htmlspecialchars($_GET['username']);
			if ($username) {
			    $condition[] = "m.username LIKE '%$username%'";
			    $queryParams['username'] = $username;
            }

            $mobile = htmlspecialchars($_GET['mobile']);
			if ($mobile) {
			    $condition[] = "m.`mobile`='$mobile'";
			    $queryParams['mobile'] = $mobile;
            }

            $email = htmlspecialchars($_GET['email']);
			if ($email) {
			    $condition[] = "m.`email`=>'$email'";
			    $queryParams['email'] = $email;
            }

            $reg_time_begin = htmlspecialchars($_GET['reg_time_begin']);
			if ($reg_time_begin) {
			    $condition[] = "s.`regdate`>".strtotime($reg_time_begin);
			    $queryParams['reg_time_begin'] = $reg_time_begin;
            }

            $reg_time_end = htmlspecialchars($_GET['reg_time_end']);
			if ($reg_time_end) {
                $condition[] = "s.`regdate`<".strtotime($reg_time_end);
                $queryParams['reg_time_end'] = $reg_time_end;
            }

            $last_visit_begin = htmlspecialchars($_GET['last_visit_begin']);
			if ($last_visit_begin) {
			    $condition[] = "s.`lastvisit`>".strtotime($last_visit_begin);
			    $queryParams['last_visit_begin'] = $last_visit_begin;
            }

            $last_visit_end = htmlspecialchars($_GET['last_visit_end']);
			if ($last_visit_end) {
                $condition[] = "s.`lastvisit`<".strtotime($last_visit_end);
                $queryParams['last_visit_end'] = $last_visit_end;
            }

            $pagesize = 20;
			$totalnum   = M('member m')->join('member_status s', 's.uid=m.uid')->where($condition)->count();
			$pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
			$memberlist = M('member m')->join('member_status s', 's.uid=m.uid')->field('m.*,s.regdate,s.lastvisit')
                ->where($condition)->order('uid', 'ASC')->page($_G['page'], $pagesize)->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, http_build_query($queryParams), true);

            $grouplist = (new MemberGroupModel())->getCache();

            $_G['title'] = 'memberlist';
			include template('member/member_list');
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
			include template('member/member_form');
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
			include template('member/member_form');
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
        G('menu', 'membergroup');

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
			include template('member/member_group');
		}
	}
}