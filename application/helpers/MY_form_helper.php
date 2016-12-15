<?php

/**
 * DB 필드값을 HTML로 변환
 */
if ( ! function_exists('field_to_html'))
{
	function field_to_html($field_name, $value, $type = 'input', $max_length = 100, $options = null, $selects = null, $style='', $readonly = '', $checked = false)
	{
		$CI =& get_instance();
		
		$html = null;

		if($type=='input')
		{
			$data = array(
              'name'        => $field_name,
              'id'          => $field_name,
              'value'       => $value,
              'maxlength'   => $max_length,
              'style'		=> $style,
              'onfocus' => 'this.select()',
              'class' => 'form-control'
            );

			if($readonly=='readonly') {
				$data['readonly'] = 'readonly';
			}
			
			$html = form_input($data);
		}
		if($type=='password')
		{
			$data = array(
              'name'        => $field_name,
              'id'          => $field_name,
              'value'       => $value,
              'maxlength'   => $max_length,
              'style'		=> $style,
              'onfocus' => 'this.select()',
              'class' => 'form-control'
            );

			if($readonly=='readonly') {
				$data['readonly'] = 'readonly';
			}
			
			$html = form_password($data);
		}
		else if($type=='hidden') 
		{
			$data = array(
				$field_name => $value
			);
			$html = form_hidden($data);
		}
		else if($type=='textarea')
		{
			$data = array(
              'name'        => $field_name,
              'id'          => $field_name,
              'value'       => $value,
              'maxlength'   => $max_length,
              'rows'        => '5',
              'cols'		=> '100',
              'style'		=> $style,
            );
			if($readonly=='readonly') {
				$data['readonly'] = 'readonly';
			}
			$html = form_textarea($data);
		}
		else if($type=='select')
		{
			if($readonly=='readonly')
				$tmp_disabled = 'disabled="disabled"';
			$html = form_dropdown($field_name,$options,$value, $tmp_disabled);
		}
		else if($type=='multiselect')
		{
			$style = 'style="'.$style.'"';
			if($readonly=='readonly')
				$style = $style . ' disabled="disabled"';
			$html = form_multiselect($field_name, $options, $selects, $style);
		}
		else if($type=='checkbox')
		{
			$data = array(
			    'name'        => $field_name,
			    'id'          => $field_name,
			    'value'       => $value,
			    'checked'     => $checked,
			    'style'       => $style,
			    );
			$html = form_checkbox($data);
		}
		else if($type=='file')
		{
			$data = array(
              'name'        => $field_name,
              'id'          => $field_name,
              'style'		=> $style
            );
			
			$html = form_upload($data);
		}
		return $html;
	}
}
?>