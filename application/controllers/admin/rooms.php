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

class Rooms extends Scaffolder
{
    var $current_user;
    var $table_tn = "rooms";
    var $db_id = "admin/rooms";
    var $db_name = "객실";

    public function __construct()
    {
        parent::__construct();
    }

    public function _init()
    {
        $this->data['schema']['id'] = $this->db_id;
        $this->data['schema']['name'] = $this->db_name;

        $this->data['top_text'] = "객실별 가격설정 및 인원정보를 세팅합니다.";

        $this->data['one_page'] = true;
        $this->data['enable_add'] = false;


        //-----------define fields-------------------------------------------
        // 속성값은 scaffoler.php의 상단 주석 참고.
        //-------------------------------------------------------------------

        $option_array = $this->db->order_by('name','asc')->get('room_options')->result_array();
        for($ii=0; $ii<count($option_array); $ii++) {
            $options[$option_array[$ii]['no']] = $option_array[$ii]['name'];
        }

        $cps['제이드나인'] = '제이드나인';
        $cps['옥화용소절경'] = '옥화용소절경';

        $this->data['fields'] = array(
            'img_url' => array('title' => '대표이미지', 'type' => 'hidden', 'rule'=>'required', 'list_style' => 'text-align:center;width:100px','html'=>false,'image'=>true,'img_w'=>'100px'),
            'room_cp' => array('title' => '객실소속', 'type' => 'select', 'rule'=>'required','options'=>$cps , 'list_style' => 'text-align:center;width:120px;font-weight: bold','html'=>true),
            'room_name' => array('title' => '객실명', 'type' => 'input', 'rule'=>'required', 'list_style' => 'text-align:center;width:280px;font-weight: bold','html'=>true),
            'room_number' => array('title' => '객실번호', 'type' => 'input', 'rule'=>'required', 'list_style' => 'text-align:center;width:100px','html'=>true),

            'bi_price' => array('title' => '비수기<br><small class="text-muted ft12">(주중)</small>', 'type' => 'number', 'list_style' => 'text-align:center;width:','col-md'=>6,'label'=>'원'),
            'bi_price2' => array('title' => '비수기<br><small class="text-muted ft12">(주말/휴일)</small>', 'type' => 'number', 'list_style' => 'text-align:center;width:','col-md'=>6,'label'=>'원'),
            'jun_price' => array('title' => '준성수기<br><small class="text-muted ft12">(주중)</small>', 'type' => 'number', 'list_style' => 'text-align:center;width:','col-md'=>6,'label'=>'원'),
            'jun_price2' => array('title' => '준성수기<br><small class="text-muted ft12">(주말/휴일)</small>', 'type' => 'number', 'list_style' => 'text-align:center;width:','col-md'=>6,'label'=>'원'),
            'sung_price' => array('title' => '성수기<br><small class="text-muted ft12">(주중)</small>', 'type' => 'number', 'list_style' => 'text-align:center;width:','col-md'=>6,'label'=>'원'),
            'sung_price2' => array('title' => '성수기<br><small class="text-muted ft12">(주말/휴일)</small>', 'type' => 'number', 'list_style' => 'text-align:center;width:','col-md'=>6,'label'=>'원'),

            'options_select[]' => array('title' => '부대시설', 'type' => 'multiselect','options'=>$options ,'rule'=>'','list_style' => 'text-align:center;','no_keyword'=>true,'list_hide'=>true,'custom_field'=>true),

            'options' => array('title' => '부대시설', 'type' => 'hidden', 'rule'=>'','list_style' => 'text-align:center;','list_hide'=>true),
            'to_da' => array('title' => '최대숙박가능일', 'type' => 'number', 'rule'=>'','list_style' => 'text-align:center;','list_hide'=>true),
            'human_min' => array('title' => '최소인원', 'type' => 'number', 'rule'=>'required','list_style' => 'text-align:center;','list_hide'=>true,'col-md'=>'6'),
            'human_max' => array('title' => '최대인원', 'type' => 'number', 'rule'=>'required','list_style' => 'text-align:center;','col-md'=>'6','list_hide'=>true),
            'add_human_price' => array('title' => '성인<br>추가 비용', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4'),
            'add_human_price2' => array('title' => '아동<br>추가 비용', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4'),
            'add_human_price3' => array('title' => '유아<br>추가 비용', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'list_hide'=>true,'col-md'=>'4'),
            'human' => array('title' => '인원정보', 'type' => 'input', 'list_style' => 'text-align:center;','html'=>true,'not_field'=>true,'custom_field'=>true),

            'created'=>array('title'=>'생성일','type'=>'now','list_style'=>'text-align:center;width:100px'),
            'no'=>array('title'=>'번호','type'=>'hidden','is_key'=>true)
        );

        //$this->data['date_filter'] = "created";

    }

    public function index()
    {
        //합계 데이터
        $t_data = $this->db->select(' room_cp, room_name,  count(*) as cu ')->group_by("room_name")->from($this->table_tn)->order_by('room_cp','desc')->get()->result_array();
        for($ii=0; $ii<count($t_data); $ii++) {
            $totals = $totals+ $t_data[$ii]['cu'];
            if($_GET['sch_room_name'] == $t_data[$ii]['room_name']) {
                $this->data['total_box'][$ii]['title'] = "<a href='#" . $this->db_id . "?sch_room_name=" . $t_data[$ii]['room_name'] . "' style='font-weight: bold;color:blue'><strong>" . $t_data[$ii]['room_cp']."</strong><br>".$t_data[$ii]['room_name'] . "</a>";
            }else{
                $this->data['total_box'][$ii]['title'] = "<a href='#" . $this->db_id . "?sch_room_name=" . $t_data[$ii]['room_name'] . "' style='font-weight: '><strong>" . $t_data[$ii]['room_cp']."</strong><br>".$t_data[$ii]['room_name'] . "</a>";
            }


            $this->data['total_box'][$ii]['cu'] =  number_format($t_data[$ii]['cu'])."개";
        }

        $this->data['totals'] = $totals;
        if(!$_GET['sch_room_name']) {
            $this->data['total_title'] = "<a href='#" . $this->db_id . "' style='font-weight: bold;color:blue'><strong>전체보기</strong></a>";
        }else{
            $this->data['total_title'] = "<a href='#" . $this->db_id . "'><strong>전체보기</strong></a>";
        }
        $this->data['total_label'] = '개';

        parent::index();
    }

    public function _list_db_get()
    {


        if($_GET['keyword']){

        }

        $row_data = $this->_listPageingRow($this->table_tn,$where,$orderby=" order by no desc");
        for($ii=0; $ii<count($row_data['data']); $ii++) {
            $row_data['data'][$ii]['bi_price'] = number_format($row_data['data'][$ii]['bi_price']);
            $row_data['data'][$ii]['bi_price2'] = number_format($row_data['data'][$ii]['bi_price2']);
            $row_data['data'][$ii]['jun_price'] = number_format($row_data['data'][$ii]['jun_price']);
            $row_data['data'][$ii]['jun_price2'] = number_format($row_data['data'][$ii]['jun_price2']);
            $row_data['data'][$ii]['sung_price'] = number_format($row_data['data'][$ii]['sung_price']);
            $row_data['data'][$ii]['sung_price2'] = number_format($row_data['data'][$ii]['sung_price2']);

            $row_data['data'][$ii]['human'] = "기본:".$row_data['data'][$ii]['human_min']." / 최대:".$row_data['data'][$ii]['human_max']."명<br>1명 당".number_format($row_data['data'][$ii]['add_human_price'])."원 추가";
        }
        return $row_data;
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
        if($data['options']){
            $this->data['fields']['options_select[]']['selects'] = explode(",",$data['options']);

        }
     

        return $data;
    }

    public function edit_action()
    {
        //$this->form_validation->set_rules('id', '아이디', 'required');
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
