<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
 * 작성일: 2012-03-13
 * 작성자: 김종태
 * 설   명: 사이트 유저 페이지
 *****************************************************************
 *
 */
class reserve extends CI_Controller {

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

    }


    function index(){
        $this->display->define('CONTENT', $this->display->getTemplate('/reserve/index.html'));
        $content = $this->display->fetch('CONTENT');

        echo $content;
    }

    function lists() {



        if ( $_POST['str_year'] )  $year = $_POST['str_year'] ;
        if ( $_POST['str_month'] )  $month = $_POST['str_month'] ;
        if ( $_POST['str_day'] )  $str_day = $_POST['str_day'] ;

        $time = strtotime($year.'-'.$month.'-01');
        $time2 = strtotime($year.'-'.$month.'-31');
        list($tday, $sweek) = explode('-', date('t-w', $time));  // 총 일수, 시작요일
        $tweek = ceil(($tday + $sweek) / 7);  // 총 주차from
        $lweek = date('w', strtotime($year.'-'.$month.'-'.$tday));  // 마지막요일


        $this->display->assign('str_year',$_POST['str_year']);
        $this->display->assign('str_month',$_POST['str_month']);
        $this->display->assign('str_day',$_POST['str_day']);


        $caltemp = '
		<table  border="0" cellpadding="0" cellspacing="0" class="table table-bordered"  id="date_table">
			<thead>
				<tr>
					<th class="sun  text-center">SUN</th>
					<th class=" text-center">MON</th>
					<th class=" text-center">TUE</th>
					<th class=" text-center">WED</th>
					<th class=" text-center">THU</th>
					<th class=" text-center">FRI</th>
					<th class="sat  text-center">SAT</th>
				</tr>
			</thead>
            <tbody>
		' ;
        for ($n=1,$i=0; $i<$tweek; $i++):

            $caltemp .= "<tr>" ;
            for ($k=0; $k<7; $k++):
                $to_day_type = '';
                switch (  $k ) {
                    case 6 :
                        $ncolor = "color:blue";
                        // $to_day_type = " - 주말";
                        break ;
                    case 0 :
                        $ncolor = "color:red";
                        //$to_day_type = " - 주말";
                        break ;
                    default :
                        $ncolor = "";
                        break;
                }

                $int = sprintf("%02d", $n);
                $radate = $year."-".$month."-".$int ;

//			echo $int ."<br>";
                $caltemp .=  '<td class="hand">' ;
                if (($i == 0 && $k < $sweek) || ($i == $tweek-1 && $k > $lweek)) {
                    $caltemp .=    "</td>";
                    continue;
                }



                $tt = sprintf("%02d", $n++) ;
                $udate = $year."-".$month."-".$tt ;
                $varprice_row = $this->db->where('start_date <= ',$udate)->where_in('price_name',array('성수기','준성수기','준성수기2'))->where('end_date >= ',$udate)->get('month_prices')->row_array();
                $varprice_row2 = $this->db->where('start_date <= ',$udate)->where_in('price_name',array('연휴'))->where('end_date >= ',$udate)->get('month_prices')->row_array();
                /*  echo '<xmp>';
                    echo print_r($varprice_row);
                    echo '</xmp>';*/

                $sda = array_pop(explode("-",$varprice_row['start_date']));
                $eda = array_pop(explode("-",$varprice_row['end_date']));



                if($varprice_row || $varprice_row2) {
                    // echo "<-1-"."<br>";

                    if ($varprice_row['price_name'] == '성수기') {
                        $kname = "sung_price";
                    } else if ($varprice_row['price_name'] == '준성수기' || $varprice_row['price_name'] == '준성수기2') {
                        $kname = "jun_price";
                    }

                    if ($varprice_row2['price_name'] == '연휴') {
                        $to_day_type2 = 'y';
                    }

                    if ($to_day_type || $to_day_type2) {
                        $kname_ = $kname . "2";
                        $varprinc = $room_info[$kname_];
                    } else {
                        $varprinc = $room_info[$kname];
                    }

                    if ($varprice_row['price_name']) {
                        if ($to_day_type) {
                            $varprincname = $varprice_row['price_name'] . " - " . $to_day_type;
                        } else {
                            $varprincname = $varprice_row['price_name'] . "";
                        }
                    }else if (!$varprice_row['price_name'] && $varprice_row2['price_name']) {
                        if ($to_day_type) {
                            $varprincname = $varprice_row2['price_name'] . " - " . $to_day_type;
                        } else {
                            $varprincname = $varprice_row2['price_name'] . "";
                        }
                    } else {
                        //$varprincname =  $to_day_type ;
                    }
                    $to_day_type2 = '';
                    $to_day_type = '';
                    $kname = '';
                    $kname_ = '';
                }




                if(date('Y-m-d') == $udate){
                    $caltemp .= '<div class="ft11 " style="color:#c2c2c2">' .$varprincname.'&nbsp;</div><div class="day day'.$tt.'  circle danger p-t5 hand" style="width:30px;height:30px;margin: auto;" onclick="InoutInList.viewday(\''.$udate.'\');">'.$tt.'</div>';
                }else{
                    if(date('Y-m-d') <= $udate) {
                        $caltemp .= '<div class="ft11 " style="color:#c2c2c2">'.$varprincname.'&nbsp;</div><div class="day day'.$tt.' hand circle p-t5" style="width:30px;height:30px;margin: auto" onclick="javascript:InoutInList.viewday(\''.$udate.'\');">' . $tt . '</div>';
                    }else{
                        $caltemp .= '<div class="day " style="color:#eee">' . $tt . '</div>';
                    }
                }
                $varprincname='';

                $caltemp .= '</div>';


//			$caltemp .= $row['minetime'] ."<br>". $row['maxetime']."<br>". $n++ ;

                $caltemp .=   '</td>' ;

            endfor;
            $caltemp .=   '</tr>' ;
        endfor;

        $caltemp .=   '</tbody>' ;
        $caltemp .=   '</table>' ;


        $data = array( "caltemp"=>$caltemp , "where"=>$where );

        $this->display->assign($data);

        $this->display->define('CONTENT', $this->display->getTemplate('/reserve/list.html'));
        $content = $this->display->fetch('CONTENT');

        echo $content;
    }

    function lists2() {


        $this->db->where('pay_state','N')->where('created <',date("Y-m-d H:i:s",strtotime('-720 minutes',time())))->delete('realpans');

        //당일! 3시간 지난 입금 예약 안되거 취소시켜
        $this->db->where('todate',date("Y-m-d"))->where('created >=',date("Y-m-d")." 00:00:00")->where('created <=',date("Y-m-d")." 23:59:59")->where('pay_state','N')->where('created <',date("Y-m-d H:i:s",strtotime('-180 minutes',time())))->delete('realpans');

        //http://okhwa.it-company.kr/#/user/reserve/lists2?room_cp=제이드나인
        //http://okhwa.it-company.kr/#/user/reserve/lists2?room_cp=옥화용소절경

        if ( $_GET['year'] )  $year = $_GET['year'] ;
        if ( $_GET['month'] )  $month = $_GET['month'] ;

        if(!$year) $year = date("Y");
        if(!$month) $month = date("m");

        $time = strtotime($year.'-'.$month.'-01');
        $time2 = strtotime($year.'-'.$month.'-31');
        list($tday, $sweek) = explode('-', date('t-w', $time));  // 총 일수, 시작요일
        $tweek = ceil(($tday + $sweek) / 7);  // 총 주차from
        $lweek = date('w', strtotime($year.'-'.$month.'-'.$tday));  // 마지막요일

        $this->display->assign('year',$year);
        $this->display->assign('month',$month);

        if($_GET['room_name']){
            $this->db->where('room_name',$_GET['room_name']);
        }
        if(HOST=='jade9'){
            $this->db->where('room_cp','제이드나인');
        }else{
            $this->db->where('room_cp','옥화용소절경');
        }
        $this->db->order_by('room_cp, room_name , room_number','asc');
        $room_list = $this->db->get('rooms')->result_array();

        $caltemp = '
		<table  border="0" cellpadding="0" cellspacing="0" class="table table-bordered"  id="date_table">
			<thead>
				<tr>
					<th class="sun  text-center" style="width:14.3%">일</th>
					<th class=" text-center" style="width:14.3%">월</th>
					<th class=" text-center" style="width:14.3%">화</th>
					<th class=" text-center" style="width:14.3%">수</th>
					<th class=" text-center" style="width:14.3%">목</th>
					<th class=" text-center" style="width:14.3%">금</th>
					<th class="sat  text-center" style="width:14.3%">토</th>
				</tr>
			</thead>
            <tbody>
		' ;
        for ($n=1,$i=0; $i<$tweek; $i++):

            $caltemp .= "<tr>" ;
            for ($k=0; $k<7; $k++):
                $to_day_type = '';
                $to_day_type2 = '';
                switch (  $k ) {
                    case 5 :
                        $ncolor = "color:blue";
                        $to_day_type = "주말(금)";
                        break ;
                    case 6 :
                        $ncolor = "color:red";
                        $to_day_type = "주말";
                        break ;
                    default :
                        $ncolor = "";
                        $to_day_type = '';
                        $to_day_type2 = '';
                        break;
                }

                $int = sprintf("%02d", $n);
                $radate = $year."-".$month."-".$int ;

//			echo $int ."<br>";
                $caltemp .=  '<td class="hand" valign="top" style="height:120px">' ;
                if (($i == 0 && $k < $sweek) || ($i == $tweek-1 && $k > $lweek)) {
                    $caltemp .=    "</td>";
                    continue;
                }



                $tt = sprintf("%02d", $n++) ;

                $udate = $year."-".$month."-".$tt ;


                if(HOST != 'okhwa') {
                    $room_txt = '<div class="hide date_' . $udate . ' text-center clearfix" style="overflow:auto">';


                    for ($ii = 0; $ii < count($room_list); $ii++) {
                        unset($btns);
                        $room_list[$ii]['to_realpan'] = $this->db->where('todate <=', $udate)->where('lastdate >', $udate)->where('room_no', $room_list[$ii]['no'])->get('realpans')->row_array();

                        if (!$room_list[$ii]['to_realpan']) {

                            $btns = '  <a href="#/user/reserve/index?no=' . $room_list[$ii]['no'] . '&day=' . $udate . '&str_year=' . $year . '&str_month=' . $month . '&str_day=' . $tt . '" style="text-decoration: none" class="btn btn-default btn-xs">
                                        예약가능
                                      </a><span class="hide">' . $room_list[$ii]['no'] . '</span>';

                        }else{
                            $btns = '  <a style="text-decoration: none;color:red" class="btn btn-default btn-xs" style="">
                                        예약불가
                                      </a><span class="hide">' . $room_list[$ii]['no'] . '</span>';
                        }

                        $room_txt .= '
                        
                        <div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
                            <div class="panel panel-card box-shadow2">
                                <div class="item" style="height:90px;background: url(' . $room_list[$ii]['img_url'] . ');background-size:cover ">
            
            
                                </div>
            
                                <div class="text-center">
                                    <div class="text-center p-t10">
                                        <strong class="ft12">'.$udate.'<br>' . $room_list[$ii]['room_name'] . ' ' . $room_list[$ii]['room_number'] . '</strong>
                                    </div>
                                    <div style="p-b20">
                                        
                                        <div class="m-t10 ft10 p-b15 ">
                                            ' . $btns . '
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        ';

                    }

                    if (date("Y-m-d") <= $udate) {
                        $room_txt .= "</div><div class='text-center'><a  class='btn btn-sm btn-default' href=javascript:view_day('" . $udate . "');>예약하기</a></div>";


                    } else {
                        $room_txt .= "</div>";
                    }

                }
                if(HOST == 'okhwa'){

                    $room_txt='<div>';
                    $room_txt .='<div class="hide date_'.$udate.' text-center clearfix" style="overflow:auto">';
                    $room_txt .='
                        <ul class="" style="width:100%">
                            <li class="f_l" style="width:25%">
                                <a href="#/user/reserve/index?no=13&day=' . $udate . '&str_year=' . $year . '&str_month=' . $month . '&str_day=' . $tt . '"><img src="/designs/'.HOST.'/images/sub/reserve_ban01.jpg" width="100%"></a>
                            </li>
                            <li class="f_l" style="width:25%">
                                <a href="#/user/reserve/index?no=17&day=' . $udate . '&str_year=' . $year . '&str_month=' . $month . '&str_day=' . $tt . '"><img src="/designs/'.HOST.'/images/sub/reserve_ban02.jpg" width="100%"></a>
                            </li>
                            <li class="f_l" style="width:25%">
                                <a href="#/user/reserve/index?no=25&day=' . $udate . '&str_year=' . $year . '&str_month=' . $month . '&str_day=' . $tt . '"><img src="/designs/'.HOST.'/images/sub/reserve_ban03.jpg" width="100%"></a>
                            </li>
                            <li class="f_l" style="width:25%">
                                <a href="#/user/reserve/index?no=33&day=' . $udate . '&str_year=' . $year . '&str_month=' . $month . '&str_day=' . $tt . '"><img src="/designs/'.HOST.'/images/sub/reserve_ban04.jpg" width="100%"></a>
                            </li>
                        </ul>
                </div>';

                    if (date("Y-m-d") <= $udate) {
                        $room_txt .= "</div><div class='text-center'><a  class='btn btn-sm btn-default' href=javascript:view_day('" . $udate . "');>예약하기</a></div>";
                    } else {
                        $room_txt .= "</div>";
                    }
                }
                //href="#/user/reserve/index?no=' . $room_list[$ii]['no'] . '&day=' . $udate . '&str_year=' . $year . '&str_month=' . $month . '&str_day=' . $tt . '"
                /*$room_txt = '
                ';*/

                $varprice_row = $this->db->where('start_date <= ',$udate)->where_in('price_name',array('성수기','준성수기','준성수기2'))->where('end_date >= ',$udate)->get('month_prices')->row_array();
                $varprice_row2 = $this->db->where('start_date <= ',$udate)->where_in('price_name',array('연휴'))->where('end_date >= ',$udate)->get('month_prices')->row_array();
                /*  echo '<xmp>';
                    echo print_r($varprice_row);
                    echo '</xmp>';*/

                $sda = array_pop(explode("-",$varprice_row['start_date']));
                $eda = array_pop(explode("-",$varprice_row['end_date']));



                if($varprice_row || $varprice_row2) {
                    // echo "<-1-"."<br>";

                    if ($varprice_row['price_name'] == '성수기') {
                        $kname = "sung_price";
                    } else if ($varprice_row['price_name'] == '준성수기' || $varprice_row['price_name'] == '준성수기2') {
                        $kname = "jun_price";
                    }

                    if ($varprice_row2['price_name'] == '연휴') {
                        $to_day_type2 = 'y';
                    }

                    if ($to_day_type || $to_day_type2) {
                        $kname_ = $kname . "2";
                        $varprinc = $room_info[$kname_];
                    } else {
                        $varprinc = $room_info[$kname];
                    }

                    if ($varprice_row['price_name']) {
                        if ($to_day_type) {
                            $varprincname = $varprice_row['price_name'] . " - " . $to_day_type;
                        } else {
                            $varprincname = $varprice_row['price_name'] . "";
                        }
                    }else if (!$varprice_row['price_name'] && $varprice_row2['price_name']) {
                        if ($to_day_type) {
                            $varprincname = $varprice_row2['price_name'] . " - " . $to_day_type;
                        } else {
                            $varprincname = $varprice_row2['price_name'] . "";
                        }
                    } else {
                        //$varprincname =  $to_day_type ;
                    }
                    $to_day_type2 = '';
                    $to_day_type = '';
                    $kname = '';
                    $kname_ = '';
                }




                $caltemp .= '<div class="day " >' . $tt .'일 <span style="color:#a1a1a1" class="ft11">' .$varprincname.'</span></div><div class="text-left m-t40" style="font-size:11px">'.$room_txt.'</div> ';

                $varprincname='';



//			$caltemp .= $row['minetime'] ."<br>". $row['maxetime']."<br>". $n++ ;

                $caltemp .=   '</td>' ;

            endfor;
            $caltemp .=   '</tr>' ;
        endfor;

        $caltemp .=   '</tbody>' ;
        $caltemp .=   '</table>' ;


        $data = array( "caltemp"=>$caltemp , "where"=>$where );

        $this->display->assign($data);

        $this->display->define('CONTENT', $this->display->getTemplate('/reserve/list2.html'));
        $content = $this->display->fetch('CONTENT');

        echo $content;
    }


    function get_price($udate){
        $room_no =$this->input->get_post('room_no');

        $room_info = $this->db->where('no',$room_no)->get('rooms')->row_array();

        $varprice_row = $this->db->where('start_date <= ',$udate)->where_in('price_name',array('성수기','준성수기','준성수기2'))->where('end_date >= ',$udate)->get('month_prices')->row_array();
        $varprice_row2 = $this->db->where('start_date <= ',$udate)->where_in('price_name',array('연휴'))->where('end_date >= ',$udate)->get('month_prices')->row_array();

        $sda = array_pop(explode("-",$varprice_row['start_date']));
        $eda = array_pop(explode("-",$varprice_row['end_date']));


        $kname_='bi_price';
        if($varprice_row['price_name'] == '성수기') {
            $kname_ = "sung_price";
        }else if($varprice_row['price_name'] == '준성수기' || $varprice_row['price_name'] == '준성수기2') {
            $kname_ = "jun_price";
        }

        if ($varprice_row2['price_name'] == '연휴') {
            $to_day_type2 = 'y';
        }



        if(date('w', strtotime($udate)) == 5 || date('w', strtotime($udate)) == 6 || $to_day_type2){
            $to_day_type = 'y';
        }



        if($to_day_type) {
            $kname_ = $kname_."2";
            $varprinc = $room_info[$kname_];
        }else{
            $varprinc = $room_info[$kname_];
        }


        return $varprinc;


    }

    function day(){

        if($_GET['day'] && $_GET['room_no']){

            if($_GET['day'] == date("Y-m-d")){
                $data['to_in_day'] = 'y';
            }


            //당일이 아닌경우! 6시간
            $this->db->where('pay_state','N')->where('created <',date("Y-m-d H:i:s",strtotime('-720 minutes',time())))->delete('realpans');

            //당일! 3시간 지난 입금 예약 안되거 취소시켜
            $this->db->where('todate',date("Y-m-d"))->where('created >=',date("Y-m-d")." 00:00:00")->where('created <=',date("Y-m-d")." 23:59:59")->where('pay_state','N')->where('created <',date("Y-m-d H:i:s",strtotime('-180 minutes',time())))->delete('realpans');




            $site_info = $this->db->where('num_oid',_OID)->get('tab_organ')->row_array();

            $room_info = $this->db->where('no',$_GET['room_no'])->get('rooms')->row_array();


            $data['to_realpan'] =  $this->db->where('todate <=',$_GET['day'])->where('lastdate >', $_GET['day'])->where('room_no',$_GET['room_no'])->get('realpans')->row_array();


            if($room_info){
                $data['op_info'] = $this->db->where_in('no',explode(",",$room_info['options']))->order_by('no','asc')->get('room_options')->result_array();

                if($_GET['options']){
                    $options = $_GET['options'];

                    for($ii=0; $ii<count($data['op_info']); $ii++) {
                        if(in_array($data['op_info'][$ii]['no'],$options)){

                            $data['op_info'][$ii]['checked']='checked';
                            $data['this_price3'] = $data['this_price3']+$data['op_info'][$ii]['price'];
                        }
                    }
                }

            }

            $room_list = $this->db->where('room_name',$room_info['room_name'])->order_by('room_number','asc')->get('rooms')->result_array();

            for($ii=0; $ii<count($room_list); $ii++) {
                $room_list[$ii]['realpans'] =  $this->db->where('todate <=',$_GET['day'])->where('lastdate >', $_GET['day'])->where('room_no',$room_list[$ii]['no'])->get('realpans')->row_array();
                /*if(!$room_list[$ii]['realpans'] && !$nos){
                    $room_list[$ii]['checked'] = 'checked';
                    $nos ='y';
                }*/
                if($_GET['room_no'] == $room_list[$ii]['no']){
                    $room_list[$ii]['checked'] = 'checked';
                    $nos ='y';
                }
            }

            $varprice_row = $this->db->where('start_date <= ',$_GET['day'])->where_in('price_name',array('성수기','준성수기','준성수기2'))->where('end_date >= ',$_GET['day'])->get('month_prices')->row_array();
            $varprice_row2 = $this->db->where('start_date <= ',$_GET['day'])->where_in('price_name',array('연휴'))->where('end_date >= ',$_GET['day'])->get('month_prices')->row_array();

            $a = explode("-",$_GET['day']);

            $price_key='bi_price';
            $price_name='비수기';
            if($varprice_row){

                if($varprice_row['price_name'] =="성수기" || $varprice_row['price_name'] =="성수기2"){
                    $price_key='sung_price';
                    $price_name=$varprice_row['price_name'];
                }
                if($varprice_row['price_name'] =="준성수기" || $varprice_row['price_name'] =="준성수기2") {
                    $price_key='jun_price';
                    $price_name=$varprice_row['price_name'];
                }

            }



            $week = date("w",strtotime($_GET['day']));
            if($week =="5" ){
                $data['day_type'] ='주말(금)';
                $price_key = $price_key."2";
            }else if($week == "6"){
                $data['day_type'] ='주말';
                $price_key = $price_key."2";
            }else{
                $data['day_type'] ='주중';
            }

            if ($varprice_row2['price_name'] == '연휴') {
                if($varprice_row['price_name']){
                    $price_name = $varprice_row['price_name']." 연휴";
                }else{
                    $price_name = "연휴";
                }

                $data['day_type']='';
            }


            $data['this_day'] = $a[0]."년 ".$a[1]."월 ".$a[2]."일";
            $data['this_price'] = $room_info[$price_key];

            $data['this_price_name'] = $price_name;
            $data['bank'] = $site_info['STR_BANK'];
            $data['phone'] = $site_info['STR_PHONE'];
            $data['pickup'] = $site_info['STR_PICKUP'];
            $data['str_text'] = $site_info['STR_TEXT'];
            $data['str_text2'] = $site_info['STR_TEXT2'];
            $data['str_text3'] = $site_info['STR_TEXT3'];

            if($_GET['toda']){
                $data['s_date'] = $_GET['day'];
                $data['e_date'] = date("Y-m-d",strtotime($_GET['day'].' +'.$_GET['toda'].' day'));
                // $data['this_price'] = $data['this_price'] * $_GET['toda'];
                $data['this_price'] = '';


                for($ii=0; $ii<$_GET['toda']; $ii++) {
                    $to_date =  date("Y-m-d",strtotime($_GET['day'].' +'.$ii.' day'));
                    $data['this_price'] = $data['this_price']+$this->get_price($to_date);

                }



            }

            $data['this_price1'] = $data['this_price'];

            $add_human = $_GET['seongin_val']+$_GET['adong_val']+$_GET['yua_val'];


            if ($add_human > $room_info['human_max']){
                $data['max_hum_to'] = 'y';

                unset($_GET['seongin_val']);
                unset($_GET['adong_val']);
                unset($_GET['yua_val']);

                echo '<script>alert("최대 추가인원을 초과했습니다.\n(최대 '.$room_info['human_max'].'명 / '.$add_human.'명 선택)");</script>';

            }else {

                if($add_human > $room_info['human_min'] ) {

                    if ($_GET['seongin_val']) {
                        $data['this_price2'] =  ($room_info['add_human_price'] * ($_GET['seongin_val']-$room_info['human_min']));
                    }else{
                        unset($_GET['seongin_val']);
                        unset($_GET['adong_val']);
                        unset($_GET['yua_val']);
                        echo '<script>alert("성인 인원 없이 예약 불가합니다.");</script>';
                    }
                    if ($_GET['adong_val']) {
                        $data['this_price2'] = ($room_info['add_human_price2'] * $_GET['adong_val']);
                    }
                    if ($_GET['yua_val']) {
                        $data['this_price2'] = ($room_info['add_human_price3'] * $_GET['yua_val']);
                    }
                }
            }



            $data['this_price'] = $data['this_price']+$data['this_price2']+$data['this_price3'];


            $this->display->assign($data);
            $this->display->assign('rooms',$room_list);

            $this->display->assign('room_info',$room_info);
            $this->display->assign('varprice_row',$varprice_row);

        }

        $this->display->assign($data);
        if($_GET['mode']) {
            $this->display->define('CONTENT', $this->display->getTemplate('/reserve/day_'.$_GET['mode'].'.html'));
        }else {
            $this->display->define('CONTENT', $this->display->getTemplate('/reserve/day.html'));
        }
        $content = $this->display->fetch('CONTENT');

        echo $content;
    }



    function reserve_cp(){


        $tcode = 'PEN'.date('His').str_pad(mt_rand(0,99),2,'0').str_pad(mt_rand(0,9999999),7,'0');

        if($_POST['options']){

            $op_info = $this->db->where_in('no',$_POST['options'])->order_by('text','asc')->get('room_options')->result_array();

            for($ii=0; $ii<count($op_info); $ii++) {
                $opname .= $op_info[$ii]['name']." + ".$op_info[$ii]['price']."원 ,";
            }
            $opname = substr($opname,0,strlen($opname)-1);
        }

        // 날짜리스트가 들어 있는 배열을 출력한다.
        $dayLists = $this->dateweeks ( $_POST['s_date'] , $_POST['e_date'] ) ;

        $chk_re = $this->db->where_in('todate',$dayLists)->where('room_no',$_POST['room_no'])->get('realpans')->result_array();
        if($chk_re){
            $this->_send_json('', 501, '이미 예약이 되어있는 날짜가 포함되어있습니다.');
        }else{

            if(!$_POST['pickup']) $_POST['pickup'] = 'N';

            for($ii=0; $ii<count($dayLists); $ii++) {
                $in_data['code'] = $tcode;
                $in_data['room_no'] = $_POST['room_no'];
                $in_data['room_cp'] = $_POST['room_cp'];
                $in_data['room_name'] = $_POST['room_name'];
                $in_data['room_number'] = $_POST['room_number'];
                $in_data['startdate'] = $_POST['s_date'];
                $in_data['todate'] = $dayLists[$ii];
                $in_data['lastdate'] = $_POST['e_date'];
                $in_data['name'] = $_POST['name'];
                $in_data['phone'] = $_POST['phone'];
                $in_data['ptime'] = $_POST['ptime'];
                $in_data['pickup'] = $_POST['pickup'];
                $in_data['area'] = $_POST['area'];
                $in_data['memo'] = $_POST['memo'];
                $in_data['price_name'] = $_POST['price_name'];
                $in_data['totalprice'] = $_POST['totalprice']+0;
                $in_data['price1'] = $_POST['price1']+0;
                $in_data['price2'] = $_POST['price2']+0;
                $in_data['price3'] = $_POST['price3']+0;
                $in_data['seongin_val'] = $_POST['seongin_val'];
                $in_data['adong_val'] = $_POST['adong_val'];
                $in_data['yua_val'] = $_POST['yua_val'];
                $in_data['pay_type'] = $_POST['pay_type'];
                $in_data['bankname'] = $_POST['bankname'];
                $in_data['options'] = $opname;
                $in_data['created'] = date("y-m-d H:i:s");

                $this->db->insert('realpans',$in_data);





            }
            $oinfo = $this->db->get('tab_organ')->row_array();
            if($oinfo['STR_EMAIL']) {
                $email = $oinfo['STR_EMAIL'];
            }else{
                $email = $oinfo['str_email'];
            }
            /*


                        $this->load->library('email');
                        $this->email->from('noreply@it-compay.kr','펜션관리자');
                        $this->email->to($email);

                        $this->email->subject('신규예약이 들어왔습니다. - '.$in_data['name'] );
            */

            $msg_text .= '['.$in_data['room_cp'].'] 신규예약이 들어왔습니다.
            
';
            $msg_text .= "예약정보 : ".$in_data['room_cp']." ".$in_data['room_name']." ".$in_data['room_number']."
";
            $msg_text .= "예약자 : ".$in_data['name']."
";
            $msg_text .= "날짜 : ".$in_data['startdate']."~".$in_data['lastdate']."
";

            $msg_text .= "입금예정자 : ".$in_data['bankname']."

";
            $msg_text .= "관리자 : http://resortstay.co.kr/adm#admin/realpans/index/";

            /*   $this->email->message($msg_text);

               $this->email->send();*/

            /*$bot_info = json_decode(file_get_contents('https://api.telegram.org/bot314765110:AAG09gfr4x1ephvZHoEbqwtRKask0OP6M0k/getUpdates'),true);
            for($ii=0; $ii<count($bot_info['result']); $ii++) {

            }*/
            $ch = curl_init();
            $urls = 'https://api.telegram.org/bot314765110:AAG09gfr4x1ephvZHoEbqwtRKask0OP6M0k/sendmessage?chat_id=-215602523&text='.urlencode($msg_text);
            curl_setopt($ch, CURLOPT_URL, $urls);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            ob_start();      // prevent any output
            $res = curl_exec ($ch); // execute the curl command

            ob_end_clean();  // stop preventing output
            curl_close($ch);


            $this->_send_json('', 200, '예약이 완료되었습니다.');
        }
    }


    function email_test(){

        $oinfo = $this->db->get('tab_organ')->row_array();
        if($oinfo['STR_EMAIL']) {
            $email = $oinfo['STR_EMAIL'];
        }else{
            $email = $oinfo['str_email'];
        }

        echo $email;


        $this->load->library('email');


        $this->email->from('noreply@it-compay.kr','펜션관리자');
        $this->email->to($email);

        $this->email->subject('신규예약이 들어왔습니다. - '.$in_data['name'] );


        $msg_text .= "예약자 : ".$in_data['name']."
";
        $msg_text .= "날짜 : ".$in_data['startdate']."~".$in_data['lastdate']."
";
        $msg_text .= "예약정보 : ".$in_data['room_cp']." ".$in_data['room_name']." ".$in_data['room_number']."
";
        $msg_text .= "입금예정자 : ".$in_data['bankname']."
";


        $this->email->message($msg_text);

        $this->email->send();

        echo $this->email->print_debugger();

    }

    function dateweeks( $srt_date , $end_date ) {

        // 하루에 타임 스테프 값을 선언한다.
        $oneDayTimeStamp = 86400;


        // 담을 배열을 선언한다.
        $dayList = array();

        // for문을 돌려 체크 하고 조건에 충족하면 배열에 돌린다.
        for ( $i = 0 ; strtotime($srt_date)+($oneDayTimeStamp*$i) < strtotime($end_date) ; $i++){
            $yyyyMMdd = date("Y-m-d",strtotime($srt_date)+($oneDayTimeStamp*$i));
            array_push($dayList, $yyyyMMdd);
        }

        return $dayList ;
    }

    public function _send_json($result = null, $code = 200, $message = null) {
        @header( "Content-type: application/json" );
        echo json_encode(array('code' => $code, 'message' => $message, 'result'=>$result));
        exit;
    }


    public function chk(){

        if(HOST=='jade9'){
            $this->db->where('room_cp','제이드나인');
        }else{
            $this->db->where('room_cp','옥화용소절경');
        }
        $data =  $this->db->where('name',$_POST['name'])->where('phone',$_POST['phone'])->get('realpans')->row_array();

        if($data) {
            $img_url =  $this->db->select(' img_url ')->where('no',$data['room_no'])->get('rooms')->row_array();
            $data['img_url'] =  $img_url['img_url'];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('code' => '200', 'result' => $data)));
        }else{
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('code' => '201', 'result' => '','message' => '예약건이 없습니다.')));
        }
    }



}

/* End of file sub.php */
/* Location: ./application/controllers/sub.php */
