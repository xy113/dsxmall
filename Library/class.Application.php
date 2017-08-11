<?php
define('version', '2.0');
defined('ROOT_PATH')      or define('ROOT_PATH',   dirname($_SERVER['SCRIPT_FILENAME']).'/');
defined('LIB_PATH')       or define('LIB_PATH',    __DIR__.'/');
defined('APP_PATH')       or define('MODEL_PATH',  ROOT_PATH.'/Model/');
defined('CONFIG_PATH')    or define('CONFIG_PATH', ROOT_PATH.'Config/');
defined('LANG_PATH')      or define('LANG_PATH',   ROOT_PATH.'Lang/');
defined('DATA_PATH')      or define('DATA_PATH',   ROOT_PATH.'data/');
defined('CACHE_PATH')     or define('CACHE_PATH',  ROOT_PATH.'data/cache/');
defined('TPL_PATH')       or define('TPL_PATH',    ROOT_PATH.'templates/');
defined('DEFAULT_MODEL')  or define('DEFAULT_MODEL', 'home');
defined('DEFAULT_LANG')   or define('DEFAULT_LANG', 'zh_cn');
defined('THEME')  or define('THEME', 'default');

class Application{
	private $var = array();

    /**
     * Application constructor.
     */
    function __construct(){
		spl_autoload_register('Application::autoload');
		$this->timezone_set(8);
		if(version_compare(PHP_VERSION,'5.4.0','<')) {
			@ini_set('magic_quotes_runtime',0);
			define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc() ? true : false);
		}else{
			define('MAGIC_QUOTES_GPC',false);
		}
		
		include LIB_PATH.'functions/function.common.php';
		if(!MAGIC_QUOTES_GPC) {
			$_GET = daddslashes($_GET);
			$_POST = daddslashes($_POST);
		}
		
