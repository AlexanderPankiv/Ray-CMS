<?php
	function random_string($num_chars) {
	$chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',  'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',  'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9');

	list($usec, $sec) = explode(' ', microtime());
	mt_srand($sec * $usec);

	$max_chars = sizeof($chars) - 1;
	$rand_str = '';
	for ($i = 0; $i < $num_chars; $i++)	{
		$rand_str .= $chars[mt_rand(0, $max_chars)];
	}

	return $rand_str;
}
class InputForm {
	var $options = array(
		'action'   => '',
		'method'   => 'post',
		'target'   => '',
		'enctype'  => '',
		'events'   => '',
		'submit'   => 'Ok',
		'disable_submit_button' => false,
		'id'       => '',
		'name'     => '',
		'reset'    => '',
		'cols'     => 2,
		'mode'     => 'edit'
	);

	var $_rows;
	var $_rows1;
	var $_hiddens;


	var $_elements = array(
	'hidden' => '<input type="hidden" name="%1" value="%2" />',
	'file' => '<input type="file" name="%1" value="" />',
	);

	function InputForm($opt) {
		foreach($this->options as $key=>$val){
			if(!empty($opt[$key])){
				$this->options[$key]=$opt[$key];
			}
		}
	}

	function addrow($contents){
		$this->_rows1[]=$contents;
		return key($this->_rows1);
	}

	function simple_form_row($left,$right){
    	$this->_rows1[] = array(
    		0=>array('data' => $left,'width'=>'25%','align'=>'right'),
    		1=>array('data' => $right,'class'=>'col_right')
    	);
		return key($this->_rows1);
	}

	function simple_data_row($left,$right){
    	$this->_rows1[] = array(
    		0=>array('data' => $left,'width'=>'80%'),
    		1=>array('data' => $right,'class'=>'col_right')
    	);
		return key($this->_rows1);
	}

	function hidden($name, $value) {
		$this->_hiddens[$name] = $value;
	}

	function addbreak($break = "&nbsp;",$align='left') {
		$this->_rows1[] = array(array('data' => $break,'colspan'=>$this->options['cols'],'class'=>'break','align'=>$align));
		return key($this->_rows1);
	}

	function addmessage( $message ){
		$this->_rows[]=array("message"=>$message);
	}

	function show ($return = false){
		$result='';
		if($this->options['mode']=='edit'){
	    	$result = '<form action="' . $this->options['action'] . '" method="' . $this->options['method'] . '" name="' . $this->options['name'] . '"';

			if(!empty($this->options['target'])) {
				$result .= ' target="' . $this->options['target'] . '"';
			}
			if(!empty($this->options['enctype'])) {
				$result .= ' enctype="' . $this->options['enctype'] . '"';
			}
			if(!empty($this->options['events'])) {
				$result .= ' ' . $this->options['events'];
			}
			if(!empty($this->options['id'])){
				$result .= ' id="' . $this->options['id'].'"';
			}
			$result .= '>' . "\n";


			if(is_array($this->_hiddens)) {
				foreach($this->_hiddens as $name => $value){
					$result .= str_replace(array('%1', '%2'), array($name, $value), $this->_elements['hidden']) . "\n";
				}
			}
		}

		$result .= '<table border="0" cellspacing="2" cellpadding="2" width="90%" style="margin: 0 auto;">' . "\n";

		if(is_array($this->_rows1)) {
		 	foreach($this->_rows1 as $row){
		 		$result .= '<tr>' . "\n";
            	foreach($row as $col){
            		$width=!empty($col['width']) ? ' width="'.$col['width'].'"' : '';
            		$extra=!empty($col['extra']) ? ' '.$col['extra'] : '';
            		$class=!empty($col['class']) ? ' class="'.$col['class'].'"' : 'class="col_left"';
            		$colspan=!empty($col['colspan']) ? ' colspan="'.$col['colspan'].'"' : '';
            		$align=!empty($col['align']) ? ' align="'.$col['align'].'"' : 'align="left"';
					$result .= '  <td '.$align.$colspan.$width.$extra.$class.'>' . $col['data'] . '</td>' . "\n";
            	}
            	$result .= '</tr>' . "\n";
		 	}
		}
        if($this->options['disable_submit_button']==false){
			$result .= '<tr>' . "\n";
			if($this->options['mode']=='edit'){//edit mode submit button
				$result .= '  <td align="center" colspan="'.$this->options['cols'].'"><input type="submit" value="' . $this->options['submit'] . '" class="btnmain">';
				if(!empty($this->options['reset'])) {
					$result .= '<input type="reset" value="' . $this->options['reset'] . '" class="btnlite">';
				}
				$result .= '</td>' . "\n";
			}
			else{//view mode submit button
	        	$result .= '  <td align="center" colspan="'.$this->options['cols'].'"><input type="button" value="' . $this->options['submit'] . '" class="btnmain" onclick="window.location=\''.$this->options['action'].'\'">';
			}
			$result .= '</tr>' . "\n";
		}
		$result .= '</table>' . "\n";
		if($this->options['mode']=='edit'){
			$result .= '</form>' . "\n";
		}
		if($return){
			return $result;
		} else {
			echo $result;
			return true;
		}
	}


