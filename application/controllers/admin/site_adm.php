<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2012-02-18 
* 작성자: 김종태
* 설   명: 관리자모드 컨트로롤러
*****************************************************************
* 
*/
class Site_adm extends CI_Controller {
	  
	
	
	 var $FILES_TABLE =  "tab_files";
	 var $ORGAN_TABLE =  "tab_organ";
	
	 var $main_layout =  "admin_main";
	 var $sub_layout =  "admin_sub";

 
	function __construct()
	{
		parent::__construct();
		$_SESSION = $this->session->all_userdata();

		

		$this->load->database();
		//관리자 공통 모델
		$this->load->model('admin/admin_init');
	}
	

	/**
	 * 관리자 로그인
	 *
	 * @param	string	$userid	로그인 아이디
	 * @param	string	password	로그인 암호
	 */	

	function login(){
		
		$tpl = $this->display;
		
		
		switch ($_SERVER[REQUEST_METHOD]) {
		case "GET":
		
	
		$tpl->setLayout($this->main_layout);
		$tpl->define("CONTENT", $this->display->getTemplate("admin/login.htm"));
		
		$tpl->printAll();

		 break;
		case "POST":
		
		
		if(strstr($_POST[userid], "--") || strstr($_POST[userid], "1=1") || strstr($_POST[password], "--") || strstr($_POST[password], "1=1")){
			$this->webapp->moveBack('잘못된 아이디로 로그인을 시도 하였습니다.');
		}
		


		if(($_POST[userid] == _ADMIN_ID && md5($_POST[password]) == _ADMIN_PW) ){
			
			$member_type = $this->config->item('member_type');
			
			
			$site_data = @parse_ini_file(_DOC_ROOT.'/site_conf/'.THEME.'/conf/site_config.php',true);
			
			$this->session->set_userdata('ADMIN', TRUE);
			$this->session->set_userdata('NAME', $site_data[admin_name]);
			$this->session->set_userdata('EMAIL', $site_data[email]);
			$this->session->set_userdata('USERID', _ADMIN_ID);
			$this->session->set_userdata('PASSWORD', _ADMIN_PW);
			$this->session->set_userdata('MTYPE_NAME',$member_type['z']);
			$this->session->set_userdata('MTYPE', "z");
			$this->session->set_userdata('MEM_TYPE', array('z'));
			$this->session->set_userdata('AUTH', TRUE);
			$this->session->set_userdata('REMOTE_ADDR', getenv('REMOTE_ADDR'));

			$this->webapp->redirect('/adm');

		}else{
			$this->webapp->moveBack('관리자계정이 일치하지 않습니다.');
		}

		 break;
		} 
	}
	
	/**
	 * 관리자 로그아웃
	 *
	 */	
	function logout(){
		$this->session->sess_destroy();
		$this->webapp->redirect('/main');
	}
	
	/**
	 * 관리자 메인 화면
	 *
	 * @return	object	member_count	전체회원수	
	 */	
	
	function Main(){
		$tpl = $this->display;
		$tpl->setLayout($this->sub_layout);
        $tpl->define("CONTENT", $this->display->getTemplate("admin/blank.html"));
        $tpl->printAll();
	}

