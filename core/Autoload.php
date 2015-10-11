<?php
function __autoload($class_name){
	try{
		if(is_file(base_dir."mvc/controller/".$class_name.".php"))
		{
				require_once(base_dir."mvc/controller/".$class_name.".php");
		}
		else if(is_file(base_dir."mvc/model/".$class_name.".php"))
		{
				require_once(base_dir."mvc/model/".$class_name.".php");
		}
		else if(is_file(base_dir."library/".$class_name.".php"))
		{
				require_once(base_dir."library/".$class_name.".php");
		}
		else if(is_file(base_dir."helper/".$class_name.".php"))
		{
				require_once(base_dir."helper/".$class_name.".php");
		}
		else if(is_file(ketonggo."library/".$class_name.".php"))
		{
				require_once(ketonggo."library/".$class_name.".php");
		}
		else if(is_file(ketonggo."helper/".$class_name.".php"))
		{
				require_once(ketonggo."helper/".$class_name.".php");
		}
		else if(is_file(core.$class_name.".php"))
		{
				require_once(core.$class_name.".php");
		}
	}catch(Exception $e){
		var_dump($e->getMessage());
	}
	unset($class_name);
}