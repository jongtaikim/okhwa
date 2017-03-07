<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Benchmark $benchmark
 * @property CI_Calendar $calendar
 * @property CI_Cart $cart
 * @property CI_Config $config
 * @property CI_Controller $controller
 * @property CI_Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Exceptions $exceptions
 * @property CI_Form_validation $form_validation
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Input $input
 * @property CI_Language $language
 * @property CI_Loader $load
 * @property CI_Log $log
 * @property CI_Model $model
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Profiler $profiler
 * @property CI_Router $router
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Typography $typography
 * @property CI_Unit_test $unit_test
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $user_agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Xmlrpcs $xmlrpcs
 * @property CI_Zip $zip
 *
 * Add additional libraries you wish
 * to use in your controllers here
 *
 * @property Accounts_model $Accounts_model
 * @property auth $auth
 *
 */
require_once 'scaffolder.php';

class Realpans extends Scaffolder
{
    var $current_user;
    var $table_tn = "realpans";
    var $db_id = "admin/realpans";
    var $db_name = "예약";

    public function __construct()
    {
        parent::__construct();
    }

    public function _init()
    {
        $this->data['schema']['id'] = $this->db_id;
        $this->data['schema']['name'] = $this->db_name;

        $this->data['top_text'] = "예약현황을 관리합니다.";

        $this->data['one_page'] = true;
        $this->data['enable_add'] = true;
        $this->data['to_col'] = 5;
        $this->data['to_col_mo'] = 6;


        //-----------define fields-------------------------------------------
        // 속성값은 scaffoler.php의 상단 주석 참고.
        //-------------------------------------------------------------------



        $cps['제이드나인'] = '제이드나인';
        $cps['옥화용소절경'] = '옥화용소절경';

        $pickup['Y'] = "픽업";
        $pickup['N'] = "픽업안함";

        $ptime['14:00'] = "14:00";
        $ptime['15:00'] = "15:00";
        $ptime['16:00'] = "16:00";
        $ptime['17:00'] = "17:00";
        $ptime['18:00'] = "18:00";
        $ptime['19:00'] = "19:00";
        $ptime['20:00'] = "20:00";
        $ptime['21:00'] = "21:00";
        $ptime['22:00'] = "22:00";
        $ptime['23:00'] = "23:00";

        $area['서울특별시'] = "서울특별시";
        $area['경기도'] = "경기도";
        $area['인천광역시'] = "인천광역시";
        $area['부산광역시'] = "부산광역시";
        $area['경상남도'] = "경상남도";
        $area['경상북도'] = "경상북도";
        $area['대구광역시'] = "대구광역시";
        $area['대전광역시'] = "대전광역시";
        $area['울산광역시'] = "울산광역시";
        $area['충청남도'] = "충청남도";
        $area['충청북도'] = "충청북도";
        $area['강원도'] = "강원도";
        $area['전라남도'] = "전라남도";
        $area['전라북도'] = "전라북도";
        $area['광주광역시'] = "광주광역시";
        $area['세종시'] = "세종시";
        $area['제주도'] = "제주도";

        $this->data['fields'] = array(
            'room_cp' => array('title' => '객실소속', 'type' => 'select', 'options'=>$cps , 'list_style' => 'text-align:center;width:120px;font-weight: bold','html'=>true,'col-md'=>12,'uneditable'=>true),
            'code' => array('title' => '예약코드', 'type' => 'input', 'list_style' => 'text-align:center;width:100px','html'=>false,'col-md'=>8,'uneditable'=>true,'list_hide'=>true),
            'room_no' => array('title' => '객실코드', 'type' => 'input', 'list_style' => 'text-align:center;width:120px;font-weight: bold','html'=>true,'list_hide'=>true,'col-md'=>4,'uneditable'=>true),

            'room_name' => array('title' => '객실명', 'type' => 'input', 'list_style' => 'text-align:center;width:180px;font-weight: bold','html'=>true,'uneditable'=>true,'col-md'=>8),
            'room_number' => array('title' => '객실번호', 'type' => 'input', 'list_style' => 'text-align:center;width:80px','html'=>true,'uneditable'=>true,'col-md'=>4),



            'price_name' => array('title' => '결제내용', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'12','uneditable'=>true),
            'options' => array('title' => '옵션', 'type' => 'textarea','rule'=>'','list_style' => 'text-align:center;','list_hide'=>true,'col-md'=>12,'uneditable'=>true),

            'todate' => array('title' => '사용일', 'type' => 'date', 'list_style' => 'text-align:center;width:100px','col-md'=>6,'uneditable'=>true),
            'lastdate' => array('title' => '마지막날', 'type' => 'date', 'list_style' => 'text-align:center;width:100px','col-md'=>6,'uneditable'=>true),

            '' => array('title' => '', 'type' => 'hidden', 'list_style' => 'text-align:center;width:','col-md'=>6, 'custom_field'=>true,'custom_field'=>true,'list_hide'=>true),

            'name' => array('title' => '예약자', 'type' => 'input', 'list_style' => 'text-align:center;width:100px','col-md'=>6, 'rule'=>'required'),
            'phone' => array('title' => '전화번호', 'type' => 'input', 'list_style' => 'text-align:center;width:100px','col-md'=>6, 'rule'=>'required'),
            'ptime' => array('title' => '입실<br>시간', 'type' => 'select', 'options'=>$ptime ,'list_style' => 'text-align:center;width:','col-md'=>6, 'rule'=>''),
            'area' => array('title' => '출발<br>지역', 'type' => 'select','options'=>$area, 'list_style' => 'text-align:center;width:100px','col-md'=>6, 'rule'=>''),


            'memo' => array('title' => '메모', 'type' => 'textarea', 'list_style' => 'text-align:center;width:','col-md'=>12,'list_hide'=>true,'style'=>'height:120px'),

            'pickup' => array('title' => '픽업여부', 'type' => 'select','options'=>$pickup ,'rule'=>'','list_style' => 'text-align:center;','no_keyword'=>true,'list_hide'=>true,'custom_field'=>true),



            'totalprice' => array('title' => '총 결제', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'12','uneditable'=>true),
            'price1' => array('title' => '객실비', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),
            'price2' => array('title' => '추가인원비', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),
            'price3' => array('title' => '옵션비', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),

            'seongin_val' => array('title' => '성인', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),
            'adong_val' => array('title' => '아동', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),
            'yua_val' => array('title' => '유아', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),
            'pay_state' => array('title' => '입금상태', 'type' => 'select', 'options'=>array('Y'=>'입금확인됨','N'=>'입금대기'),'list_style' => 'text-align:center;width:50px','html'=>true,'list_hide'=>false,'col-md'=>'12'),

            
            'created'=>array('title'=>'예약날짜','type'=>'now','list_style'=>'text-align:center;width:100px'),
            'no'=>array('title'=>'번호','type'=>'hidden','is_key'=>true)
        );

        //$this->data['date_filter'] = "created";

    }

