<?php
class Session{
	public function __construct(){
		@session_start();
	}

	function Set($keys, $val){
		if(is_string($keys)){
			$_SESSION[SESSION_APP][$keys] = $val;
			return;
		}

		if(is_array($keys)){
			foreach ($keys as $key => $value) {
				# code...
				$_SESSION[SESSION_APP][$key] = $value;
			}
		}
	}

	function Get($key){
		return $_SESSION[SESSION_APP][$key];

	}

	function GetFlash($key){
		$return = $_SESSION[SESSION_APP][$key];
		unset($_SESSION[SESSION_APP][$key]);
		return $return;
	}
}