    function admin_main(){

        //관리자용 회원 모델
        $this->load->model('admin/member');
        $this->load->model('user/mdl_online');

        $tpl = $this->display;
        $tpl->setLayout('none');

        $main_menu = array(
            array(
                'col'=>'col-sm-3',
                'title'=>'홈페이지관리',
                'title_color'=>'',
                'img'=>'/application/views/admin/images/adm_menu1.jpg',
                'icon'=>'<i class="fa fa-cogs"></i>',
                'text'=>'사이트에 각종 약관 및 관리자 정보, 상단 타이틀, 팝업등 홈페이지를 관리하기 위한 기능입니다.',
                'link'=>'#admin/site_adm/common/?PageNum=010101',
                'btn_color'=>'brown',
            ),
            array(
                'col'=>'col-sm-3',
                'title'=>'가격정책설정',
                'title_color'=>'#fff',
                'img'=>'/application/views/admin/images/adm_menu2.jpg',
                'icon'=>'<i class="fa fa-credit-card" aria-hidden="true"></i>',
                'text'=>'펜션 신청을 받기위한  월별, 일별 가격정책을 설정,관리합니다.',
                'link'=>'#admin/month_price/index/?PageNum=030101',
                'btn_color'=>'bg-white',
                'btn_text_color'=>'#000',
            ),

            array(
                'col'=>'col-sm-3',
                'title'=>'부대시설관리',
                'title_color'=>'#fff',
                'img'=>'/application/views/admin/images/adm_menu3.jpg',
                'icon'=>'<i class="fa fa-shopping-basket" aria-hidden="true"></i>',
                'text'=>'펜션 부대시설 정보를 등록/관리합니다.',
                'link'=>'#admin/room_option/index/?PageNum=030301',
                'btn_color'=>'indigo',
                'btn_text_color'=>'',
            ),

            array(
                'col'=>'col-sm-3',
                'title'=>'예약관리',
                'title_color'=>'#fff',
                'img'=>'/application/views/admin/images/adm_menu6.jpg',
                'icon'=>'<i class="fa fa-calendar-check-o" aria-hidden="true"></i>',
                'text'=>'예약현황을 확인하거나 입금확인 처리를 관리합니다.',
                'link'=>'#admin/realpans/view_cl/',
                'btn_color'=>'pink',
                'btn_text_color'=>'',
            ),
          /*  array(
                'col'=>'col-sm-3',
                'title'=>'1:1문의',
                'title_color'=>'#fff',
                'img'=>'/application/views/admin/images/adm_menu5.jpg',
                'icon'=>'<i class="fa fa-shopping-basket" aria-hidden="true"></i>',
                'text'=>'사이트를 통해 들어온 문의를 관리합니다.',
                'link'=>'#/admin/online_adm/list_view',
                'btn_color'=>'pink',
                'btn_text_color'=>'',
            ),*/
        );

        $this->display->assign('LIST',$main_menu);

        //오늘 날짜 출력 ex) 2013-04-10
        $today_date = date('Y-m-d');
        //오늘의 요일 출력 ex) 수요일 = 3
        $day_of_the_week = date('w');
        //오늘의 첫째주인 날짜 출력 ex) 2013-04-07 (일요일임)
        $a_week_ago = date('Y-m-d', strtotime($date." -".$day_of_the_week."days"));
        $e_week_ago = date('Y-m-d', strtotime($a_week_ago." +6days"));

        $this->display->assign('a_week_ago',$a_week_ago);
        $this->display->assign('e_week_ago',$e_week_ago);


        $t_data = $this->db->select('img_url, room_cp, room_name,  count(*) as cu ')->group_by("room_name")->from('rooms')->order_by('room_cp, room_name','asc')->get()->result_array();
        for($ii=0; $ii<count($t_data); $ii++) {
            $t_data[$ii]['to_realpan']  = $this->db->set('name')->where('todate >=',$a_week_ago)->where('todate <=',$e_week_ago)->where('room_name',$t_data[$ii]['room_name'])->group_by('name')->get('realpans')->result_array();

            $to_total = $to_total + count($t_data[$ii]['to_realpan']);

        }
        $this->display->assign('t_data',$t_data);
        $this->display->assign('to_total',$to_total);

        $tpl->define("CONTENT", $this->display->getTemplate("admin/main.htm"));
        $tpl->printAll();
    }

	/**
	 * 사이트 기본 정보 관리
	 *
	 * @return	void
	 */	
	
	function common(){
		$tpl = $this->display;
		$DB = $this->db;
		$this->load->model('admin/common');
		switch ($_SERVER[REQUEST_METHOD]) {
		case "GET":
		
		//데이터 불러오기
		$data = $this->common->load_data();
		$tpl->assign($data);
	
		$tpl->setLayout('none');
		$tpl->define("CONTENT", $this->display->getTemplate("admin/common.htm"));
		
		$tpl->printAll();

		 break;
		case "POST":

		$this->common->save_data($_POST);
        echo json_encode(array('code' => '200', 'message' => '저장되었습니다.', 'result'=>$result));
        exit;

	
		
		 break;
		} 
	}
    
    

	/**
	 * 관리자 암호 변경
	 *
	 * @return	void
	 */	
	
	function passwd(){
		$tpl = $this->display;
		$DB = $this->db;
		$this->load->model('admin/common');

		switch ($_SERVER[REQUEST_METHOD]) {
		case "GET":

        $tpl->setLayout('none');
		$tpl->define("CONTENT", $this->display->getTemplate("admin/passwd.htm"));
		
		$tpl->printAll();

		 break;
		case "POST":

		if($this->common->change_admin_passwd($_POST) == "Y"){
            $msg ='암호가 변경되었습니다.';
		}else{
			$msg ='기존 암호가 일치하지 않습니다.';
		}
            echo json_encode(array('code' => '200', 'message' =>$msg, 'result'=>$result));
            exit;
		 break;
		} 
	}


