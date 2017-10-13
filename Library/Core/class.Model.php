<?php
/**
 *
 */
namespace Core;
class Model{
	private $db;
	private $tableName;
    private $sql = '';
	private $data = array();
	private $option = array(
			'field'=>'*',
			'where'=>'',
			'order'=>'',
			'group'=>'',
			'having'=>'',
			'limit'=>'',
			'page'=>'',
			'join'=>'',
			'union'=>''
	);

    protected $table;

    /**
     * Model constructor.
     * @param string $name
     */
    function __construct($name = ''){
		$this->db = DB_Mysqli::getInstance();
		$this->tableName = $name ? $this->db->table($name) : $this->db->table($this->table);
	}

    /**
     * @param string $args
     * @return $this
     */
    public function field($args = '*'){
		if (is_array($args)){
			$this->option['field'] = implode($args, ',');
		}else {
			$this->option['field'] = $args;
		}
		!$this->option['field'] && $this->option['feild'] = '*';
		return $this;
	}

    /**
     * @param $args
     * @param string $glue
     * @return $this
     */
    public function where($args, $glue = 'AND'){
		$wherestr = '';
		$glue = strtoupper($glue);
		$glue = in_array($glue, array('AND','OR','XOR')) ? ' '.$glue.' ' : ' AND ';
		if (is_string($args)){
			$wherestr = $args;
		}elseif (is_array($args) && !empty($args)){
			foreach ($args as $key=>$value){
				if (is_numeric($key)){
					$wherestr.= $glue.$value;
				}else {
					$key = '`'.$key.'`';
					if (is_array($value)){
						$arr = $value;
						$separate = $value[0];
						if (!in_array($separate, array('=','>','<','>=','<=','<>','LIKE','LEFTLIKE','RIGHTLIKE','IN','NOT IN'))){
							$separate = '=';
						}
						if (strtoupper($separate) == 'LIKE'){
							$wherestr.= $glue.$key." LIKE '%".$value[1]."%'";
						}elseif (strtoupper($separate) == 'LEFTLIKE'){
							$wherestr.= $glue.$key." LIKE '".$value[1]."%'";
						}elseif (strtoupper($separate) == 'RIGHTLIKE'){
							$wherestr.= $glue.$key." LIKE '%".$value[1]."'";
						}elseif (strtoupper($separate) == 'IN' || strtoupper($separate) == 'NOT IN'){
							$wherestr.= $glue.$key.' '.strtoupper($separate)."($value[1])";
						}else {
							$value[1] = "'$value[1]'";
							$wherestr.= $glue.$key.$separate.$value[1];
						}
					}else {
						$wherestr.= $glue.$key."='".$value."'";
					}
				}
			}
			$wherestr = $wherestr? substr($wherestr, strlen($glue)) : '';
		}
		$this->option['where'] = $wherestr ? "WHERE ".$wherestr : "";
		return $this;
	}

    /**
     * @param $field
     * @param string $sort
     * @return $this
     */
    public function order($field, $sort = 'ASC'){
		if (func_num_args() == 1){
			if (is_string($field)){
				$this->option['order'] = $field;
			}elseif (is_array($field)){
				$order = array();
				foreach ($field as $k=>$v){
					if (is_numeric($k)){
						if (is_string($v)) {
							array_push($order, $v);
						}else {
							$v[1] = strtoupper($v[1]);
							!in_array($v[1], array('ASC','DESC')) && $v[1] = 'ASC';
							array_push($order, "$v[0] $v[1]");
						}
					}else {
						array_push($order, "$k $v");
					}
				}
				$this->option['order'] = implode(',', $order);
			}else {
				$this->option['order'] = '';
			}

		}else {
			$sort = strtoupper($sort);
			$sort = in_array($sort, array('ASC','DESC')) ? $sort : 'ASC';
			$this->option['order'] = is_string($field) ? " $field $sort" : '';
		}
		$this->option['order'] = $this->option['order'] ? "ORDER BY ".$this->option['order'] : "";
		return $this;
	}

