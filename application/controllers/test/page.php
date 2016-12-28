<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2015-09-22
* 작성자: 김종태
* 설   명: 테스트페이지
*****************************************************************
* 
*/
class page extends CI_Controller {
	
	  
	 function __construct(){
		parent::__construct();
		$tpl = $this->display;
		$this->load->database('scrolling_db');
		$this->load->model('test/mdl_test');
	}
	


	  //2012-02-21 메인페이지
	   function index(){
		echo $_SERVER['REMOTE_ADDR'];
           exit;
	  }

	  

}

/* End of file sub.php */
/* Location: ./application/controllers/test/page.php */