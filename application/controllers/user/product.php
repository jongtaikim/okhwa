<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2012-03-13
* 작성자: 김종태
* 설   명: 사이트 유저 페이지
*****************************************************************
* 
*/
class product extends CI_Controller {
	


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
		$this->load->model('user/mdl_member');
		$this->site_menu = $this->menu->load_tree();
		
		$tpl->assign(array('site_menu_list'=>$this->site_menu));
		
		$this->load->library('permission');
		$this->PERM =$this->permission;
	}

    function view($seq){
    //    error_reporting(E_ALL & ~E_NOTICE);
        $WA = $this->webapp;
        $tpl = $this->display;
        $DB = $this->db;

        if(!$_SESSION[USERID]){
           // WebApp::moveBack('로그인이 필요합니다.');
            //exit;
        }

        $sql = "SELECT 카테고리  FROM `product_data` group by 카테고리 order by idx asc;";
        $row = $this->db-> sqlFetchAll($sql);

        for($ii=0; $ii<count($row); $ii++) {
            $sql = "SELECT *  FROM `product_data` where 카테고리 = '".$row[$ii]['카테고리']."' order by idx asc;";

            $row[$ii]['sub'] = $this->db-> sqlFetchAll($sql);



            for($i=0; $i<count($row[$ii]['sub']); $i++) {
            	if($row[$ii]['sub'][$i]['idx'] == $seq){
                    $category = $row[$ii]['sub'][$i]['카테고리'];
                }
            }
        }


        $tpl->assign('category',$category);

        $tpl->assign('menu_LIST',$row);
        $tpl->assign('seq',$seq);


        $sql = "select * from product_data where idx = '".$seq."'  ";
        $data = $this->db-> sqlFetch($sql);


        $tpl->assign($data);


        $tpl->setLayout('@sub');
        $tpl->define('CONTENT', $this->display->getTemplate('product/view.html'));

        $datat['menu_location'] = " > 제품소개 >  ".$data['카테고리']." > ".$data['상품명'];

        $datat['menu_title'] = "제품 상세보기";
        $tpl->assign($datat);

        $tpl->printAll();

    }


	 


}

/* End of file member.php */
/* Location: ./application/controllers/member.php */