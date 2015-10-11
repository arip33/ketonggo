<?php
class xsspolice
{
	function getIp() {
		$ipno = $_SERVER['REMOTE_ADDR']; 
		return $ipno;
	}

	function lookData($data) {
		$ip=$this->getIp();
		$data = strtolower($data);
		$br=$_SERVER['HTTP_USER_AGENT'];
		$datenow=date("y-m-d h:m:s");
		if(isset($_SESSION['user'])) {
			$username=$_SESSION['user'];
		}else {
			$username="unknown";
		}
		if (
		strstr($data,"<") OR 
		strstr($data,">") OR 
		strstr($data,"(") OR 
		strstr($data,")") OR
		strstr($data,"..") OR
		strstr($data,"%") OR
		strstr($data,"*") OR
		strstr($data,"+") OR
		strstr($data,"!") OR
		strstr($data,"@")) {
			$dirtystuff = array("\"", "\\", "/", "*", "'", "=", "-
			", "#", ";", "<", ">", "+", "%","(",")","}","{");
			$data = str_replace($dirtystuff, "", $data);
			$data = htmlspecialchars($data);
			$data = strip_tags($data);
			$ip = str_replace($dirtystuff, "", $ip);
			$ip = htmlspecialchars($ip);
			$ip = strip_tags($ip);
			$username = str_replace($dirtystuff, "", $username);
			$username = htmlspecialchars($username);
			$username = strip_tags($username);
			$datenow = str_replace($dirtystuff, "", $datenow);
			$datenow = htmlspecialchars($datenow);
			$datenow = strip_tags($datenow);
			$br = str_replace($dirtystuff, "", $br);
			$br = htmlspecialchars($br);
			$br = strip_tags($br);
			if($this->validateBefore()){
				$sql="INSERT INTO 
				attack (
					attacker_id, 
					attacker_ip, 
					attacker_username, 
					attacker_date, 
					attacker_comname, 
					attacker_browsername) 
				VALUES (
					NULL, 
					'".$ip."', 
					'".$username."', 
					'".$datenow."', 
					'test', 
					'".$br."')";
				Model::Execute($sql);
			}
			return $data;
		}else{
			return $data;
		}
	}
	function validateBefore() {
		$ip=$this->getip();
		$sql="SELECT COUNT(`attacker_id`) FROM `attack` WHERE `attacker_ip`='".$ip."'";
		$count_data=Model::GetOne($sql);
		if ($count_data>=3) {
			return false;
		}
	}
}