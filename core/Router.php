<?php
class Router{
	var $page="Home";
	var $methode="_actionIndex";
	var $mode = "index";
	var $param=array();
	var $dir=false;
	var $dir_controller="";
	var $uri="";
	
	function Router(){
		$index=trim(str_replace("index.php","",$_SERVER['SCRIPT_NAME']),'/');
		$route=trim(str_replace(array("index.php", $index),"",$_SERVER['REQUEST_URI']),"/");
		$route=parse_url($route, PHP_URL_PATH);
		$uri=explode("/",$route);
		$base=str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']);
		$dir=$base.$uri[0];
		if(is_dir($dir) and $base!=$dir)
		{
			$this->dir=$dir;
			return;
		}
		$i=1;
		foreach($uri as $k=>$v){
		    $val=$this->NameObject($v);
			if(is_file(base_dir."mvc/controller/".$this->dir_controller.$val.".php")){
				$this->page=$val;
				$this->uri=$this->dir_controller.$v;
				if(isset($uri[$i]))
				{
		    		$this->methode="_action".$this->NameObject($uri[$i]);
		    		$this->mode = $uri[$i];
					if(array_slice($uri,($i+1)))
					{
						$this->param=array_slice($uri,($i+1));
					}
				}
				unset($dir);
				unset($index);
				unset($route);
				unset($uri);
				return;
			}
			$i++;
			$this->dir_controller .= $v."/";
		}
	}

	function NameObject($string){
		return str_replace(array("'",'"',' '),'',ucwords(strtolower(str_replace('_',' ',$string))));
	}

}
