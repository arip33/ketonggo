<?php
class Model{
	public $conn;
	public $table;
	protected $pk;
	protected $arr_no_quote=array();
	public $arrNoquote=array();
	function __construct(){
        if(!class_exists('ADONewConnection')){
           	require_once(ketonggo.'library/adodb5/adodb.inc.php');
	       	require_once(ketonggo.'library/adodb5/adodb-exceptions.inc.php');
        }
        $this->conn = self::getConn();
	}

    protected static function &getConn()
    {
	    static $instance;

	    if (!is_object($instance))
	        $instance = self::createConn();

	    return $instance;
    }

    protected static function &createConn()
    {
        $config = Config::Connection();
	    $conn = ADONewConnection($config['driver']);

	    if(!$conn->Connect($config['host'],$config['username'],$config['password'],$config['database']))
	        die ("<p>Tidak bisa melakukan koneksi dengan databas {$config['database']} </p>");

	    $conn->SetFetchMode(ADODB_FETCH_ASSOC);
	    $conn->debug = $config['debug'];

	    return $conn;
    }

    public static function Execute(){
    	return $this->conn->Execute();
    }

	public function GetOne($sql){
		return $this->conn->GetOne($sql);
	}
	
	public function GetRow($sql){
		return $this->conn->GetRow($sql);
	}
	
	public function GetArray($sql){
		return $this->conn->GetArray($sql);
	}
	
	public function GOne($field="*",$addsql=""){
		$sql = "select {$field} from ".$this->table." {$addsql}";
		return $this->conn->GetOne($sql);
	}

	public function GRow($field="*",$addsql=""){
		$sql = "select {$field} from ".$this->table." {$addsql}";
		return $this->conn->GetRow($sql);
	}

	public function GArray($field="*",$addsql=""){
		$sql = "select {$field} from ".$this->table." {$addsql}";
		return $this->conn->GetArray($sql);
	}

	public function GetByPk($id){
		if(!$id){
			return array();
		}
		$sql = "select * from ".$this->table." where {$this->pk} = '$id'";
		return $this->conn->GetRow($sql);
	}
	
	public function Insert($arr_data=array()){
		$return = false;

        $col = $this->conn->SelectLimit("select * from ".$this->table,1);
        $sql = $this->conn->GetInsertSQL($col, $arr_data);
        
        if($sql){
		    $ret = $this->conn->Execute($sql);
		    if($ret){
		   		$info_nama = 'Insert <b>'.$arr_data['nama'].'</b>  ';
			    
				$return['success']="$info_nama berhasil.";
		    }
		}else{
			$return['success']="Tidak ada yang terupdate.";
		}

		if(!empty($this->pk) && isset($return['success'])){
			$return['data']=$this->conn->GetRow("
				select a.* 
				from ".$this->table." a 
				where ".$this->pk." = (select max(b.".$this->pk.")  from ".$this->table." b)");
		}
		
		return $return;
	}

	public function Update($arr_data=array(),$str_condition=""){
		$return = false;
		
		if(!empty($str_condition))
		{
			$str_condition = " where {$str_condition}";
		}
		
		$col = $this->conn->Execute("select * from ".$this->table." $str_condition ");
		$sql = $this->conn->GetUpdateSQL($col, $arr_data);
		if($sql){
		    $ret = $this->conn->Execute($sql);

		    if($ret){
		   		$info_nama = 'Update <b>'.$arr_data['nama'].'</b>  ';
				$return['success']="$info_nama berhasil.";
		    }

		}else{
			$return['success']="Tidak ada yang terupdate.";
		}

		return $return;
	}

	public function Delete($str_condition=""){
		$return = false;
		// check condition
		if(!empty($str_condition))
		{
			$str_condition = " where {$str_condition}";
		}
		
		// define sql
		$sql = "delete from ".$this->table." {$str_condition}";

	    $ret = $this->conn->Execute($sql);

	    if($ret){
	   		$info_nama = 'Delete <b>'.$arr_data['nama'].'</b>  ';
			$return['success']="$info_nama berhasil.";
	    }

		return $return;
	}

	public function SelectGrid($arr_param=array(), $str_field="*")
	{
		$arr_return = array();
		$arr_params = array(
			'page' => 1,
			'limit' => 50,
			'order' => '',
			'filter' => ''
		);
		foreach($arr_param as $key=>$val){
			$arr_params[$key]=$val;
		}

		$str_condition = "";
		$str_order = "";
		if(!empty($arr_params['filter']))
		{
			$str_condition = "where ".$arr_params['filter'];
		}
		if(!empty($arr_params['order']))
		{
			$str_order = "order by ".$arr_params['order'];
		}

		$arr_return['rows'] = $this->conn->PageExecute("
			select 
			{$str_field} 
			from 
			".$this->table."
			{$str_condition} 
			{$str_order} ",$arr_params['limit'],$arr_params['page']
		)->GetArray();
		
		$arr_return['total'] = static::GetOne("
			select 
			count(*) as total 
			from 
			".$this->table."
			{$str_condition}
		");
		
		return $arr_return;
	}
	

	function GenerateTree($row, $colparent, $colid, $collabel, $valparent=null, &$return=array(), &$i=0, $level=0){
		$level++;
		foreach ($row as $key => $value) {
			# code...
			if($value[$colparent]==$valparent){
				unset($row[$key]);

				$space = '';
				for($k=1; $k<$level; $k++){
					$space .='---';
				}

				$value[$collabel] = $space.$value[$collabel];
				$return[$i]=$value;

				$i++;
				$this->GenerateTree($row, $colparent, $colid, $collabel, $value[$colid], $return, $i, $level);
			}
		}
	}
}