    /**
     * @param $start
     * @param int $num
     * @return $this
     */
    public function limit($start, $num=0){
		if (func_num_args() == 1){
			if (is_string($start)){
				$this->option['limit'] = $start;
			}elseif (is_array($start)){
				$this->option['limit'] = "$start[0],$start[1]";
			}elseif (is_numeric($start)){
				$this->option['limit'] = "0,$start";
			}else {
				$this->option['limit'] = '';
			}
		}else {
			$num   = abs($num);
			$start = abs($start);
			if ($num > 0) {
				$this->option['limit'] = "$start,$num";
			}else {
				$this->option['limit'] = $start;
			}
		}

		$this->option['limit'] = $this->option['limit'] ? "LIMIT ".$this->option['limit'] : '';
		return $this;
	}

    /**
     * @param $page
     * @param int $rows
     * @return $this
     */
    public function page($page, $rows=10){
		$page = intval($page);
		$rows = intval($rows);
		$page = max(array($page,1));
		$rows = abs($rows);
		$start = ($page-1)*$rows;
		$this->limit($start,$rows);
		return $this;
	}

    /**
     * @param $field
     * @return $this
     */
    public function group($field){
		$this->option['group'] = $field ? 'GROUP BY '.$field : '';
		return $this;
	}

    /**
     * @param $having
     * @return $this
     */
    public function having($having){
		$this->option['having'] = $having ? "HAVING ".$having : "";
		return $this;
	}

    /**
     * join 操作
     * @param string $table
     * @param string $type
     * @param string $on
     * @return $this
     */
	public function join($table, $on='', $type='LEFT'){
		$joinstr = '';
		if (func_num_args() == 1){
			$jointype = 'LEFT JOIN';
		}else {
			$type = strtoupper($type);
			$type = in_array($type, array('LEFT','RIGHT','INNER')) ? $type :'';
			$jointype = $type ? $type.' JOIN' : 'JOIN';
		}

		if (is_array($table)){
			foreach ($table as $key=>$value){
				if (!is_numeric($key)) {
					$joinstr = ' '.$jointype.' '.$this->db->table($key). ' AS '.$value;
				}
			}
		}else {
			$joinstr.= ' '.$jointype.' '.$this->db->table($table);
		}

		$joinstr.= $on ? ' ON '.$on : '';
		$this->option['join'].= $joinstr;
		return $this;
	}

    /**
     * @param $table
     * @param bool $all
     * @return $this
     */
    public function union($table, $all=FALSE){
		$separate = $all ? 'UNION ALL ' : 'UNION ';
		$this->option['union'].= $separate."SELECT ".$this->option['field']." FROM ".$this->db->table($table);
		return $this;
	}

    /**
     * 返回DDL语句
     * @return string
     */
    public function getSQL(){
		return $this->sql;
	}

    /**
     * 设置DDL语句
     * @param string $type
     */
    private function setSQL($type='select'){
		if (!is_string($type)) {
			$type = 'select';
		}

		if ($type == 'select') {
			$this->option['field'] = $this->option['field'] ? $this->option['field'] : '*';
			$SQL = "SELECT ".$this->option['field']." FROM ".$this->tableName;
			$SQL.= $this->option['join']   ? ' '.$this->option['join']   : '';
			$SQL.= $this->option['union']  ? ' '.$this->option['union']  : '';
			$SQL.= $this->option['where']  ? ' '.$this->option['where']  : '';
			$SQL.= $this->option['group']  ? ' '.$this->option['group']  : '';
			$SQL.= $this->option['having'] ? ' '.$this->option['having'] : '';
			$SQL.= $this->option['order']  ? ' '.$this->option['order']  : '';
			$SQL.= $this->option['limit']  ? ' '.$this->option['limit']  : '';
			$this->sql = $SQL;
		}else {
			$this->sql = $type;
		}
	}

    /**
     * 返回结果列表
     * @return array
     */
    public function select() {
        $result = array();
		$this->setSQL('select');
		$query = $this->db->query($this->sql);
		while ($data = $this->db->fetch_array($query)){
			$result[] = $data;
		}
        $this->option = array();
		return $result;
	}

