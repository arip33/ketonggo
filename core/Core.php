<?php
class Core{
	public function Core(){
	if(is_dir(base_dir.'config/')){
		foreach(glob(base_dir.'config/*.*') as $config){
		     require_once($config);
		}
	}else{
		throw new Exception("Config not found");
	}
	global $router;
	$controller = new Controller;
	new Model();
	
	function &get_instance()
	{
		return Controller::get_instance();
	}

	if(!$router->dir && is_file(base_dir."mvc/controller/".$router->dir_controller.$router->page.".php")){
		include base_dir."mvc/controller/".$router->dir_controller.$router->page.".php";
		$view=new $router->page;
		call_user_func_array(array(&$view,$router->methode),$router->param);
	}else if(!$router->dir){
		$controller->Error404();
	}
	unset($view);
	}
}