    public function index()
    {
        parent::index();
    }

    public function _list_db_get()
    {


        if($_GET['keyword']){
            $where = " name like '%".$_GET['keyword']."%' ";
        }

        $row_data = $this->_listPageingRow($this->table_tn,$where,$orderby=" order by no desc");
        for($ii=0; $ii<count($row_data['data']); $ii++) {
            $row_data['data'][$ii]['totalprice'] = number_format($row_data['data'][$ii]['totalprice']);
            $row_data['data'][$ii]['price1'] = number_format($row_data['data'][$ii]['price1']);
            $row_data['data'][$ii]['price2'] = number_format($row_data['data'][$ii]['price1']);
            $row_data['data'][$ii]['price3'] = number_format($row_data['data'][$ii]['price1']);

        }
        return $row_data;
    }

    public function view_cl(){

        if ( $_GET['year'] )  $year = $_GET['year'] ;
        if ( $_GET['month'] )  $month = $_GET['month'] ;

        if(!$year) $year = date("Y");
        if(!$month) $month = date("m");

        $time = strtotime($year.'-'.$month.'-01');
        $time2 = strtotime($year.'-'.$month.'-31');
        list($tday, $sweek) = explode('-', date('t-w', $time));  // 총 일수, 시작요일
        $tweek = ceil(($tday + $sweek) / 7);  // 총 주차from
        $lweek = date('w', strtotime($year.'-'.$month.'-'.$tday));  // 마지막요일

        //합계 데이터
        $t_data = $this->db->select(' room_cp, room_name,  count(*) as cu ')->group_by("room_name")->from('rooms')->order_by('room_cp, room_name','asc')->get()->result_array();
        for($ii=0; $ii<count($t_data); $ii++) {
            $t_data[$ii]['to_realpan']  = $this->db->set('name')->where('todate >=',date('Y-m-d',$time))->where('todate <=',date('Y-m-d',$time2))->where('room_name',$t_data[$ii]['room_name'])->get('realpans')->result_array();

            $to_total = $to_total + count($t_data[$ii]['to_realpan']);
            
        }
        $this->display->assign('t_data',$t_data);
        $this->display->assign('to_total',$to_total);
        $this->display->assign('year',$year);
        $this->display->assign('month',$month);




        if($_GET['room_name']){
            $this->db->where('room_name',$_GET['room_name']);
        }
        $this->db->order_by('room_number','asc');
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
                $caltemp .=  '<td class="hand" valign="top">' ;
                if (($i == 0 && $k < $sweek) || ($i == $tweek-1 && $k > $lweek)) {
                    $caltemp .=    "</td>";
                    continue;
                }



                $tt = sprintf("%02d", $n++) ;
                $udate = $year."-".$month."-".$tt ;

                $room_txt='';


                for($ii=0; $ii<count($room_list); $ii++) {

                    $room_list[$ii]['to_realpan'] = $this->db->where('todate <=',$udate)->where('lastdate >',$udate)->where('room_no',$room_list[$ii]['no'])->get('realpans')->row_array();

                    if($room_list[$ii]['to_realpan']){

                      

                        if($room_list[$ii]['to_realpan']['pay_state'] == 'N'){
                            $room_txt .='<div class="blue m-b10 r p-l10 p-b10 m-l5 m-r5"><a href="javascript:view_reserve('.$room_list[$ii]['to_realpan']['no'].',\''.$room_list[$ii]['to_realpan']['pay_state'].'\',jsondata)"><span >  '
                                                    .' <br><span style="color:#">'.$room_list[$ii]['room_cp']."<br>".$room_list[$ii]['room_name']." ".$room_list[$ii]['room_number'].'</span><div class="b-t" style="margin-left:-10px;padding-left:10px;padding-top:10px;;margin-top:5px">'. $room_list[$ii]['to_realpan']['name'].' : <strong>입금대기</strong><br>'.$this->to_phone($room_list[$ii]['to_realpan']['phone']).'</div></a> </div>';
                        }else{
                            $room_txt .='<div class="red  m-b10 r p-l10 p-b10 m-l5 m-r5">
                                <a href="javascript:view_reserve('.$room_list[$ii]['to_realpan']['no'].',\''.$room_list[$ii]['to_realpan']['pay_state'].'\',jsondata)"><br><span class=" ">'. ' 
                                 <span style="color:#">'.$room_list[$ii]['room_cp']."<br>".$room_list[$ii]['room_name']." ".$room_list[$ii]['room_number'].'</span><div  class="b-t" style="margin-left:-10px;padding-left:10px;padding-top:10px;margin-top:5px">'.$room_list[$ii]['to_realpan']['name'].' : <strong>입금완료</strong><br>'.$this->to_phone($room_list[$ii]['to_realpan']['phone']).'</div></a> </div>';
                        }





                    }else{
                        //$room_txt .='<div class="m-t15 ft10"><span class="label ">가</span> '.$room_list[$ii]['room_name'].' '.$room_list[$ii]['room_number'].'</div>';
                    }

                }
                
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


                    $varprincname =  $to_day_type ;
                }


