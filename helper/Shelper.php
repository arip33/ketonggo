<?php

function replaceSingleQuote(&$val){
	if(is_array($val)){
		foreach($val as $k=>$v){
			$val[$k]=replaceSingleQuote($v);
		}
	}else{
		$val = str_replace("'", "''", $val);
	}
}

function ReadMore($text='',$urlreadmore='#',$readmore=true){
	$str='';
	$str.=strstr($text, '<br /><!-- pagebreak --><br />', true);
	if(!$str){
		$str.=strstr($text, '<!-- pagebreak -->', true);
	}
	if(!$str){
		$readmore = false;
		$str.= $text;
	}
	if($readmore){
		$str.='<a title="Read more" href="'.$urlreadmore.'" class="more">Read more →</a>';
	}
	$str.="<div style='clear:both'></div>";


	return $str;
}

function DifTime($time1, $time2){
	$time1 = strtotime($time1);
	$time2 = strtotime($time2);
	$time3 = $time1-$time2;
	$jam = floor($time3/3600);
	$time3 = $time3%3600;
	$menit = floor($time3/60);
	$time3 = $time3%60;
	$detik = $time3;
	return $jam.' jam, '. $menit.' menit, '. $detik.' detik';
}



function ReadMorePlain($text='',$count_word=10){
	$text = str_replace(array('<h2>','</h2>','<p>','</p>','<strong>','</strong>', '<ol>', '</ol>', '<li>', '</li>', '<!-- pagebreak -->'),'',$text);
	$text = str_replace(array('  ', '&nbsp;',"\r\t","\r\n"), ' ', $text);

	$text_arr = explode(' ', $text);

	$i=0;
	$str = '';
	foreach ($text_arr as $key => $value) {
		$i++;
		$str.=$value.' ';
		if($count_word==$i)
			break;
	}

	return $str;
}

#2012-01-01
function Eng2Ind($datetime,$is_time=true){
	$exp = explode(" ", $datetime);
	$date = $datetime;
	$time = '';
	if(count($exp)>1){
		$time = substr($exp[1], 0, 8);
		$date = $exp[0];
	}

	if(!$is_time)
		$time = '';
	
	$exp1 = explode("-", $date);
	$list_bulan = ListBulan();
	return $exp1[2].' '.$list_bulan[$exp1[1]].' '.$exp1[0].' '.$time;
}

function ListBulan(){
	return array(
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'Nopember',
			'12'=>'Desember',
		);
}