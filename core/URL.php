<?php class URL{
	public static $_base;
	public static $_uri;
	public static $_full_uri;
	public static $_host;
	public static $_script_name;
	private function URL()
	{
	}
	public static function Uri()
	{
		return self::$_uri=str_replace(self::ScriptName(),"",$_SERVER['REQUEST_URI']);
	}
	public static function FolderUri()
	{
		return $_SERVER['REQUEST_URI'];
	}
	public static function FullUri()
	{
		return "http://".self::$_full_uri=self::Host().self::FolderUri();
	}
	public static function Host()
	{
		return self::$_host=$_SERVER['HTTP_HOST'];
	}
	public static function Base($url="")
	{
		$url = trim($url,"/");
		return "http://".self::$_base=self::Host().self::ScriptName().$url;
	}
	public static function ScriptName()
	{
		return self::$_script_name=str_replace("index.php","",$_SERVER['SCRIPT_NAME']);
	}
	public static function Redirect($uri = '', $method = 'location', $http_response_code = 302)
	{

		if(!$uri){
			$uri = self::FullUri();
		}
		
		if ( ! preg_match('#^https?://#i', $uri))
		{
			$uri = self::base($uri);
		}

		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$uri);
			break;
			case 'client'	: echo "<script>window.onLoad=location='".$uri."';</script>";
			break;
			default: header("Location: ".$uri, TRUE, $http_response_code);
			break;
		}
		exit;
	}
}