	function text_box($name, $value, $size = 0, $maxlength = 0, $password = false, $extra = ''){
		if($this->options['mode']=='edit'){//edit mode
			return '<input type="' . (($password) ? 'password' : 'text') . '" class="text" name="' . $name . '"' . (($size > 0) ?  ' size="' . $size . '"' : '') . (($maxlength > 0) ?  ' maxlength="' . $maxlength . '"' : '') . ' value="' . htmlspecialchars($value) . '" ' . $extra . '>';
		}
		else{//view mode
			return '<span '.$extra.'>'.$value.'</span>';
		}
	}

	function textarea($name, $value, $cols = 30, $rows = 5, $extra = ''){
		if($this->options['mode']=='edit'){//edit mode
			return '<textarea name="' . $name . '" cols="' . $cols . '" rows="' . $rows . '" ' . $extra . '>' . $value . '</textarea>';
		}
		else{//view mode
        	return '<span '.$extra.'>'.$value.'</span>';
		}
	}

	function select_tag($name, $values, $selected = '', $extra = ''){
		if($this->options['mode']=='edit'){//edit mode
			$data = '<select name="' . $name . '" ' . $extra . '>' . "\n";
			$data.='<option value="0">- - - -</option>'."\n";
			foreach($values as $value => $text){
				$data .= '<option value="' . $value . '" ' . (($selected==$value) ? 'selected' : '') . '>' . $text . '</option>' . "\n";
			}
			$data .= '</select> ' . "\n";
			return $data;
		}
		else{//view mode
			$txt=' ';
			foreach($values as $value => $text){
				if($selected==$value){
					$txt=$text;
				}
			}
			return '<span '.$extra.'>'.$txt.'</span>';
		}
	}

	function select_group_tag($name, $values, $selected = '', $extra = ''){
		$data = '<select name="' . $name . '" ' . $extra . '>' . "\n";
		$data.='<option value="0">- - - -</option>'."\n";
		$tmp='';$i=0;
		foreach($values as $value => $text){
            if($tmp!=$text[0] && $text[0]!=''){
            	if($i!=0){$data.='</optgroup>'."\n";}
            	$data.='<optgroup label="'.$text[0].'">'."\n";
            	$tmp=$text[0];
            }
			$data .= '<option value="' . $value . '" ' . (($selected==$value) ? 'selected' : '') . '>' . $text[1] . '</option>' . "\n";
			$i++;
		}
		$data .= '</optgroup></select> ' . "\n";
		return $data;
	}

	function radio_button($name, $values, $selected = '', $separator = ' ', $extra = ''){
		$data = '';
		foreach($values as $value => $text){
			$id = random_string(5);
			$data .= '<input type="radio" name="' . $name . '" value="' . $value . '" id="' . $id . '" ' . (($selected == $value) ? 'checked' : '') . ' ' . $extra . '><label for="' . $id . '">' . $text . '</label>' . $separator;
		}
		return $data;
	}

	function radio_button_single($name, $value, $selected = '', $caption = ' ', $extra = ''){
		$id = random_string(5);
		return '<input type="radio" name="' . $name . '" value="' . $value . '" id="' . $id . '" ' . (($selected) ? 'checked' : '') . ' ' . $extra . '><label for="' . $id . '">' . $caption . '</label>';
	}

	function checkbox($name, $value, $caption, $checked = 0, $extra = ''){
		$id = random_string(5);
		return '<input type="checkbox" name="' . $name . '" value="' . $value . '" id="' . $id . '" ' . ((!empty($checked)) ? 'checked' : '') . ' ' . ' style="margin-bottom:2px;"/><label for="' . $id . '" '.$extra.'>' . $caption . '</label>';
	}

	function checkbox_right($name, $value, $caption, $checked = 0, $extra = ''){
		$id = random_string(5);
		return '<label for="' . $id . '" '.$extra.'" style="margin-right:5px;">' . $caption . '</label><input type="checkbox" name="' . $name . '" value="' . $value . '" id="' . $id . '" ' . ((!empty($checked)) ? 'checked' : '') . ' ' . ' style="margin-bottom:2px;"/>';
	}

	function file($name) {
		return '<input type="file" name="' . $name . '" value="" />';
	}

	function del_edit($id,$del_title,$edit_title){
    	return '<a href="'.$this->options['action'].'&edit='.$id.'" class="edit" style="margin-right: 10px;">'.$edit_title.'</a>'.$this->checkbox_right('delete['.$id.']', '1',$del_title,0,'class="delete"');
	}

	function view($id,$title){
		return '<a href="'.$this->options['action'].'&view='.$id.'" class="view">'.$title.'</a>';
	}
}
?>