    /**
     * 返回一条记录
     * @return array|null
     */
    public function getOne(){
		!$this->option['limit'] && $this->option['limit'] = " LIMIT 0,1";
		$this->setSQL('select');
		$query  = $this->db->query($this->sql,'U_B');
		$result = $this->db->fetch_array($query, MYSQL_ASSOC);
        $this->option = array();
		return $result ? $result : array();
	}

    /**
     * @return array
     */
    public function getAll(){
        return $this->select();
    }

    /**
     * 返回记录数
     * @param string $field
     * @return mixed
     */
    public function count($field='*'){
		!$field && $field = '*';
		$this->option['field'] = "COUNT($field) AS num";
		$row = $this->getOne();
        $this->option = array();
		return $row["num"];
	}

    /**
     * @param null $data
     * @return $this
     */
    public function data($data = null){
		if (!is_null($data)) $this->data = $data;
		return $this;
	}

    /**
     * 插入一条记录
     * @param null $data
     * @param bool $return_insert_id
     * @param bool $replace
     * @return bool|int|\mysqli_result|string
     */
    public function add($data=null, $return_insert_id=true, $replace=false){
		return $this->insert($data, $return_insert_id, $replace);
	}

    /**
     * 插入一条记录
     * @param null $data
     * @param bool $return_insert_id
     * @param bool $replace
     * @return bool|int|\mysqli_result|string
     */
    public function insert($data=null, $return_insert_id=false, $replace=false){
		$this->data = $data ? $data : $this->data;
		if ($this->data) {
			$sql = $this->db->implode_field_value($this->data);
			$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
			$return = $this->db->query("$cmd ".$this->tableName." SET $sql");
			return $return_insert_id ? $this->db->insert_id() : $return;
		}else {
			return false;
		}
	}

    /**
     * 插入一组记录
     * @param $array
     * @param bool $return_insert_id
     * @param bool $replace
     * @return array|bool
     */
    public function insertAll($array, $return_insert_id=false, $replace=false){
		if(!empty($array) && is_array($array)){
			$ids = array();
			foreach ($array as $data){
				$ids[] = $this->insert($data,$return_insert_id,$replace);
			}
			return $return_insert_id ? $ids : true;
		}else {
			return false;
		}
	}

    /**
     * 删除记录
     * @return bool|int
     */
    public function delete(){
		$res = $this->db->query("DELETE FROM ".$this->tableName." ".$this->option['where']);
		return $res ? $this->db->affected_rows() : false;
	}

    /**
     * 更新记录
     * @param $data
     * @param bool $unbuffered
     * @param bool $low_priority
     * @return bool|int
     */
    public function save($data=null, $unbuffered = false, $low_priority = false){
		return $this->update($data, $unbuffered, $low_priority);
	}

    /**
     * 更新记录
     * @param null $data
     * @param bool $unbuffered
     * @param bool $low_priority
     * @return bool|int
     */
    public function update($data=null, $unbuffered = false, $low_priority = false) {
		if (!is_null($data)) $this->data = $data;
		if ($this->data) {
			$sql = $this->db->implode_field_value($this->data);
			$cmd = "UPDATE ".($low_priority ? 'LOW_PRIORITY' : '');
			$res = $this->db->query("$cmd {$this->tableName} SET $sql ".$this->option['where'],$unbuffered ? 'UNBUFFERED' : '');
			$this->option = array();
			return $res ? $this->db->affected_rows() : false;
		}else  {
			return false;
		}
	}

    /**
     * @param $array
     * @param bool $unbuffered
     * @param bool $low_priority
     * @return bool|int
     */
    public function updateAll($array, $unbuffered = false, $low_priority = false){
		$affect_rows = 0;
		foreach ($array as $data){
			$affect_rows+= $this->update($data,$unbuffered,$low_priority);
		}
		return $affect_rows;
	}

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
		$this->$name = $value;
	}

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name) {
		return $this->$name;
	}

    /**
     * @param $name
     * @param $args
     * @throws \Exception
     */
    public function __call($name, $args){
		throw new  \Exception('Class "'.get_class($this).'" does not have a method named "'.$name.'".');
	}
}