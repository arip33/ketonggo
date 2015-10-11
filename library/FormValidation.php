<?php
class FormValidation {
	var $rules=array();
	var $param=array();
	var $error=array();
	var $is_online = false;
	function __construct($rules=array()){
		$this->param = $_REQUEST;
		$this->rules = $rules;
	}

	function Run(){
		$param = $this->param;
		foreach($this->rules as $row){
			switch (strtolower($row['rules'])){
				case 'required':
				$this->Required($param[$row['field']],$row['label']);
				break;
				case 'number':
				$this->Number($param[$row['field']],$row['label']);
				break;
				case 'email':
				$this->Email($param[$row['field']],$row['label']);
				break;
				case 'phone':
				$this->Phone($param[$row['field']],$row['label']);
				break;
				case 'url':
				$this->Url($param[$row['field']],$row['label']);
				break;
			}
		}
		return (bool)empty($this->error);
	}
	//type error
	function Required($value,$label){
		$value_trim = trim($value);
		if(is_array($value)){
			foreach($value as $k=>$v){
				$label = $label." ".$k;
				$this->Required($value[$k],$label);
			}
		}else if(empty($value_trim)){
				$this->error[] = "$label harus di isi";
		}
	}

	function Number($value,$label){
		if(is_array($value)){
			foreach($value as $k=>$v){
				$label = $label." ".$k;
				$this->Number($value[$k],$label);
			}
		}else if(!is_numeric($value)){
			$this->error[] = "$label harus di angka";
		}
	}

	function Email($value,$label){
		if(is_array($value)){
			foreach($value as $k=>$v){
				$label = $label." ".$k;
				$this->Email($value[$k],$label);
			}
		}else if(( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value))){
			$this->error[] = "$label harus diisi format email";
		}

		if($this->is_online){
			list($user,$domain) = split("@",$value);
			
			if(!getmxrr($domain,$mxhosts))
			{
				if(!@fsockopen($domain,25,$error,$errorstr,30))
				{
					$this->error[] = "Email tidak ditemukan";
				}
			}
		}
	}

	public function Phone($value,$label){
		if(is_array($value)){
			foreach($value as $k=>$v){
				$label = $label." ".$k;
				$this->Phone($value[$k],$label);
			}
		}else{
			#$ereg = "/^(?:\([0-9]\d{2}\)\ ?|[2-9]\d{2}[- \.]?)[2-9]\d{2}[- \.]?\d{4}[- \.]?(?:x|ext)?\.?\ ?\d{0,5}$/";
			#if(!preg_match($ereg,$value))
			if(!(is_numeric($value) && (strlen($value) >= 8 && strlen($value) <= 12)))
			{
				$this->error[] = "$label harus diisi (08XXXXXXXXXX)";
			}
		}
	}

	public function Url($value,$label){
		if(is_array($value)){
			foreach($value as $k=>$v){
				$label = $label." ".$k;
				$this->Url($value[$k],$label);
			}
		}else{
			$ereg = "((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)";
			if(!eregi($ereg,$value))
			{
				$this->error[] = "$label harus diisi format url (http://www.example.com)";
			}
		}
	}
	//end type error
	function GetErrorArray(){
		return $this->error;
	}
	function GetError(){
		return implode("<br/>",$this->error);
	}
}
