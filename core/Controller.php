<?php
class Controller{
	private static $instance;
	public $data = array();
	public $router;
	public $post=array();
	public $conn;
	public $model;
	public $ctrl;
	public $page_ctrl;
	public $method;
	public $mode;
	public $session;
	public $get=array();
	public $addbuttons = array();
	protected $xss_clean = false;
	public $url = "";
	public $urlaccess = "";
	public $viewpath = "";
	public $auth;
	public $private = true;
	static $referer = false;
	public $pk;
	public $limit = 5;
	public $limit_arr = array('5','10','15');
	public $arrNoquote = array();
	protected $layout = "";
	protected $viewdetail = "";
	protected $viewlist = "";
	protected $filter = " 1=1 ";
	public $access_mode = array();
	public $page_escape = array();
	public $is_super_admin = false;
	public function __construct()
	{
		self::$instance =& $this;

		global $router;
		$this->data['router'] = $this->router = $router;

		$this->ctrl = $router->page;
		$this->page_ctrl = $router->uri;
		$this->method = $router->methode;
		$this->mode = $router->mode;
		$this->data['ctrl'] = $this->ctrl;
		$this->data['method'] = $this->method;
		$this->data['page_ctrl'] = $router->uri;
		$this->data['mode'] = $this->mode;

		$model = new Model();
		$this->conn = $model->conn;
		
		$this->session = new Session();
		$this->data['session'] = $this->session;

		$this->FilterRequest();
	}

