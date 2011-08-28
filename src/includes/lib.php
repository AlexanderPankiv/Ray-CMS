<?php
	function format_local_time($time, $show_time=0, $show_date=1){
     	$months=array(
     		1=>'Січня',
     		2=>'Лютого',
     		3=>'Березня',
     		4=>'Квітня',
     		5=>'Травня',
			6=>'Червня',
     		7=>'Липня',
     		8=>'Серпня',
     		9=>'Вересня',
     		10=>'Жовтня',
     		11=>'Листопада',
     		12=>'Грудня'
     		);
   		$day=date('d',$time);
   		$year=date('Y',$time);
   		$mnth=date('n',$time);
   		$return='';
		if($show_date!=0){
	   		$return=$day.' '.$months[$mnth].' '.$year;
   		}
 		if(($show_date!=0)&&($show_time!=0)){
	   		$return.=', ';
	  	}
   		if($show_time!=0){
   			$return.=date('h:i', $time);
   			}
 		return $return;
    }

    function bday_input($name, $data=0){
		if($data==0){
			$data=date('Ymd', time());
		}

		$year=substr($data, 0, 4);
		$mnth=substr($data, 4, 2);
		$day=substr($data, 6, 2);
		$return = '<select name="' . $name . '[1]" >' . "\n";
		for($i=1; $i<=31; $i++){
				$return .= '<option value="' . $i . '" ' . (($day==$i) ? 'selected' : '') . '>' . $i . '</option>' . "\n";
			}
		$return .= '</select> ' . "\n";
		$months=array(0=>'Нулябрь (с) bash.org.ru :)',
	     		1=>'Января',
	     		2=>'Февраля',
	     		3=>'Марта',
	     		4=>'Апреля',
	     		5=>'Мая',
				6=>'Июня',
	     		7=>'Июля',
	     		8=>'Августа',
	     		9=>'Сентября',
	     		10=>'Октября',
	     		11=>'Ноября',
	     		12=>'Декабря'
	    );
		$return.= '<select name="' . $name . '[2]" >' . "\n";
		for($i=1; $i<=12; $i++){
				$return .= '<option value="' . $i . '" ' . (($mnth==$i) ? 'selected' : '') . '>' . $months[$i] . '</option>' . "\n";
			}
		$return.= '</select> ' . "\n";
		$return.= '<select name="' . $name . '[3]" >' . "\n";
		for($i=1920; $i<=date('Y', time()); $i++){
				$return .= '<option value="' . $i . '" ' . (($year==$i) ? 'selected' : '') . '>' . $i . '</option>' . "\n";
			}
		$return .= '</select> ' . "\n";
		return $return;
	}

	function search_modif($text,$search_txt,$color){
	 	$text = preg_replace('/('.$search_txt.')/i',"<font color=".$color."><b>\$1</b></font>",$text);
	 	return $text;
	}

	function simple_select_arr($table,$def_val='Не вибрано',$key='',$val='',$where=''){
		$key = $key=='' ? 'id' : $key;
		$val = $val=='' ? 'name' : $val;

		$res=sql_do("SELECT * FROM $table $where ORDER BY $key");
		$arr=array();
		if($def_val!=''){
			$arr[0]=$def_val;
		}
		while($q=mysql_fetch_array($res)){
	    	$arr[$q[$key]]=$q[$val];
		}
		return $arr;
	}

	function select_tag($name,$values,$selected='',$extra=''){
	    global $config;
		$data = '<select name="' . $name . '" ' . $extra . '>';
        $data.='<option value="0">'.$config['lang_arr']['not_sel'].'</option>';
		foreach($values as $value => $text){
			$data .= '<option value="' . $value . '" ' . (($selected==$value) ? 'selected' : '') . '>' . $text . '</option>' ;
		}
		$data.='</select>';
		return $data;
	}

	function select_group_tag($name, $values, $selected = '', $extra = ''){
	   global $config;
		$data = '<select name="' . $name . '" ' . $extra . '>';
		$data.='<option value="0">'.$config['lang_arr']['not_sel'].'</option>';
		$tmp='';$i=0;
		foreach($values as $value => $text){
            if($tmp!=$text[0] && $value!=0){
            	if($i!=0){$data.='</optgroup>';}
            	$data.='<optgroup label="'.$text[0].'">';
            	$tmp=$text[0];
            }
			$data .= '<option value="' . $value . '" ' . (($selected==$value) ? 'selected' : '') . '>' . $text[1] . '</option>' ;
			$i++;
		}
		$data .= '</optgroup></select> ' ;
		return $data;
	}

	function get_real_ip(){
		if (isset($_SERVER["HTTP_CLIENT_IP"])){
			return $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
			return $_SERVER["HTTP_X_FORWARDED"];
		}
		elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
			return $_SERVER["HTTP_FORWARDED_FOR"];
		}
		elseif (isset($_SERVER["HTTP_FORWARDED"])){
			return $_SERVER["HTTP_FORWARDED"];
		}
		else{
			return $_SERVER["REMOTE_ADDR"];
		}
	}


	function pagination($cur_page,$pages_num,$num=5,$p_data=array()){
        $uri=$_SERVER['REQUEST_URI'];
        $uri=preg_replace('/(?:\?|&)page=\d+/si','',$uri);
        $tmp='';
        if(!empty($p_data)){
        	foreach($p_data as $key=>$val){
            	$tmp.=$key.'='.$val.'&';
        	}

        }

        if(preg_match('/\?/si',$uri)){
        	$uri.='&'.$tmp.'page=';
        }
        else{
        	$uri.='?'.$tmp.'page=';
        }
 		ob_start();
 		?><div class="navi"><div class="wp-pagenavi"><span class="pages">Страница <?=$cur_page?> из <?=$pages_num?></span><?
		$k=0;
		for($i=$cur_page-$num;$i<=$cur_page-1;$i++){
			if($i>0){
            	if($k==0){
                	?><a href="<?=$uri?><?=$cur_page-1?>" class="page">&larr;</a><?
            	}
            	?><a href="<?=$uri?><?=$i?>" class="page"><?=$i?></a><?
            	$k++;
			}
		}
		echo '<span class="current">'.$i.'</span>';
		$k=0;
		for($i=$cur_page+1;($i<=$pages_num && $i<=$cur_page+$num);$i++){
			?><a href="<?=$uri?><?=$i?>" class="page"><?=$i?></a><?
        	$k++;
		}
		if($k>0){
        	?><a href="<?=$uri?><?=$cur_page+1?>" class="page">&rarr;</a><?
		}
		?>
		&nbsp;&nbsp;<a href="<?=$uri?>-1" class="page" style="">Все</a>
		</div></div><?
 		$pages=ob_get_contents();
 		ob_end_clean();
 		return $pages;
	}

	function get_points($cnt) {
		if ($cnt>1000){
			$cnt=$cnt%1000;
		}
		elseif($cnt>100){
			$cnt=$cnt%100;
		}
    	if($cnt>=10 && $cnt<=20){
        	return 'балів';
    	}
    	else{
        	if($cnt%10>=5 || $cnt%10==0 || $cnt<10 && ($cnt>=5 || $cnt==0)){
        		return 'балів';
        	}
        	elseif($cnt%10>=2 || $cnt%10<5 || $cnt<10 && ($cnt>=2 || $cnt<5)){
        		return 'бали';
        	}
        	else{
        		return 'бал';
        	}
    	}
	}

	function add_zero($digit, $result_width)
	{
	    while(strlen($digit) < $result_width)
	      $digit = '0' . $digit;

	      return $digit;
	}
	
	function get_comments($type,$id,$full=0){		
		global $config;
		if($full==0 && g('act')=='all_comments') $full=1;
		$com_limit=5;
		$tpl_data['name']=$config['lang_arr']['name'];
		$tpl_data['comment']=$config['lang_arr']['comment'];
		$tpl_data['type']=$type;
		$tpl_data['id']=$id;
		$comments_form=parse_template($tpl_data,'comments_form');
		$lim='';
		if($full==0){
			$lim="LIMIT $com_limit";			
		}
		$res=sql_do("SELECT SQL_CALC_FOUND_ROWS *, DATE_FORMAT(added,'%e.%m.%Y %l:%i') AS added FROM comments 
					WHERE parent_id='$id' AND parent_type='$type'
					ORDER BY added DESC $lim");
		list($total) = mysql_fetch_row(mysql_query('SELECT FOUND_ROWS()'));
		$show_more=0;
		if($full=0 && $total>$com_limit) $show_more=1;
		$comments='';
		while($q=mysql_fetch_array($res)){
			$comments.=parse_template($q,'comments_list');
		}
		$tpl_data1['form']=$comments_form;
		$tpl_data1['comments']=$comments;
		$tpl_data1['count']=$total;
		$tpl_data1['show_more']=$show_more;
		return parse_template($tpl_data1,'full_comments');
	}
	
	function post_comment() {
		$q_data['parent_type']=p('type');
		$q_data['parent_id']=p('id',1);
		$q_data['name']=p('name');
		$q_data['added']='NOW()';
		$q_data['comment']=p('comment');
		if($q_data['name']!='' && $q_data['comment']!='' && $q_data['parent_type']!='' && $q_data['parent_id']!=0){
			sql_insert('comments',$q_data);
		}		
	}
    
    //////////////////
    //SASHA
    //
    
    function list_cat_subcat($values){
        global $config;
		$tmp='';
        $i=0;
        $data='';
		foreach($values as $value => $text){
            if($tmp!=$text[0] && $value!=0){
            	if($i!=0){$data.='</ul><hr/>';}
            	$data.='<h2><a href="'.$config['url_conf_lang'].'adboard/'.$text[2].'">'.$text[0].'</a></h2><ul>';
            	$tmp=$text[0];
            }
			$data .= '<li><a href="'.$config['url_conf_lang'].'adboard/'.$text[2].'/'.$text[3].'">'.$text[1].'</a></li>' ;
			$i++;
		}
		$data .= '</ul><hr/>' ;
		return $data;
	}
    
    function list_cat($values, $class){
        $data = '<ul class="'.$class.'">';
        foreach($values as $key => $val){
            $data.='<li><a href="'.$key.'">'.$val.'</a></li>';
        }
        $data.='</ul>';
        return $data;
    }
    
    
    function gen_reg_form($data){
        $form='<form method="post">';
        foreach($data as $name => $prefs){
            $form.='<label>'.$prefs['name'].': </label><input name="'.$name.'" type="'.$prefs['type'].'"/><br/>';
        }
        $form.='<input type="submit"/>';
        $form.='</form>';
        return $form;
    }
    
    function href($link, $name=''){
        if(is_array($link)){
            
        }else{
            $name = $name!='' ? $name : $link;
            return '<a href="'.$link.'">'.$name.'</a>';
        }
    }
    
    //
    //END_SASHA
    //////////////////
	

?>