<?

$menu = array();

$cate1 = 0;

$menu[$cate1]['title'] = "홈페이지관리";
$menu[$cate1]['link'] = "/admin/site_adm/common";
$menu[$cate1]['tip'] = "홈페이지의 기본정보 관리";
$menu[$cate1]['icon'] = "glyphicon glyphicon-home";
	
	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "홈페이지 기본정보";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin/site_adm/common"; 
	$menu[$cate1]['submenu'][$cate2]['tip'] = "홈페이지의 기본정보를 입력합니다."; 
	$menu[$cate1]['submenu'][$cate2]['icon'] = "fa fa-cogs"; 
	
	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "관리자 암호관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin/site_adm/passwd";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "관리자 암호를 설정합니다.";
	$menu[$cate1]['submenu'][$cate2]['icon'] = "fa fa-lock"; 
	
	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "약관 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin/site_adm/pra";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "홈페이지 회원을 위한 약관을 작성합니다.";
	$menu[$cate1]['submenu'][$cate2]['icon'] = " glyphicon  glyphicon-list"; 
	
	/*$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "메뉴관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin/site_adm/menu";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "홈페이지의 게시판, 웹페이지등의 메뉴를 구성합니다."; 
	*/
	
	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "팝업 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin/site_adm/popup/";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "팝업를 등록하고 관리합니다."; 
	$menu[$cate1]['submenu'][$cate2]['icon'] = "glyphicon glyphicon-new-window"; 

	/*
	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "방문자 통계 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "http://www.google.co.kr/intl/ko/analytics/";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "Google 에널리틱스 접속"; 
	$menu[$cate1]['submenu'][$cate2]['target'] = "_blank"; 
	$menu[$cate1]['submenu'][$cate2]['icon'] = "fa fa-dashboard "; 
	*/
	

$cate1 = 1;
$menu[$cate1]['title'] = "회원관리";
$menu[$cate1]['link'] = "/admin/member_adm/member/g";
$menu[$cate1]['tip'] = "홈페이지회원 및 정책관리";
$menu[$cate1]['icon'] = "fa fa-users";


	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "전체보기";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin/member_adm/member/1";
	$menu[$cate1]['submenu'][$cate2]['tip'] = "가입한 회원을 관리합니다."; 
	$menu[$cate1]['submenu'][$cate2]['icon'] = "fa fa-users"; 

	/*$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "현황보기";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin/member_adm/member_state/";
	$menu[$cate1]['submenu'][$cate2]['icon'] = "fa fa-signal"; */

	
	

$cate1 = 2;
$menu[$cate1]['title'] = "컨텐츠관리";
$menu[$cate1]['link'] = "/admin/menu_adm/menu/frame";
$menu[$cate1]['icon'] = "glyphicon  glyphicon-inbox";


	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "메뉴관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin/menu_adm/menu/frame";
	$menu[$cate1]['submenu'][$cate2]['icon'] = "glyphicon glyphicon-book";



	$cate2++;
	$menu[$cate1]['submenu'][$cate2]['title'] = "게시판 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin/menu_adm/menu/board";
	$menu[$cate1]['submenu'][$cate2]['icon'] = "mdi-action-description";
	
	
		


$cate1 = 3;
$menu[$cate1]['title'] = "온라인 상담";
$menu[$cate1]['link'] = "/admin/online_adm/list_view";
$menu[$cate1]['icon'] = "glyphicon  glyphicon-phone-alt";


	
	$cate2 = 0;
	$menu[$cate1]['submenu'][$cate2]['title'] = "온라인 신청 관리";
	$menu[$cate1]['submenu'][$cate2]['link'] = "/admin/online_adm/list_view";
	$menu[$cate1]['submenu'][$cate2]['icon'] = "fa fa-list-alt";



	

	 for($ii=0; $ii<count($menu); $ii++) { 
		$iia = $ii +1;

		if(strstr($menu[$ii]['link'],"?")) {
		$menu[$ii]['pn'] ="&PageNum=0".$iia."0101";	
		}else{
		$menu[$ii]['pn'] ="?PageNum=0".$iia."0101";	
		}
		

		for($i=0; $i<count($menu[$ii]['submenu']); $i++) {
		$ia = $i +1;
			if(strstr($menu[$ii]['submenu'][$i]['link'],"?")) {
			$menu[$ii]['submenu'][$i]['pn'] ="&PageNum=0".$iia."0".$ia."01";	
			}else{
			$menu[$ii]['submenu'][$i]['pn'] ="?PageNum=0".$iia."0".$ia."01";	
			}
			
			for($iii=0; $iii<count($menu[$ii]['submenu'][$i]['submenu_sub']); $iii++) {
				$iaa = $iii +1;
				
				if(strstr($menu[$ii]['submenu'][$i]['submenu_sub'][$iii]['link'],"?")) {
				$menu[$ii]['submenu'][$i]['submenu_sub'][$iii]['pn'] ="&PageNum=0".$iia."0".$ia."0".$iaa;	
				}else{
				$menu[$ii]['submenu'][$i]['submenu_sub'][$iii]['pn'] ="?PageNum=0".$iia."0".$ia."0".$iaa;	
				}
			
			}
			

		}

	 }


	return $menu;

?>