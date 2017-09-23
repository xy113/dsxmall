<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2017 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * $Date: 2017-01-20
 * $Id: class.DB_Mysqli.php
 */
namespace Core;
class DB_Mysqli{
	public $querynum = 0;
	public $tablepre = '';
	public $linkID = null;
	public $config = array();
	
	/**
	 * 构造方法
	 * @param array $config
	 */
	function __construct($config = array()){
		$this->config = array(
            'type'  =>C('DB_TYPE'),
            'host'  =>C('DB_HOST'),
            'port'  =>C('DB_PORT'),
            'pconnect'=>C('DB_TYPE'),
            'charset' =>C('DB_CHARSET'),
            'tablepre'=>C('DB_PREFIX'),
            'db_name'=>C('DB_NAME'),
            'db_user'=>C('DB_USER'),
            'db_pwd' =>C('DB_PWD')
		);
		if (is_array($config)){
			$this->config = array_merge($this->config,$config);
		}
		$this->tablepre = $this->config['tablepre'];
		$this->connect();
	}
	
	/**
	 * 单例
	 * @param array $config
	 * @return \Core\DB_Mysqli
	 */
	public static function getInstance($config = array()){
		static $db;
		if (!is_object($db)) {
			$db = new DB_Mysqli($config);
		}
		return $db;
	}
	
	/**
	 * 链接Mysql数据库
	 */
	public function connect() {
		$this->linkID = mysqli_connect('p:'.$this->config['host'], $this->config['db_user'], $this->config['db_pwd'], $this->config['db_name'], $this->config['port']);
		//$this->linkID = new \mysqli($this->config['host'].':'.$this->config['port'], $this->config['user'], $this->config['pwd'], $this->config['db_name']);
		if (mysqli_connect_errno()){
			$this->halt("Connect to MySQL(".$this->config['db_name'].") failed");
		}
		@mysqli_query($this->linkID, "SET character_set_connection=".$this->config['charset'].", character_set_results=".$this->config['charset'].", character_set_client=binary");
		if($this->version() > '5.0'){
			@mysqli_query($this->linkID, "SET sql_mode=''");
		}
	}
	
	/**
	 * 关闭数据库
	 */
	public function close() {
		return @mysqli_close($this->linkID);
	}
	
	/**
	 * 选择数据库
	 * @param string $db_name
	 */
	public function select_db($db_name){
		if (!@mysqli_select_db($this->linkID, $db_name)){
			$this->halt('Cannot use database('.$this->config['db_name'].')');
		}
	}
	
	/**
	 * 获取mysql版本
	 */
	public function version(){
		return @mysqli_get_client_info();
	}

    /**
     * 获取先前表名称
     * @param string $tableName
     * @return string
     */
	public function table($tableName){
		return $this->tablepre.$tableName;
	}

    /**
     * 执行查询操作
     * @param string $SQL
     * @param integer $mode
     * @return bool|\mysqli_result
     */
	public function query($SQL, $mode = 0){
		if ($mode == 1){
			$query = mysqli_query($this->linkID, $SQL, MYSQLI_USE_RESULT);
		}else {
			$query = mysqli_query($this->linkID, $SQL, MYSQLI_STORE_RESULT);
		}
		
		$this->querynum++;
		if(!$query && DEBUG){
			$this->halt('Query Error: ' . $SQL);
		}
		return $query;
	}
	
	/**
	 * 返回最后插入ID
	 */
	public function insert_id() {
		return mysqli_insert_id($this->linkID);
	}

    /**
     * 返回查询结果数组
     * @param mixed $query
     * @param integer $resulttype
     * @return array|null
     */
	public function fetch_array($query, $resulttype=MYSQLI_ASSOC) {
		return mysqli_fetch_array($query, $resulttype);
	}

    /**
     * 返回行
     * @param mixed $query
     * @return array|null
     */
	public function fetch_row($query){
		return mysqli_fetch_row($query);
	}
	
	/**
	 * 返回影响的数据数目
	 */
	public function affected_rows() {
		return mysqli_affected_rows($this->linkID);
	}

    /**
     * 返回结果数目
     * @param mixed $query
     * @return int
     */
	public function num_rows($query) {
		return mysqli_num_rows($query);
	}
	
	/**
	 * 释放内存
	 * @param mixed $query
	 */
	public function free_result($query) {
		return mysqli_free_result($query);
	}

    /**
     * 返回结果集中的下一个字段
     * @param \mysqli_result|object $query
     * @return string
     */
	public function fetch_field(\mysqli_result $query){
		return mysqli_fetch_field($query);
	}

    /**
     * 显示数据库中的数据表
     * @param string $db_name
     * @return array
     */
	public function show_tables($db_name=''){
		$tables = array();
		$db_name = $db_name ? $db_name : $this->config['db_name'];
		$query = $this->query("SHOW TABLES FROM ".$db_name);
		while ($row = $this->fetch_row($query)){
			$tables[] = $row[0];
		}
		return $tables;
	}

    /**
     * 显示数据库状态
     * @param string $db_name
     * @return array
     */
	public function show_table_status($db_name=''){
		$status = array();
		$db_name = $db_name ? $db_name : $this->config['db_name'];
		$query = $this->query("SHOW TABLE STATUS FROM ".$db_name);
		while ($table = $this->fetch_array($query)){
			$status[] = $table;
		}
		return $status;
	}

    /**
     * 显示表DDL
     * @param string $table
     * @return mixed
     */
	public function show_create_table($table){
		$query = $this->query("SHOW CREATE TABLE ".$this->table($table));
		$row = $this->fetch_row($query);
		return $row[1];
	}

    /**
     * 显示表字段
     * @param string $table
     * @return array
     */
	public function  show_table_fields($table){
		$fields = array();
		$query = $this->query("SHOW FIELDS FROM ".$this->table($table));
		while ($row = $this->fetch_array($query)){
			$fields[] = $row;
		}
		return $fields;
	}
	
	/**
	 * 返回错误信息
	 */
	public function error(){
		return $this->linkID ? mysqli_error($this->linkID) : mysqli_error($this->linkID);
	}
	
	/**
	 * 返回错误代码
	 */
	public function errno(){
		return $this->linkID ? mysqli_errno($this->linkID) : mysqli_errno($this->linkID);
	}
	
	/**
	 * 显示错误信息
	 * @param string $msg
	 */
	public function halt($msg='') {
		$sqlerror = $this->error();
		$sqlerrno = $this->errno();
        if ($msg) echo $msg.'<br>';
        echo "The URL Is:".getSiteURL().'<br>';
        echo "MySQL Server Error:$sqlerror($sqlerrno)";
		exit;
	}

    /**
     * 格式化SQL
     * @param array $array
     * @param string $glue
     * @return array|string
     */
	public function implode_field_value($array, $glue = ',') {
		if (is_array($array)){
			$sql = $comma = '';
			foreach ($array as $k => $v) {
				$sql .= $comma."`$k`='$v'";
				$comma = $glue;
			}
			return $sql;
		}else {
			return $array;
		}
	}
}