	protected function Plugin(){
		if(!count($this->plugin_arr))
			return;
				
		#chosen
		$plugin['chosen'] .= '<script src="'.URL::Base().'assets/js/chosen.jquery.js"></script>';
		$plugin['chosen'] .= "<script>$(function() {
        \$('.chosen-select').chosen({width:'100%'});
        \$('.chosen-select-deselect').chosen({ allow_single_deselect: true });
      });</script>";
		$plugin['chosen'] .= '<link rel="stylesheet" href="'.URL::Base().'assets/css/bootstrap-chosen.css" />';

		#date picker
		$plugin['datepicker'] .= '<script src="'.URL::Base().'assets/js/datepicker/js/moment.min.js"></script>';
		$plugin['datepicker'] .= '<script src="'.URL::Base().'assets/js/datepicker/js/bootstrap-datetimepicker.js"></script>';
		$plugin['datepicker'] .= '<script>$(function(){$(".datepicker").datetimepicker({format: "YYYY-MM-DD",useCurrent:false});});</script>';
		$plugin['datepicker'] .= '<script>$(function(){$(".datetimepicker").datetimepicker({format: "YYYY-MM-DD HH:mm:ss",useCurrent:false});});</script>';
		$plugin['datepicker'] .= '<link rel="stylesheet" href="'.URL::Base().'assets/js/datepicker/css/bootstrap-datetimepicker.min.css" />';


		#date picker
		//$plugin['autocomplate'] = '<script src="'.URL::Base().'assets/js/typeahead.bundle.js"></script>';
		$plugin['autocomplete'] = '<script src="'.URL::Base().'assets/js/bootstrap3-typeahead.min.js"></script>';


		$plugin_arr=array_unique(array_values($this->plugin_arr));
		foreach($plugin_arr as $k=>$v){
			$this->data['add_plugin'] .= $plugin[$v]."\n";
		}
	}

	public static function &get_instance()
	{
		return self::$instance;
	}

	protected function FilterRequest(){

		if(!is_array($_POST)) $_POST = array();
		if(!is_array($_GET)) $_GET = array();

		if($this->xss_clean){
			#clean xss
			foreach($_POST as $key => $value)
			{
				$this->post[$key] = $this->xss($value);
			}

			foreach($_GET as $key => $value)
			{
				$this->get[$key] = $this->xss($value);
			}
		}else{
			$this->post = $_POST;
			$this->get = $_GET;
		}
	}

	public function XSS($val) 
	{
		if(is_array($val)){
			$valarr = array();
			foreach ($val as $key => $value) {
				# code...
				$valarr[$key] = $this->XSS($value);
			}
			return $valarr;
		}
		//axe all non printables
		$val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
		
		$search = 'abcdefghijklmnopqrstuvwxyz';
		$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$search .= '1234567890!@#$%^&*()';
		$search .= '~`";:?+/={}[]-_|\'\\';
		for($i = 0; $i < strlen($search); $i++) 
		{
			//axe all non characters
			$val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
			$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
		}
	   
		$ra1 = array(
			'javascript','vbscript','expression',
			'applet','meta','xml','blink','link',
			'style','script','embed','object',
			'iframe','frame','frameset','ilayer',
			'layer','bgsound','title','base');
		$ra2 = array(
			'onabort','onactivate','onafterprint',
			'onafterupdate','onbeforeactivate',
			'onbeforecopy','onbeforecut',
			'onbeforedeactivate','onbeforeeditfocus',
			'onbeforepaste','onbeforeprint',
			'onbeforeunload','onbeforeupdate','onblur',
			'onbounce','oncellchange','onchange','onclick',
			'oncontextmenu','oncontrolselect','oncopy',
			'oncut','ondataavailable','ondatasetchanged',
			'ondatasetcomplete','ondblclick','ondeactivate',
			'ondrag','ondragend','ondragenter',
			'ondragleave','ondragover','ondragstart',
			'ondrop','onerror','onerrorupdate',
			'onfilterchange','onfinish','onfocus',
			'onfocusin','onfocusout','onhelp','onkeydown',
			'onkeypress','onkeyup','onlayoutcomplete',
			'onload','onlosecapture','onmousedown',
			'onmouseenter','onmouseleave','onmousemove',
			'onmouseout','onmouseover','onmouseup',
			'onmousewheel','onmove','onmoveend','onmovestart',
			'onpaste','onpropertychange','onreadystatechange',
			'onreset','onresize','onresizeend','onresizestart',
			'onrowenter','onrowexit','onrowsdelete',
			'onrowsinserted','onscroll','onselect',
			'onselectionchange','onselectstart','onstart',
			'onstop','onsubmit','onunload');
		$ra = array_merge($ra1, $ra2);
	   
		$found = true;
		while($found == true)
		{
			$val_before = $val;
			for($i = 0; $i < sizeof($ra); $i++) 
			{
				$pattern = '/';
				for($j = 0; $j < strlen($ra[$i]); $j++) 
				{
					if($j > 0) 
					{
						$pattern .= '((&#[xX]0{0,8}([9ab]);)||(&#0{0,8}([9|10|13]);))*';
					}
					$pattern .= $ra[$i][$j];
				}
				
				$pattern .= '/i';
				//break all on*
				$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
				$val = preg_replace($pattern, $replacement, $val);
				if($val_before == $val) $found = false;
			}
		}

	   return $val;
	}
	
	protected function Helper($filename)
	{
		if(is_array($filename))
		{
			foreach($filename as $k=>$v){
				$this->Helper($v);
			}
		}
		else
		{
			if(is_file(base_dir.'helper/'.$filename.'.php')){
				require_once(base_dir.'helper/'.$filename.'.php');
			}elseif(is_file(ketonggo.'helper/'.$filename.'.php')){
				require_once(ketonggo.'helper/'.$filename.'.php');
			}
		}
		unset($filename);
	}
	
	protected function Library($filename)
	{
		if(is_array($filename))
		{
			foreach($filename as $k=>$v){
				$this->Library($v);
			}
		}
		else
		{
			if(is_file(base_dir.'library/'.$filename.'.php')){
				require_once(base_dir.'library/'.$filename.'.php');
			}elseif(is_file(ketonggo.'library/'.$filename.'.php')){
				require_once(ketonggo.'library/'.$filename.'.php');
			}
		}
		unset($filename);
	}

	public function NoData($str='Data tidak ditemukan.'){
		echo "<h2 align='center' style='margin-top:20%;color:#444'>Informasi</h2>$str";
		exit();
	}

	public function Error404($str=''){
		echo "<h2 align='center' style='margin-top:20%;color:#444'>ERROR 404</br>PAGE NOT FOUND</h2>$str";
		exit();
	}

	public function Error403($str=''){
		echo "<h2 align='center' style='margin-top:20%;color:#444'>ERROR 403</br>ACCESS DENIED</h2>$str";
		exit();
	}

	//load view with template
	protected function View($view='')
	{

		$this->Plugin();

		if(is_array($this->data))
		{
			foreach($this->data as $key=>$value)
			{
				${$key}=$value;
			}
		}
		//when template empty
		if(empty($this->template) or !is_file(base_dir.'mvc/view/'.$this->template.'.php')){
			throw new Exception("Template don't exist");
		}else{
			//when file view not exist
			if(!empty($view) && !is_file(base_dir.'mvc/view/'.$view.'.php')){
				throw new Exception("View \"view/$view.php\" don't exist");
			}else if(is_file(base_dir.'mvc/view/'.$view.'.php')){
				ob_start();
				require_once(base_dir.'mvc/view/'.$view.'.php');
				$content=ob_get_contents();
				ob_end_clean();
				$this->data['content']=$content;
			}
			require_once(base_dir.'mvc/view/'.$this->template.'.php');
		}

		unset($view);
		unset($this->data);
	}
	//load view without template
	protected function PartialView($view='',$string=false){

		$this->Plugin();

		if(is_array($this->data))
		{
			foreach($this->data as $key=>$value)
			{
				${$key}=$value;
			}
		}
		if(!empty($view) && is_file(base_dir.'mvc/view/'.$view.'.php')){
			if($string){
				ob_start();
				require_once(base_dir.'mvc/view/'.$view.'.php');
				$content=ob_get_contents();
				ob_end_clean();
				return $content;
			}else{
				require_once(base_dir.'mvc/view/'.$view.'.php');
			}
		}
	}

	public function FlashMsg(){
		if($this->session->Get($this->ctrl.'suc_msg')){
			$this->data['suc_msg']=$this->session->GetFlash($this->ctrl.'suc_msg');
		}
		if($this->session->Get($this->ctrl.'inf_msg')){
			$this->data['inf_msg']=$this->session->GetFlash($this->ctrl.'inf_msg');
		}
		if($this->session->Get($this->ctrl.'wrn_msg')){
			$this->data['wrn_msg']=$this->session->GetFlash($this->ctrl.'wrn_msg');
		}
		if($this->session->Get($this->ctrl.'err_msg')){
			$this->data['err_msg']=$this->session->GetFlash($this->ctrl.'err_msg');
		}

		if($this->data['suc_msg']){
			echo '
			<div class="alert alert-success" role="alert">
			'.$this->data['suc_msg'].'
			</div>';
		}
		if($this->data['inf_msg']){
			echo '
			<div class="alert alert-info" role="alert">
			'.$this->data['inf_msg'].'
			</div>';
		}
		if($this->data['wrn_msg']){
			echo '
			<div class="alert alert-warning" role="alert">
			'.$this->data['wrn_msg'].'
			</div>';
		}
		if($this->data['err_msg']){
			echo '
			<div class="alert alert-danger" role="alert">
			'.$this->data['err_msg'].'
			</div>';
		}
	}
	
	protected function SetFlash($key, $msg){
		$this->session->Set($this->ctrl.$key, $msg);
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
