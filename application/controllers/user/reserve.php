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

        $time = strtotime($year.'-'.$month.'-01');
        $time2 = strtotime($year.'-'.$month.'-31');
        list($tday, $sweek) = explode('-', date('t-w', $time));  // 총 일수, 시작요일
        $tweek = ceil(($tday + $sweek) / 7);  // 총 주차from
        $lweek = date('w', strtotime($year.'-'.$month.'-'.$tday));  // 마지막요일


      


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
                $varprice_row = $this->db->where('start_date <= ',$udate)->where('end_date >= ',$udate)->get('month_prices')->row_array();
                $sda = array_pop(explode("-",$varprice_row['start_date']));
                $eda = array_pop(explode("-",$varprice_row['end_date']));

                //echo $sda." / ".$tt." / ".$eda;

                if($sda <= $tt && $eda >= $tt ){

                   // echo "<-1-"."<br>";

                    if($varprice_row['price_name'] == '성수기') $kname = "sung_price";
                    if($varprice_row['price_name'] == '준성수기' || $varprice_row['price_name'] == '준성수기2') $kname = "jun_price";

                    if($to_day_type) {
                        $kname_ = $kname."2";
                        $varprinc = $room_info[$kname_];
                    }else{
                        $varprinc = $room_info[$kname];
                    }

                    $varprincname =  $varprice_row['price_name'].$to_day_type ;


                }else{

                    //echo "<br>";
                    if($to_day_type){
                        $varprinc =  $room_info['bi_price2'] ;
                    }else{
                        $varprinc =  $room_info['bi_price'] ;
                    }

                    $varprincname =  '비수기'.$to_day_type ;
                }


                if(date('Y-m-d') == $udate){
                    $caltemp .= '<div class="ft11 m-b3" style="color:#c2c2c2">' .$varprincname.'</div><div class="day day'.$tt.'  circle danger p-t5 hand" style="width:30px;height:30px;margin: auto;" onclick="InoutInList.viewday(\''.$udate.'\');">'.$tt.'</div>';
                }else{
                    if(date('Y-m-d') <= $udate) {
                        $caltemp .= '<div class="ft11 m-b3" style="color:#c2c2c2">'.$varprincname.'</div><div class="day day'.$tt.' hand circle p-t5" style="width:30px;height:30px;margin: auto" onclick="javascript:InoutInList.viewday(\''.$udate.'\');">' . $tt . '</div>';
                    }else{
                        $caltemp .= '<div class="day " style="color:#eee">' . $tt . '</div>';
                    }
                }


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

   
    function day(){
        
        if($_GET['day'] && $_GET['room_no']){

            $site_info = $this->db->where('num_oid',_OID)->get('tab_organ')->row_array();

            $room_info = $this->db->where('no',$_GET['room_no'])->get('rooms')->row_array();
            if($room_info){
                $data['op_info'] = $this->db->where_in('no',explode(",",$room_info['options']))->get('room_options')->result_array();

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
                $room_list[$ii]['realpans'] =  $this->db->where('todate',$_GET['day'])->where('room_no',$room_list[$ii]['no'])->get('realpans')->row_array();
                if(!$room_list[$ii]['realpans'] && !$nos){
                    $room_list[$ii]['checked'] = 'checked';
                    $nos ='y';
                }
            }

            $varprice_row = $this->db->where('start_date <= ',$_GET['day'])->where('end_date >= ',$_GET['day'])->get('month_prices')->row_array();

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


            $data['this_day'] = $a[0]."년 ".$a[1]."월 ".$a[2]."일";
            $data['this_price'] = $room_info[$price_key];

            $data['this_price_name'] = $price_name;
            $data['bank'] = $site_info['STR_BANK'];
            $data['phone'] = $site_info['STR_PHONE'];

            if($_GET['toda']){
                $data['s_date'] = $_GET['day'];
                $data['e_date'] = date("Y-m-d",strtotime($_GET['day'].' +'.$_GET['toda'].' day'));
                $data['this_price'] = $data['this_price'] * $_GET['toda'];
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






}

/* End of file sub.php */
/* Location: ./application/controllers/sub.php */
