<?php
function send_json($code = 200, $message = 'Success', $result = null) {
   echo json_encode(array('code' => $code, 'message' => $message, 'result'=>$result));
    exit;
}

function current_url_with_querystring()
{
    $CI =& get_instance();

    $url = $CI->config->site_url($CI->uri->uri_string());
    return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
}

function get_http_response_code($url) {
	$headers = get_headers($url);
	return substr($headers[0], 9, 3);
}

function store_html($app_id) {
	if(!$app_id) {
		return '';
	}

	$url = "https://play.google.com/store/apps/details?id=".$app_id;
	if(get_http_response_code($url) != "200"){
		// log_message('error', 'Non existing url: '.$url);
		return '';
	}else{
		return file_get_contents($url);
	}
}

function get_app_name($html){
	$title = "";

	if( preg_match("#<div class=\"document-title\" itemprop=\"name\">(.+)<\/div>#iU", $html, $t))  {
		$title = trim($t[1]);
		$title = iconv('UTF-8', 'UTF-8//IGNORE', $title);
		$title = strip_tags($title);
		$title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
	}

	return $title;
}

function get_app_thumb_url($html){
	$thumb_url = "";

	if( preg_match("#<div class=\"cover-container\">(.+)<\/div>#iU", $html, $t))  {
		$img = trim($t[1]);
		$img = iconv('UTF-8', 'UTF-8//IGNORE', $img);

		preg_match('/src="([^"]+)/i',$img, $i);
		$thumb_url = str_ireplace( 'src="', '',  $i[0]);
		$thumb_url = html_entity_decode($thumb_url, ENT_QUOTES, 'UTF-8');
	}

	return $thumb_url;
}


function get_google_url()
{
    $CI =& get_instance();
    $CI->load->library('googleplus');

    $device_id = $_GET['device_id'];
    $redirect_url = $CI->input->get_post('redirect_url',true);
    if( !$redirect_url) {
        $redirect_url = current_url_with_querystring();
    }

    session_start();

    $CI->googleplus->client->setScopes('https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/plus.profile.emails.read');
    $google_login_url = $CI->googleplus->client->createAuthUrl();
    return $google_login_url;
}