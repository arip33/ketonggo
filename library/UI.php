<?php 
class UI {
	
	private $auth = array();

	public static function createTextArea($nameid,$value='',$rows='',$cols='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';
            
		if(!empty($edit)) {
			$ta = '<textarea wrap="soft" name="'.$nameid.'" id="'.$nameid.'"';
			if($class != '') $ta .= ' class="'.$class.'"';
			if($rows != '') $ta .= ' rows="'.$rows.'"';
			if($cols != '') $ta .= ' cols="'.$cols.'"';
			if($add != '') $ta .= ' '.$add;
			$ta .= '>';
			if($value != '') $ta .= $value;
			$ta .= '</textarea>';
		}
		else if($value == '')
			$ta = '<i style="color:#aaa">kosong</i>';
		else
			$ta = nl2br($value);
		
		return $ta;
	}
	
	// membuat textbox
	public static function createTextBox($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit)) {
			$tb = '<input type="text" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value == '')
			$tb = '<i style="color:#aaa">kosong</i>';
		else
			$tb = $value;
		
		return $tb;
	}
	
	// membuat textbox
	public static function createTextDate($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit)) {
			$tb = '<input type="text" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			$tb .= ' class="datepicker '.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value == '')
			$tb = '<i style="color:#aaa">kosong</i>';
		else
			$tb = $value;
		
		return $tb;
	}
	
	// membuat textbox
	public static function createAutoComplate($nameid,$value=array(),$url,$maxlength='',$size='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit)) {
			$tb = '<input autocomplete="off" type="text" name="name'.$nameid.'" id="name'.$nameid.'"';
			if($value['label'] != '') $tb .= ' value="'.$value['label'].'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';

			$tb .= '<input type="hidden" name="'.$nameid.'" id="'.$nameid.'"';
			if($value['id']) $tb .= ' value="'.$value['id'].'"';
			$tb .='/>';

			$tb .= '<script>
			$(function(){
				$("#'.$nameid.'").autocomplete("'.URL::Base($url).'");
			});
			</script>';
		}
		else if($value['label'] == '')
			$tb = '<i style="color:#aaa">kosong</i>';
		else
			$tb = $value['label'];


		return $tb;
	}
	
	// membuat textbox 'file',$row['nama_file'], URL::Base("panelbackend/preview_file/$row[id_buku]"), URL::Base("panelbackend/delete_file/$row[id_buku]"), $edited, false, 'form-control'
	public static function createInputFile($nameid, $nama_file, $url_preview, $url_delete, $edit=true, $ispreview=false, $class='form-control', $add='style="width:auto"') {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit)) {
			$tb = '<input type="file" name="'.$nameid.'" id="'.$nameid.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($nama_file == '')
			$tb = '<i style="color:#aaa">kosong</i>';
		


		if($ispreview && $nama_file){
			$tb .= "<img src='$url_preview' width='100px'/>";
		}
		
		$tb .= "<div style='clear:both'></div>";
		$tb .= " <a href='$url_preview' target='_BLANK' style='float:left'>$nama_file</a> &nbsp; ";
		if(!empty($edit) && $nama_file) {
			$tb .= " <a href='$url_delete' style='float:left'>hapus</a> ";
		}
		$tb .= "<div style='clear:both'></div>";
		
		return $tb;
	}
	
	// membuat textbox
	public static function createTextNumber($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit)) {
			$tb = '<input type="number" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value == '')
			$tb = '<i style="color:#aaa">kosong</i>';
		else
			$tb = $value;
		
		return $tb;
	}
	
	// membuat textbox
	public static function createTextPassword($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit)) {
			$tb = '<input type="password" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value == '')
			$tb = '<i style="color:#aaa">kosong</i>';
		else
			$tb = $value;
		
		return $tb;
	}
	
	// membuat combo box
	public static function createSelect($nameid,$arrval='',$value='',$edit=true,$class='form-control',$add='',$emptyrow=false) {
		if(!empty($edit)) {
			$slc = '<select name="'.$nameid.'" id="'.$nameid.'"';
			if($class != '') $slc .= ' class="'.$class.'"';
			if($add != '') $slc .= ' '.$add;
			$slc .= ">\n";
			if($emptyrow)
				$slc .= '<option></option>'."\n";
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					$slc .= '<option value="'.$key.'"'.(!strcasecmp($value,$key) ? ' selected' : '').'>';
					$slc .= $val.'</option>'."\n";
				}
			}
			$slc .= '</select>';
		}
		else {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					if(!strcasecmp($value,$key)) {
						$slc = $val;
						break;
					}
				}
			}
			if(!isset($slc))
				$slc = '&nbsp;';
		}
		
		return $slc;
	}
	
	// membuat combo box
	public static function createSelectKategori($nameid,$arrval='',$value='',$edit=true,$class='form-control',$add='',$emptyrow=false) {
		if(!empty($edit)) {
			$slc = '<select name="'.$nameid.'" id="'.$nameid.'"';
			if($class != '') $slc .= ' class="'.$class.'"';
			if($add != '') $slc .= ' '.$add;
			$slc .= ">\n";
			if($emptyrow)
				$slc .= '<option></option>'."\n";
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					$slc .= '<option value="'.$key.'"'.(!strcasecmp($value,$key) ? ' selected' : '').'>';
					$slc .= $val.'</option>'."\n";
				}
			}
			$slc .= '</select>';
		}
		else {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					if(!strcasecmp($value,$key)) {
						$slc = $val;
						break;
					}
				}
			}
			if(!isset($slc))
				$slc = '&nbsp;';
		}
		
		return $slc;
	}
	
	// membuat textbox
	public static function createCheckBox($nameid,$valuecontrol='',$value='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';
			
		if (!$edit && $value == $valuecontrol) {
			return '<img class="link" src="'. URL::Base("assets/img/light/check.png").'" />';
		}

		$tb = '<input type="checkbox" name="'.$nameid.'" id="'.$nameid.'"';
		if($valuecontrol != '') {
			$tb .= ' value="'.$valuecontrol.'"';
			if ($value == $valuecontrol)
				$tb .= ' checked ';
		}
		if($class != '') $tb .= ' class="'.$class.'"';
		if($add != '') $tb .= ' '.$add;
		if(!$edit)
			$tb .= ' disabled ';
		$tb .= '>';
		
		return $tb;
	}
	
	// membuat radio button
	public static function createRadio($nameid,$arrval='',$value='',$edit=true,$br=false,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';

		$radio = '';
		
		if(!empty($edit)) {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					$radio .= '<input type="radio" name="'.$nameid.'" id="'.$nameid.'_'.$key.'" value="'.$key.'"'.(!strcasecmp($value,$key) ? ' checked' : '').' '.$add.'>';
					$radio .= '<label for="'.$name.'_'.$key.'">'.$val.'</label>'.($br ? '<br>' : '')."\n";
				}
			}
		}
		else {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					if(!strcasecmp($value,$key)) {
						$radio = $val;
						break;
					}
				}
			}
		}
		
		return $radio;
	}
	
	public static function showPaging($paging, $page, $limit_arr, $limit, $list){
		if(!$list['total'])
			return;
		
		$batas_atas = (($page-1)*$limit)+1;
		$batas_bawah = $batas_atas+($limit-1);
		if($batas_bawah>$list['total']){
			$batas_bawah = $list['total'];
		}
		?>
		<div class="col-xs-6"><?=$paging?> Per Halaman <?php foreach($limit_arr as $k=>$v){$limit_arr1[$v]=$v;} echo UI::createSelect('list_limit',$limit_arr1,$limit, true, 'form-control', 'onchange="goLimit()" style="width:auto;display:inline"')?></div>
		<div class="col-xs-6" style="text-align:right">
			<?=$batas_atas?> sampai <?=$batas_bawah?> dari <?=$list['total']?> data
		</div>
		<script>
		    function goLimit(){
		        $("#act").val('list_limit');
		        $("#main_form").submit();
		    }

		</script>
		<?php
	}
	
	public static function showPagingCms($paging, $page, $limit_arr, $limit, $list){
		if(!$list['total'])
			return;
		
		$batas_atas = (($page-1)*$limit)+1;
		$batas_bawah = $batas_atas+($limit-1);
		if($batas_bawah>$list['total']){
			$batas_bawah = $list['total'];
		}
		?>
		<ul class="pagination__list" style="float:left">

			<?=$paging?> 
			<li >
			<span style="border:none" >
			Per Halaman 
			</span>
			</li>
			<li>
			<?php 
			foreach($limit_arr as $k=>$v){$limit_arr1[$v]=$v;} 
			echo UI::createSelect('list_limit',$limit_arr1,$limit, true, 'text_input', 
			'onchange="goLimit()" 
			style="display: block;
			height: 12px;
			color: #666;
			padding: 8px 4px 8px;
			font-size: 11px;
			-webkit-box-sizing: content-box;
			-moz-box-sizing: content-box;
			box-sizing: content-box;"'
			);
			?>
			</li></ul>
			<ul class="pagination__list">
			<li>
			<span style="border:none;">
			<?=$batas_atas?> sampai <?=$batas_bawah?> dari <?=$list['total']?> data
			</span>
			</li>
			
		</ul>
		<script>
		    function goLimit(){
		        jQuery("#act").val('list_limit');
		        jQuery("#main_form").submit();
		    }

		</script>
		<?php
	}

	public static function showHeader($header, $filter_arr, $list_sort, $list_order){

		$kg = get_instance();
	?>
	      <tr>
	        <td></td>
	        <?php foreach($header as $rows){
	        	switch ($rows['type']) {
	        		case 'list':
	        			echo "<td>".UI::createSelect("list_search[".$rows['name']."]",$rows['value'],$filter_arr[$rows['name']],true,'form-control')."</td>";
	        			break;
	        		
	        		case 'date':
	        			$kg->plugin[]='datepicker';
	            		echo "<td>".UI::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',true,'form-control datepicker','placeholder="Search '.$rows['label'].'..."')."</td>";
	        			break;
	        		
	        		default:
	            		echo "<td>".UI::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',true,'form-control','placeholder="Search '.$rows['label'].'..."')."</td>";
	        			break;
	        	}
	        }
	        ?>
	        <td style='text-align:right'><button type="submit" class='btn btn-ms btn-warning'>Search</button></td>
	      </tr>
	      <tr>
	        <th style="width:10px">#</th>
	        <input type='hidden' name='list_sort' id='list_sort'>
	        <input type='hidden' name='list_order' id='list_order'>
	        <?php foreach($header as $rows){
	            if($list_sort==$rows['name']){
	                if(trim($list_order)=='asc'){
	                    $order = 'desc';
	                }else{
	                    $order = 'asc';
	                }
	               echo "<th style='width:$rows[width]'><a href='#' onclick=\"goSort('{$rows['name']}','$order')\">$rows[label]</a></th>";
	            }else{
	        	   echo "<th style='width:$rows[width]'><a href='#' onclick=\"goSort('{$rows['name']}','asc')\">$rows[label]</a></th>";
	            }
	        }
	        ?>
	        <th></th>
	      </tr>
	    <script>
		    $(function(){
		        $("#main_form").submit(function(){
		            if($("#act").val()==''){
		                goSearch();
		            }
		        });
		    });

		    function goSort(name, order){
		        $("#list_sort").val(name);
		        $("#list_order").val(order);
		        $("#act").val('list_sort');
		        $("#main_form").submit();
		    }

		    function goSearch(){
		        $("#act").val('list_search');
		        $("#main_form").submit();
		    }
	    </script>
    <?php
	}


	public static function showHeaderFront($header, $filter_arr, $list_sort, $list_order){
	?>
	      <tr>
	        <td></td>
	        <?php foreach($header as $rows){
	        	switch ($rows['type']) {
	        		case 'list':
	        			echo "<td>".UI::createSelect("list_search[".$rows['name']."]",$rows['value'],$filter_arr[$rows['name']],true,'text_input hint','style="width:100%;padding: 6px 0px 6px 10px;" onchange="goSearch()"')."</td>";
	        			break;
	        		
	        		default:
	            		echo "<td>".UI::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',true,'text_input hint','style="width:100%;padding: 6px 0px 6px 10px;" placeholder="Search '.$rows['label'].'..."')."</td>";
	        			break;
	        	}
	        }
	        ?>
	      </tr>
	      <tr>
	        <th style="width:10px">#</th>
	        <input type='hidden' name='list_sort' id='list_sort'>
	        <input type='hidden' name='list_order' id='list_order'>
	        <?php foreach($header as $rows){
	            if($list_sort==$rows['name']){
	                if(trim($list_order)=='asc'){
	                    $order = 'desc';
	                }else{
	                    $order = 'asc';
	                }
	               echo "<th style='width:$rows[width]'><a href='#' onclick=\"goSort('{$rows['name']}','$order')\">$rows[label]</a></th>";
	            }else{
	        	   echo "<th style='width:$rows[width]'><a href='#' onclick=\"goSort('{$rows['name']}','asc')\">$rows[label]</a></th>";
	            }
	        }
	        ?>
	      </tr>
	    <script>
		    jQuery(function(){
		        jQuery("#main_form").submit(function(){
		            if(jQuery("#act").val()==''){
		                goSearch();
		            }
		        });
		    });

		    function goSort(name, order){
		        jQuery("#list_sort").val(name);
		        jQuery("#list_order").val(order);
		        jQuery("#act").val('list_sort');
		        jQuery("#main_form").submit();
		    }

		    function goSearch(){
		        jQuery("#act").val('list_search');
		        jQuery("#main_form").submit();
		    }
	    </script>
    <?php
	}

	public static function showButtonMode($mode, $key=null, $edited=false) {
		$str = '';
		if ($mode === 'lst' || $mode === 'index' || $mode === 'daftar') {
			$str .= UI::getButton('add');
			$str .= UI::getButton('reset');
			return $str;
		}

		if ($mode === 'oneedit'){

			$str .= UI::getButton('detail', $key);
			return $str;
		}

		if ($mode === 'onedetail'){

			$str .= UI::getButton('edit', $key);
			return $str;
		}

		if ($mode === 'edit') {
			//$str .= UI::getButton('save');
			//$str .= UI::getButton('batal', $key);
			
			$str .= UI::getButton('add');
			$str .= UI::getButton('lst');
			return $str;
		}

		if ($mode === 'add') {
			//$str .= UI::getButton('save');
			$str .= UI::getButton('lst');
			return $str;
		}

		if ($mode === 'detail') {
			$str .= UI::getButton('edit', $key);
			$str .= UI::getButton('delete', $key);
			$str .= UI::getButton('add');
			$str .= UI::getButton('lst');
			return $str;
		}

		if ($mode === 'save' && $edited) {
			$str .= UI::getButton('save');
			$str .= UI::getButton('batal', $key);
			return $str;
		}
	}
	
	public static function getButton($id, $key=null, $add='') {
		$kg = get_instance();
		if($kg->data['add_param']){
			$add_param = '/'.$kg->data['add_param'];
		} 

		if ($id === 'add') {
			return '<input type="button" '.$add.' class="btn btn-sm btn-primary" value="Tambah" onclick="return goAdd()" /> 
			<script>
		    function goAdd(){
		        window.location = "'.URL::Base($kg->page_ctrl."/add".$add_param).'";
		    }
		    </script>';
		}

		if ($id === 'edit') {
			return '<input type="button" '.$add.' class="btn btn-sm btn-warning" value="Ubah" onclick="return goEdit(\''.$key.'\')" /> 
			<script>
		    function goEdit(id){
		        window.location = "'.URL::Base($kg->page_ctrl."/edit".$add_param).'/"+id;
		    }
		    </script>
			';
		}

		if ($id === 'detail') {
			return '<input type="button" '.$add.' class="btn btn-sm btn-warning" value="Detail" onclick="return goDetail(\''.$key.'\')" /> 
			<script>
		    function goDetail(id){
		        window.location = "'.URL::Base($kg->page_ctrl."/detail".$add_param).'/"+id;
		    }
		    </script>
			';
		}

		if ($id === 'delete') {
			return '<input type="button" '.$add.' class="btn btn-sm btn-danger" value="Hapus" onclick="return goDelete(\''.$key.'\')" /> 
			<script>
		    function goDelete(id){
		        if(confirm("Apakah Anda yakin akan mengahapus ?")){
		            window.location = "'.URL::Base($kg->page_ctrl."/delete".$add_param).'/"+id;
		        }
		    }
		    </script>';
		}

		if ($id === 'lst' || $id === 'index') {
			return '<input type="button" '.$add.' class="btn btn-sm btn-success" value="Daftar" onclick="return goList()" /> 
			<script>
			function goList(){
			window.location = "'.URL::Base($kg->page_ctrl."/index".$add_param).'";
			}
			</script>';
		}

		if ($id === 'save') {
			return '<input type="submit" class="btn btn-sm btn-success" value="Simpan" onclick="return goSave()" /> 
			<script>
			function goSave(){      
		      	$("#act").val(\'save\');
				$("#main_form").submit();
			}
			</script>';
		}

		if ($id === 'batal') {
			return '<input type="submit" class="btn btn-sm btn-warning" value="Batal" onclick="return goBatal(\''.$key.'\')" /> 
			<script>
			function goBatal(){
				$("#act").val(\'reset\');
				$("#main_form").submit();
			}
			</script>';
		}

		if ($id === 'reset') {
			return '<input type="button" '.$add.' class="btn btn-sm btn-success" value="Reset" onclick="return goReset()" /> 
			<script>
			function goReset(){
				$("#act").val(\'list_reset\');
				$("#main_form").submit();
			}
			</script>';
		}

	}
    
}