                $caltemp .= '<div class="day " >' . $tt .'일 <span style="color:#a1a1a1">' .$varprincname.'</span></div><div class="text-left m-t40" style="font-size:11px">'.$room_txt.'</div> ';





//			$caltemp .= $row['minetime'] ."<br>". $row['maxetime']."<br>". $n++ ;

                $caltemp .=   '</td>' ;

            endfor;
            $caltemp .=   '</tr>' ;
        endfor;

        $caltemp .=   '</tbody>' ;
        $caltemp .=   '</table>' ;


        $data = array( "caltemp"=>$caltemp , "where"=>$where );

        $this->display->assign($data);

        $this->display->define('CONTENT', $this->display->getTemplate('/reserve/admin_list.html'));
        $content = $this->display->fetch('CONTENT');

        echo $content;
    }


    function to_phone($phone){
        if(strlen($phone>10)) {
            return substr($phone, 0, 3) . '-' . substr($phone, 3, 4) . '-' . substr($phone, 7, 4);
        }else{
            return substr($phone, 0, 3) . '-' . substr($phone, 3, 3) . '-' . substr($phone, 6, 4);
        }
    }

    public function list_json()
    {
        $items = $this->_list_db_get();
        parent::_send_json($items);
    }

    public function add()
    {
        parent::add();
    }

    public function add_action()
    {
        parent::add_action();
    }

    public function _add_to_db()
    {
        if(parent::_add_to_db($this->table_tn)) {

            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        parent::edit();
    }

    public function _edit_db_get()
    {

        $this->db->where('no', $this->input->get_post('no'));
        $data = $this->db->get($this->table_tn)->row_array();

     
        return $data;
    }

    public function data_json()
    {

        $data =  $this->_edit_db_get();

        $data['to_dates'] =  $this->db->select(' min(todate) as sdate ')->where('code',$data['code'])->get('realpans')->row_array();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('code' => '200', 'result' => $data)));


    }

    public function edit_action()
    {

        $this->form_validation->set_rules('no', '번호', 'required');
        parent::edit_action();
    }

    public function edit_action_pay_state()
    {

       if($_POST['code']){
           if($this->db->set('pay_state',$_POST['pay_state'])->where('code',$_POST['code'])->update($this->table_tn)){
               $this->output
                   ->set_content_type('application/json')
                   ->set_output(json_encode(array('code' => '200', 'result' => $data)));
           }
       }
    }



    public function _edit_from_db()
    {


        if(parent::_edit_from_db($this->table_tn)) {

            return true;
        } else {
            return false;
        }
    }

    public function delete_action()
    {
        parent::delete_action();
    }

    public function _delete_from_db()
    {
        $this->db->where('no', $this->input->post('no'));
        return $this->db->delete($this->table_tn);
    }
    public function delete_pe()
    {
        $this->db->where('code', $this->input->post('code'));
        if($this->db->delete($this->table_tn)){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('code' => '200', 'result' => $data)));
        }
    }

}