	/**
	 * 이용약관 관리
	 *
	 * @param	string	$mode	pra1:사이트이용약관 , pra2 : 개인보호정책
	 * @return	void
	 */	
	
	function pra(){
		$tpl = $this->display;
		$DB = $this->db;

		$this->load->model('/admin/pra');

       if(!$_GET['mode']) $mode="str_text"; else $mode=$_GET['mode'];

		switch ($_SERVER[REQUEST_METHOD]) {
		case "GET":
		
		//약관내용 불러오기
		$tpl->assign($this->pra->load_text());
		$tpl->assign(array('mode'=>$mode));

        $tpl->setLayout('none');
		$tpl->define("CONTENT", $this->display->getTemplate("admin/pra.htm"));
		
		$tpl->printAll();

		 break;
		case "POST":
		

		$this->pra->save_text($_POST);
        echo json_encode(array('code' => '200', 'message' => '저장되었습니다.', 'result'=>$result));
        exit;

		 break;
		} 
	}


	
	
	function popup($mcode=""){
		$tpl = $this->display;
		$DB = $this->db;
		
		$this->load->library('iniconf');
		$this->load->helper('file');

		switch ($_SERVER[REQUEST_METHOD]) {
		case "GET":
		
		
		$site_data = @parse_ini_file(_DOC_ROOT.'/application/config/'.THEME.'/site_config.php',true);
		if(!$site_data[popup_start]) $site_data[popup_start] = date("Y-m-d");
		if(!$site_data[popup_end]) $site_data[popup_end] = date("Y-m-d",mktime() + (86400 *30));
		$tpl->assign(array(
			'popup_start'=>$site_data[popup_start],
			'popup_end'=>$site_data[popup_end],
			'popup_use'=>$site_data[popup_use],
		 ));
		
		

		 if(is_file(_DOC_ROOT.'/data/docs/popup.html')){
			$contents = read_file(_DOC_ROOT.'/data/docs/popup.html');
		 }else{
			$contents ="";

		 }
		$sect = "popup/popup";
		$tpl->assign(array(
			'contents'=>$contents,
			'sect'=>$sect,
		 ));


            $tpl->setLayout('none');
		 $tpl->define("CONTENT", $this->display->getTemplate("admin/popup.htm"));
		 $tpl->printAll();
		
		 break;
		case "POST":
		
		$data[str_text] = $_POST[contents];
		
		$s = preg_match_all("/<img\s+.*?src=[\"\']([^\"\']+)[\"\'\s][^>]*>/is", $data[str_text], $m); 
		$tmp_img_list = $m[1];


		for($ii=0; $ii<count($tmp_img_list); $ii++) {
			if(!strstr($tmp_img_list[$ii],$_SERVER[HTTP_HOST]) && strstr($tmp_img_list[$ii],'http://')){
				$tmp_img = $this->curl->curl_url($tmp_img_list[$ii]);
				$filename = md5(array_pop(explode("/",$tmp_img_list[$ii]))).".gif";
					
				$s = fopen('data/files/popup_'.$filename, "w");
				fwrite($s, $tmp_img);
				fclose($s);

				$data[str_text] = str_replace($tmp_img_list[$ii],'/data/files/popup_'.$filename,$data[str_text]);
				
			}
		}
		
		
		
		write_file(_DOC_ROOT.'/data/docs/popup.html', $data[str_text]);
		
		$this->webapp->daumEditUpload($_POST[attach_img_file],"image");
		$this->webapp->daumEditUpload($_POST[attach_file],"file"); 
		
		
			
			$this->iniconf->load(_DOC_ROOT.'/application/config/'.THEME."/site_config.php");
			$this->iniconf->setVar("popup_start",$_POST[popup_start]);
			$this->iniconf->setVar("popup_end",$_POST[popup_end]);
			$this->iniconf->setVar("popup_use",$_POST[popup_use]);
			
			write_file(_DOC_ROOT.'/application/config/'.THEME."/site_config.php", $this->iniconf->_combine());

			$this->webapp->redirect('/admin/site_adm/popup/?PageNum='.$_POST[PageNum]);
		 
		 break;
		}
	}





	
}//

/* End of file .site_adm.php */
/* Location: ./application/controllers/site_adm.php */
