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
		<table  border="0" cellpadding="0" cellspacing="0" class="table table-bordered"  >
			<thead>
				<tr>
					<th class="sun w100 text-center">SUN</th>
					<th class="w100 text-center">MON</th>
					<th class="w100 text-center">TUE</th>
					<th class="w100 text-center">WED</th>
					<th class="w100 text-center">THU</th>
					<th class="w100 text-center">FRI</th>
					<th class="sat w100 text-center">SAT</th>
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
                $caltemp .=  '<td>' ;
                if (($i == 0 && $k < $sweek) || ($i == $tweek-1 && $k > $lweek)) {
                    $caltemp .=    "</td>";
                    continue;
                }

                $tt = sprintf("%02d", $n++) ;
                $udate = $year."-".$month."-".$tt ;
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



                $caltemp .= '<div class="day">'.$tt.'</div>';
                $caltemp .= '<div>' . $varprincname .'<br>';
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

            $room_info = $this->db->where('no',$_GET['room_no'])->get('rooms')->row_array();

            $room_list = $this->db->where('room_name',$room_info['room_name'])->get('rooms')->result_array();

            for($ii=0; $ii<count($room_list); $ii++) {
                $room_list[$ii]['realpans'] =  $this->db->where('todate',$_GET['day'])->where('room_no',$room_list[$ii]['no'])->get('realpans')->row_array();
            }

            $varprice_row = $this->db->where('start_date >= ',$_GET['day'])->where('end_date <= ',$_GET['day'])->get('month_prices')->row_array();
            $a = explode("-",$_GET['day']);

            $week = date("w",strtotime($_GET['day']));
            if($week =="0" || $week == "6"){
                $data['day_type'] ='주말';
            }else{
                $data['day_type'] ='주중';
            }

            $data['this_day'] = $a[0]."년 ".$a[1]."월 ".$a[2]."일";

            $this->display->assign($data);
            $this->display->assign('rooms',$room_list);

            $this->display->assign('room_info',$room_info);
            $this->display->assign('varprice_row',$varprice_row);

        }
        
        $this->display->assign($data);

        $this->display->define('CONTENT', $this->display->getTemplate('/reserve/day.html'));
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
