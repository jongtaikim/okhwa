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

            '' => array('title' => '', 'type' => 'hidden', 'list_style' => 'text-align:center;width:','col-md'=>6, 'custom_field'=>true,'list_hide'=>true),

            'name' => array('title' => '예약자', 'type' => 'input', 'list_style' => 'text-align:center;width:','col-md'=>6, 'rule'=>'required',),
            'phone' => array('title' => '전화번호', 'type' => 'input', 'list_style' => 'text-align:center;width:100px','col-md'=>6, 'rule'=>'required',),
            'ptime' => array('title' => '입실<br>시간', 'type' => 'input', 'list_style' => 'text-align:center;width:','col-md'=>6, 'rule'=>'required',),
            'area' => array('title' => '출발<br>지역', 'type' => 'input', 'list_style' => 'text-align:center;width:100px','col-md'=>6, 'rule'=>'required',),


            'memo' => array('title' => '메모', 'type' => 'textarea', 'list_style' => 'text-align:center;width:','col-md'=>12,'list_hide'=>true,'style'=>'height:120px'),

            'pickup' => array('title' => '픽업여부', 'type' => 'select','options'=>$pickup ,'rule'=>'','list_style' => 'text-align:center;','no_keyword'=>true,'list_hide'=>true,'custom_field'=>true),



            'totalprice' => array('title' => '총 결제', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'12','uneditable'=>true),
            'price1' => array('title' => '객실비', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),
            'price2' => array('title' => '추가인원비', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),
            'price3' => array('title' => '옵션비', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),

            'seongin_val' => array('title' => '성인', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),
            'adong_val' => array('title' => '아동', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),
            'yua_val' => array('title' => '유아', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),
            'pay_state' => array('title' => '유아', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4','uneditable'=>true),


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
        if ( $_GET['str_year'] )  $year = $_GET['str_year'] ;
        if ( $_GET['str_month'] )  $month = $_GET['str_month'] ;

        if(!$year) $year = date("Y");
        if(!$month) $month = date("m");

        $time = strtotime($year.'-'.$month.'-01');
        $time2 = strtotime($year.'-'.$month.'-31');
        list($tday, $sweek) = explode('-', date('t-w', $time));  // 총 일수, 시작요일
        $tweek = ceil(($tday + $sweek) / 7);  // 총 주차from
        $lweek = date('w', strtotime($year.'-'.$month.'-'.$tday));  // 마지막요일

        $room_list = $this->db->order_by('room_number','asc')->get('rooms')->result_array();

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

                    $room_list[$ii]['to_realpan'] = $this->db->where('todate <=',$udate)->where('lastdate >=',$udate)->where('room_no',$room_list[$ii]['no'])->get('realpans')->row_array();

                    if($room_list[$ii]['to_realpan']){

                      

                        if($room_list[$ii]['to_realpan']['pay_state'] == 'N'){
                            $room_txt .='<div class="m-t15 ft10 p-l10"><span class="label blue">대</span> 
                                                    <a href="javascript:view_reserve('.$room_list[$ii]['to_realpan']['no'].',\''.$room_list[$ii]['to_realpan']['pay_state'].'\',jsondata)">'
                                                    .$room_list[$ii]['room_name'].' '.$room_list[$ii]['room_number'].'</a> </div>';
                        }else{
                            $room_txt .='<div class="m-t15 ft10 p-l10"><span class="label red">완</span> 
                                <a href="javascript:view_reserve('.$room_list[$ii]['to_realpan']['no'].',\''.$room_list[$ii]['to_realpan']['pay_state'].'\',jsondata)">'.$room_list[$ii]['room_name'].'
                                 '.$room_list[$ii]['room_number'].'</a> </div>';
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

    public function _edit_from_db()
    {

        $_POST['options'] = implode(',',$_POST['options_select']);
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

}