		if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
			$_GET = array_merge($_GET, $_POST);
		}
		//加载配置文件
		global $_config;
        $_config = array();
		$configlist = array('config','db');
		if (is_array(C('AUTO_LOAD_CONFIG'))) {
			$configlist = array_merge($configlist, C('AUTO_LOAD_CONFIG'));
		}
		if ($configlist) {
			array_unique($configlist);
			foreach ($configlist as $name){
				$confile = CONFIG_PATH.$name.'.php';
				if (is_file($confile)) {
                    $_config = array_merge($_config, include($confile));
				}
			}
		}
		unset($configlist,$confile,$name);
		
		//加载语言包
		global $_lang;
        $_lang = array();
		$langlist = array('common','ui','admin','member', 'weixin','mall');
		if (is_array(C('AUTO_LOAD_LANGS'))){
			$langlist = array_merge($langlist, C('AUTO_LOAD_LANGS'));
		}
		if ($langlist && is_array($langlist)){
			array_unique($langlist);
			foreach ($langlist as $name){
				$langfile = LANG_PATH.DEFAULT_LANG.'/lang.'.$name.'.php';
				if (is_file($langfile)){
                    $_lang = array_merge($_lang,include($langfile));
				}
			}
		}
		unset($langlist, $langfile, $name);
		
		//加载function文件
		$functionlist = array('material', 'member', 'misc', 'shop', 'goods', 'trade', 'post', 'weixin');
		if (is_array(C('AUTO_LOAD_FUNCTIONS'))){
			$functionlist = array_merge($functionlist, C('AUTO_LOAD_FUNCTIONS'));
		}
		if ($functionlist) {
			array_unique($functionlist);
			foreach ($functionlist as $name){
				$funcfile = LIB_PATH.'functions/function.'.$name.'.php';
				if (is_file($funcfile) && $name != 'common'){
					include_once $funcfile;
				}
			}
		}
		unset($functionlist, $funcfile, $name);
		//全局变量
		global $_G;
		$_G = array();
		$this->var = &$_G;
		
		$this->var['m'] = isset($_GET['m']) ? htmlspecialchars($_GET['m']) : DEFAULT_MODEL;
        if(!preg_match('/^[a-zA-Z0-9_]+$/i',$this->var['m'])){
            die('Wrong parameters, m must be a charactor form a-zA-Z0-9!');
        }
		$this->var['c'] = isset($_GET['c']) ? htmlspecialchars($_GET['c']) : 'index';
        if(!preg_match('/^[a-zA-Z0-9_]+$/i',$this->var['c'])){
            die('Wrong parameters, c must be a charactor form a-zA-Z0-9!');
        }
		$this->var['a'] = isset($_GET['a']) ? htmlspecialchars($_GET['a']) : 'index';
        if(!preg_match('/^[a-zA-Z0-9_]+$/i',$this->var['a'])){
            die('Wrong parameters, a must be a charactor form a-zA-Z0-9!');
        }
        $this->var['BASEURL'] = curPageURL();
		$this->var['page'] = isset($_GET['page']) ? max(array(intval($_GET['page']), 1)) : 1;
		$this->var['inajax'] = isset($_GET['inajax']) ? intval($_GET['inajax']) : 0;
		
		define('FORMHASH', formhash());
		define('TIMESTAMP', time());
		define('DATESTAMP', date('Ymd',time()));
		@header("Content-type: text/html; charset=utf-8");
		@header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
		@header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		@header('Cache-Control: no-cache, must-revalidate');
		@header('Pragma: no-cache');
		@header('X-Frame-Options: SAMEORIGIN');
		/*
		@mkdir(ROOT_PATH.'data/cache',0777,true);
		@mkdir(ROOT_PATH.'data/session',0777,true);
		@ini_set('session.save_path', ROOT_PATH.'data/session');
		session_start();
		$this->var['session'] = &$_SESSION;
		*/
		//判断是否移动设备访问
		if(mobilecheck() || $_GET['mobile'] == 'yes'){
			define('IN_MOBILE', true);
		}else {
			define('IN_MOBILE', false);
		}
		
		$this->var['setting'] = cache('settings');
		if (!$this->var['setting']){
			$settinglist = M('setting')->select();
			foreach ($settinglist as $list){
				$svalue = unserialize($list['svalue']);
				$this->var['setting'][$list['skey']] = is_array($svalue) ? $svalue : $list['svalue'];
			}
			cache('settings', $this->var['setting']);
		}
		$this->var['title'] = $this->var['setting']['sitename'];
		$this->var['keywords'] = $this->var['setting']['keywords'];
		$this->var['description'] = $this->var['setting']['description'];
	}

	public function start(){
		$model = $this->var['m'];
		$controller = $this->var['c'];
		$action = $this->var['a'];
		$class = 'Model\\'.ucfirst($model).'\\'.ucfirst($controller).'Controller';
		$app = new $class();
		$app->$action();
	}
	
	/**
	 * 设置时区
	 * @param number $timeoffset
	 */
	public function timezone_set($timeoffset = 0) {
		if(function_exists('date_default_timezone_set')) {
			@date_default_timezone_set('Etc/GMT'.($timeoffset > 0 ? '-' : '+').(abs($timeoffset)));
		}
	}
	
	/**
	 * 自动加载类
	 * @param string $class
	 */
	public static function autoload($class){
		if (false !== strpos($class, '\\')){
			//$namespace  = strstr($class, '\\', true);
            //$namespace  = str_replace('\\','/',$namespace);
            $classname  = substr($class, strrpos($class, '\\')+1);
            $namespace  = str_replace($classname, '', $class);
            $namespace  = str_replace('\\','/',$namespace);
			$name_array = explode('\\', $class);
            if (strtolower($name_array[0]) == 'model'){
                $path = ROOT_PATH.$namespace;
            }else {
                $path = LIB_PATH.$namespace;
            }
            //echo $path.'class.'.$classname.'.php<br>';
			if (is_file($path.'class.'.$classname.'.php')){
				require $path.'class.'.$classname.'.php';
			}else {
				//die('Class "'.$class.'" does not exists.');
                //throw new  \Exception('Class "'.$class.'" does not exists.');
			}
		}else {
			if (is_file(LIB_PATH.'Core/class.'.$class.'.php')){
				require LIB_PATH.'Core/class.'.$class.'.php';
			}else {
				//die('Class "'.$class.'" does not exists.');
                //throw new  \Exception('Class "'.$class.'" does not exists.');
			}
		}
	}
}