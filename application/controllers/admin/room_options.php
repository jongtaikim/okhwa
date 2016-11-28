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

class room_options extends Scaffolder
{
    var $current_user;
    var $table_tn = "room_options";
    var $db_id = "admin/room_options";
    var $db_name = "부대시설";

    public function __construct()
    {
        parent::__construct();
    }

    public function _init()
    {
        $this->data['schema']['id'] = $this->db_id;
        $this->data['schema']['name'] = $this->db_name;
        $this->data['top_text'] = "객실의 추가옵션을 설정합니다. 각 객실이 사용할 옵션을 별도로 설정할 수 있습니다.";

        $this->data['one_page'] = true;
        $this->data['enable_add'] = true;

        //-----------define fields-------------------------------------------
        // 속성값은 scaffoler.php의 상단 주석 참고.
        //-------------------------------------------------------------------
        $this->data['fields'] = array(

            'name' => array('title' => '시설명', 'type' => 'input', 'rule'=>'required', 'list_style' => 'text-align:center;width:330px','html'=>true),
            'price' => array('title' => '가격', 'type' => 'number', 'list_style' => 'text-align:center;width:120px','html'=>true),
            'text' => array('title' => '설명', 'type' => 'input', 'list_style' => 'text-align:center;width:','html'=>true),



            'created'=>array('title'=>'생성일','type'=>'now','list_style'=>'text-align:center;width:100px'),
            'no'=>array('title'=>'번호','type'=>'hidden','is_key'=>true)
        );

        //$this->data['date_filter'] = "created";

    }

    public function index()
    {
//        //합계 데이터
//        $t_data = $this->db->select(' item_name, item_no, count(*) as cu , sum(price) as total')->where('is_valid','N')->group_by("item_name")->from($this->table_tn)->join('items', 'user_items.item_no = items.no')->order_by('total','desc')->get()->result_array();
//        for($ii=0; $ii<count($t_data); $ii++) {
//            $this->data['total_box'][$ii]['cu'] = number_format($t_data[$ii]['cu'])."개 <div class='m-t10'><small>".number_format($t_data[$ii]['total'])."원</small></div>";
//            $this->data['total_box'][$ii]['title'] =  "<a href='/web#user_items_new?sch_item_no=".$t_data[$ii]['item_no']."'>".$t_data[$ii]['item_name']."</a>";
//        }

        parent::index();
    }

    public function _list_db_get()
    {



        if($_GET['keyword']){

        }

        $row_data = $this->_listPageingRow($this->table_tn,$where,$orderby=" order by no desc");
        for($ii=0; $ii<count($row_data['data']); $ii++) {

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
        return $data;
    }

    public function edit_action()
    {
        //$this->form_validation->set_rules('id', '아이디', 'required');
        parent::edit_action();
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

}
