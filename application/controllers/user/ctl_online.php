<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2015-10-02
* 작성자: 김종태
* 설   명: 온라인상담
*****************************************************************
* 
*/
class ctl_online extends CI_Controller {
	 
	
	 var $SUB_LAYOUT =  "@sub";
	 var $site_menu="";
	 var $PERM="";
	 var $category="";

	 function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('cookie');
		$_SESSION = $this->session->all_userdata();
		$tpl = $this->display;
	
		//메뉴 불러오기
		$this->load->model('user/menu');
		$this->site_menu = $this->menu->load_tree();
		
		$tpl->assign(array('site_menu_list'=>$this->site_menu));
		
		$this->load->library('permission');
		$this->PERM =$this->permission;

		if($_GET[cate]) {
			$_cate = $_GET[cate];
			while(strlen($_cate = substr($_cate,0,-2)) > 1) {
				$_location[] = $this->db->sqlFetchOne("SELECT str_title FROM ".tab_menu." WHERE num_oid="._OID." AND num_cate=$_cate");
			}
			$_location[] = '';
			$menu_location = implode(' > ',array_reverse($_location));
			$tpl->assign(array(
				'menu_location' => $menu_location,
			));
		$menu_title = $this->db->sqlFetchOne("SELECT str_title FROM ".tab_menu." WHERE num_oid="._OID." AND num_cate='".$_GET[cate]."'");
		$tpl->assign(array('menu_title'=>$menu_title));
		}
		
		
		
		

		$this->load->model('user/mdl_online');
		//성형카테고리 // config.php
		$this->category = $this->mdl_online->category();
		
		$this->load->library('permission');
		$this->PERM =$this->permission;
	}
	
	 
	
	  //게시판 리스트
	   function list_view($mcode=0,$page=1){
			
			$WA = $this->webapp;
			$tpl = $this->display;

			$this->PERM->apply('menu',$mcode,'r');
			$tpl->assign(array('mcode'=>$mcode));
			
			$row = $this->mdl_online->load_list($page,'15',$_GET);
			$tpl->assign(array('LIST'=>$row));

		
			
			//상단 비주얼이랑 lnb 설정
			$data[str_menu_top] = '<div class="visual_11_01"></div>';

			$tpl->assign($data);


			$tpl->setLayout('@sub');
			$tpl->define('CONTENT', $this->display->getTemplate('online/list.htm'));
			
			$tpl->printAll();

        }
	  
	//게시판 읽기
	function set_tmp_passwd($key='',$val=''){
		$this->session->set_flashdata($key, $val);
	}

	//게시판 읽기
	function item_view($mcode=0,$idx=0){
		
		$WA = $this->webapp;
		$tpl = $this->display;
		$DB = $this->db;

		
		$data = $this->mdl_online->load_view($idx);

		if($data){
			
			if(! $_SESSION[ADMIN]){
				$cookie_key = "online_pw_".$idx;
				if(!$this->session->flashdata($cookie_key)) {
					echo '<script>alert("비밀번호를 확인해주시기 바랍니다.");history.go(-1)</script>';
					exit;
				}
			}
			
			//이전글 이미지 경로 처리
			$data[comment] = str_replace('src="/images/notice/','src="/application/views/contents/images/notice/',$data[comment]);
			
			$query	= "update t_consultation set ref = ref + 1 where ind=" . $idx;
			$DB->query($query);

			$tpl->assign($data);
		

		}else{
			WebApp::moveBack('게시물이 존재하지 않습니다.');
		}

		
		$tpl->assign(array('idx'=>$idx,'mcode'=>$mcode));
					
		
		//상단 비주얼이랑 lnb 설정
		$data[str_menu_top] = '<div class="visual_11_01"></div>';
		$data[str_lnb_file] = "/application/views/contents/include/lnb_11.php";
		$tpl->assign($data);
		$tpl->define('LNB', $data[str_lnb_file]);

		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', $this->display->getTemplate('online/read.htm'));
		
		$tpl->printAll();

	}
	
	//게시판 등록
	function item_add($mcode=0,$idx=0){
		
		$WA = $this->webapp;
		$tpl = $this->display;
		$DB = $this->db;

		
		switch ($_SERVER[REQUEST_METHOD]) {
		case "GET":

            
	
			$tpl->assign(array('idx'=>$idx,'mcode'=>$mcode));
						
			if(THEME == 'mobile'){
				$tpl->setLayout('@sub');
				$tpl->define('CONTENT', $this->display->getTemplate('online/write_mobile.htm'));
			}else{
				//상단 비주얼이랑 lnb 설정
				$tpl->assign($data);
				$tpl->define('LNB', $data[str_lnb_file]);

				$tpl->setLayout('@sub');
				$tpl->define('CONTENT', $this->display->getTemplate('online/write.htm'));
			}
			
			$tpl->printAll();
		
		 break;
		case "POST":
			foreach( $_POST as $val => $value ){
				
				if(substr($val,0,3) == "db_"){
					$tmp_val = substr($val,3,255);
					$datas[$tmp_val] = $value;
				}
			} 

			$crow = $this->category;
			for($ii=0; $ii<count($crow); $ii++) {
				if($crow[$ii][section] == $datas[subject]){
					$datas[subjectext] = $crow[$ii][item];
				}
			}

            $datas[subjectext] = $_POST['db_subject'];
			$datas[title] = $datas[name]."님이 문의를 남겨주셨습니다";
			$datas[comment] = addslashes($_POST[content]);
			
			$res = $this->mdl_online->online_add($datas);
            
			echo '<script>alert("등록되었습니다.");</script>';

			if(THEME == 'mobile'){
				echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
			}else{
				echo "<meta http-equiv='Refresh' Content=\"0; URL='/user/ctl_online/item_add/".$_POST[mcode]."?cate=".$_POST[cate]."'\">";
			}
			
			
			
		 break;
		}
		
		
		

	}

	   

}

/* End of file sub.php */
/* Location: ./application/controllers/sub.php */