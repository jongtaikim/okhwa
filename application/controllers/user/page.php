<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2012-03-13
* 작성자: 김종태
* 설   명: 사이트 유저 페이지
*****************************************************************
*
*/
class page extends CI_Controller {



	 var $SUB_LAYOUT =  "@sub";
	 var $site_menu="";
	 var $PERM="";

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
        
        //메뉴
        $this->display->assign('HOST',HOST);
        $menu = $this->webapp->get('user_menu_'.HOST);
        $this->display->assign('site_menu',$menu);


	}


 
	  //2012-02-21 메인페이지
	   function index(){
		$WA = $this->webapp;
		$tpl = $this->display;
		$this->db =  $this->db;

		$this->load->library('iniconf');
		$this->load->helper('file');


		$site_data = @parse_ini_file(_DOC_ROOT.'/application/config/'.THEME.'/site_config.php',true);

		$tpl->assign(array(
			'popup_start'=>$site_data[popup_start],
			'popup_end'=>$site_data[popup_end],
			'popup_use'=>$site_data[popup_use],
		 ));


		if($site_data[popup_start] <= date("Y-m-d") && $site_data[popup_end] >= date("Y-m-d")){

			 if(is_file(_DOC_ROOT.'/data/docs/popup.html')){
				$contents = read_file(_DOC_ROOT.'/data/docs/popup.html');
			 }else{
				$contents ="";
			 }
			$sect = "popup/popup";
			$tpl->assign(array(
				'popup_contents'=>$contents,
				'sect'=>$sect,
			 ));
		}



        if(HOST !='jade9' && HOST !='okhwa'){


            $tpl->setLayout('@intro');
            $tpl->define('CONTENT', $this->display->getTemplate('/user_page/blank.htm'));

            $content = $this->display->fetch('LAYOUT');

            echo$content;

        }else{
            $tpl->setLayout('@main');
            $tpl->define('CONTENT', $this->display->getTemplate('/user_page/blank.htm'));

            $content = $this->display->fetch('LAYOUT');

            echo$content;
        }


	  }

    function main(){
       /* $sql = "select * from tab_board where num_mcode = '1315' order by dt_date desc limit 5  ";
        $row = $this->db -> sqlFetchAll($sql);
        $tpl->assign(array('gong_LIST'=>$row));*/

        $this->display->define('CONTENT', $this->display->getTemplate('/'.HOST.'/main.htm'));
        $content = $this->display->fetch('CONTENT');

        echo $content;

    }

    function p(){

        if($_GET['designs'] && $_GET['p']) {
            $this->display->define('CONTENT', $this->display->getTemplate('/'.$_GET['designs'].'/'.$_GET['p'].".html"));


            if(substr($_GET['p'],0,6) == 'room_a'){
                $tab_file='a_room_tab.html';
            }
            if(substr($_GET['p'],0,6) == 'room_b'){
                $tab_file='b_room_tab.html';
            }
            if(substr($_GET['p'],0,6) == 'room_c'){
                $tab_file='c_room_tab.html';
            }

            if($tab_file) {
                $this->display->define('room_tab', $this->display->getTemplate('/' . $_GET['designs'] . '/' . $tab_file));
                $room_tab = $this->display->fetch('room_tab');
                $room_tab = str_replace('/application/views/', '/designs/', $room_tab);
                $this->display->assign('room_tab', $room_tab);
            }


            $content = $this->display->fetch('CONTENT');
    

            $content = str_replace('/application/views/','/designs/',$content);
            echo $content;
        }else{
            show_404('page');
        }

    }

	/**
	 *
	 * 404 처리
	 * @return	object	$mcode
	 * @return	void
	 */

	function go404(){
		if(ENVIRONMENT == "development"){
			show_404('page');
		}else{
			echo "<meta http-equiv='Refresh' Content=\"0; URL='/'\">";
			exit;
		}
	}

	/**
	 *
	 * 웹페이지 출력
	 * @return	object	$mcode
	 * @return	void
	 */

	   function doc($mcode=''){
		$WA = $this->webapp;
		$tpl = $this->display;
		$this->db =  $this->db;

		if($mcode){

			if($_SERVER[HTTP_HOST] == "hospi.it-company.kr" || $_SERVER[HTTP_HOST] == "hospi.co,kr"){
				if($mcode=="1410"){
					echo "<meta http-equiv='Refresh' Content=\"0; URL='/user/ctl_online/list_view/1410?cate=1410&db_title=s1'\">";
					exit;
				}

				if($mcode=="1411"){
					echo "<meta http-equiv='Refresh' Content=\"0; URL='/user/ctl_online/list_view/1411?cate=1411&db_title=s2'\">";
					exit;
				}

				if($mcode=="1413"){
					echo "<meta http-equiv='Refresh' Content=\"0; URL='/user/ctl_online/list_view/1413?cate=1413&db_title=s4'\">";
					exit;
				}
			}

			//메뉴데이터
			$data = $this->menu->load_menu_data($mcode);

			$this->PERM->apply('menu',$mcode,'r');

			$data[mcode] = $mcode;
			$tpl->assign($data);

			if(!$data[str_layout]) $data[str_layout] = "@sub";
			$tpl->setLayout($data[str_layout]);


			if($_SESSION[ADMIN]){
				$edit_btn = '<div class="" style="margin:30px auto;width:100px"><a href="/admin/menu_adm/menu_docs/'.$mcode.'?cate='.$_GET[cate].'" class="btn btn-sm  btn-info  m-r10">웹페이지 편집</a></div>';
				$tpl->assign(array('edit_btn'=>$edit_btn));
			}

			$tpl->printAll();



			}else{
				$this->go404();
			}

	  }


	  /**
	 *
	 * 빈메뉴 하위 첫번째 메뉴로 이동
	 * @return	object	$mcode
	 * @return	void
	 */
	  function blank_menu($mcode){
		 if($mcode){
			//메뉴데이터
			$data = $this->menu->load_menu_data_sub($_GET[cate]);
			if($data[menu_url]){
				echo "<meta http-equiv='Refresh' Content=\"0; URL='".$data[menu_url]."'\">";
				exit;
			}else{
				$this->go404();
			}
		 }else{
			$this->go404();
		 }
	  }





	 function sitemap_view(){
		$tpl = $this->display;
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', $this->display->getTemplate(THEME.'/sitemap.htm'));
		$tpl->printAll();
	}


	 function introduce($type='policy'){
		$tpl = $this->display;
		$tpl->setLayout('@sub');

		$tpl->assign(array('type'=>$type));

		$tpl->define('CONTENT', $this->display->getTemplate(THEME.'/introduce.htm'));
		$tpl->printAll();
	}

	 function consult(){
		$tpl = $this->display;
		$tpl->setLayout('@sub');

		$tpl->assign(array('type'=>$type));

		$tpl->define('CONTENT', $this->display->getTemplate(THEME.'/consult.htm'));
		$tpl->printAll();
	}








}

/* End of file sub.php */
/* Location: ./application/controllers/sub.php */
