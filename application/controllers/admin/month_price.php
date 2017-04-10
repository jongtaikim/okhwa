<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'scaffolder.php';

class month_price extends Scaffolder {

    var $table_tn = "month_prices";
    var $db_id = "admin/month_price";
    var $db_name = "성수기 관리";

    function __construct() {
        parent::__construct();


    }

    public function _init()
    {

        $this->data['schema']['id'] = $this->db_id;
        $this->data['schema']['name'] = $this->db_name;

        $this->data['top_text'] = "날짜를 선택하여 성수기 구분을 합니다.";
        //$this->data['one_page'] = true;
        //$this->data['enable_add'] = false;

        $price_names = array(
            ''=>'-- 가격명 선택 --',

            '준성수기'=>'준성수기',
            '성수기'=>'성수기',
            '연휴'=>'연휴(주말가격)',


        );


        $years = array(
            '2017'=>'2017',
            '2018'=>'2018',
            '2019'=>'2019',
            '2020'=>'2020',

        );

        $months = array(
            '01'=>'01',
            '02'=>'02',
            '03'=>'03',
            '04'=>'04',
            '05'=>'05',
            '06'=>'06',
            '07'=>'07',
            '08'=>'08',
            '09'=>'09',
            '10'=>'10',
            '11'=>'11',
            '12'=>'12',
        );
        //-----------define fields-------------------------------------------
        // 속성값은 scaffoler.php의 상단 주석 참고.
        //-------------------------------------------------------------------
        $this->data['fields'] = array(
            'year'=>array('title'=>'년','type'=>'select','options' => $years, 'rule'=>'required', 'list_hide'=>false,'list_style'=>'text-align:center;color:blue','label'=>'년'),
            
            'price_name'=>array('title'=>'구분','type'=>'select','options' => $price_names,'list_style'=>'text-align:center;width:','rule'=>'required'),
            'start_date'=>array('title'=>'구분시작일','type'=>'date','list_style'=>'text-align:center;width:150px','rule'=>'required','placeholder'=>'0000-00-00'),

            'end_date'=>array('title'=>'구분종료일','type'=>'date','list_style'=>'text-align:center;width:150px','rule'=>'required','placeholder'=>'0000-00-00'),

            'created'=>array('title'=>'생성일','type'=>'now','list_style'=>'text-align:center;width:130px;'),
            'no'=>array('title'=>'번호','type'=>'hidden','is_key'=>true,'list_style'=>'text-align:center;;width:200px')
        );
    }

    public function index()
    {
        parent::index();
    }

    public function _list_db_get()
    {
        $row_data = $this->_listPageingRow($this->table_tn,$where='',$orderby=" order by year asc , start_date asc");

        for($ii=0; $ii<count($row_data['data']); $ii++) {
            $row_data['data'][$ii]['price'] = number_format($row_data['data'][$ii]['price']);
            $row_data['data'][$ii]['price2'] = number_format($row_data['data'][$ii]['price2']);
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
        return $this->db->get($this->table_tn)->row_array();
    }

    public function edit_action()
    {
        /*        $this->form_validation->set_rules('idc', 'IDC', 'required');
                $this->form_validation->set_rules('ip_range', '아이피 대역', 'required');
        */

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
        $rw = $this->db->delete($this->table_tn);
        return $rw;
    }


}
