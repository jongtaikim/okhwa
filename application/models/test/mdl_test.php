<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2015-09-17
* 작성자: 김종태
* 설   명:  mdl_test
*****************************************************************
* 
*/

class mdl_test extends CI_Model {

    function __construct()
    {
        parent::__construct();
	
    }


    /**
     *  
     *
     * @return	object	$page : 현재 페이지, $listnum : 한페이지당 로드할 개수
     * @return	object	$list_data =리스트데이터 ,  array(page,total,listnum) => tpl assign 
     * @return	void
     */	
    
    function rank_list($page=1,$listnum=15,$key="",$search="",$this_date=''){

	      if(!$this_date) $this_date = date("Y-m-d");
		$list_data = $this->webapp->listPageingRow("scrolling_keyword_set"," use_chk = 'Y' ", " order by idx desc ",$page,$listnum,$key,$search);
		
		for($ii=0; $ii<count($list_data); $ii++) {
			$sql = "
				select count(*) from keyword_url_rank  where keyword = '".$list_data[$ii][keyword]."' and run_date = '".$this_date."' 
			";

			$list_data[$ii][keyword_cu] = $this->db-> sqlFetchOne($sql);
			
		}
		
		return $list_data;
    }

  
     /**
     *  
     *
     * @return	object	$userid		회원아이디
     * @return	void
     */	
    
    function rank_view($site_name='',$keyword='',$this_date='' ,$this_time=''){
		
		if(!$this_date) $this_date = date("Y-m-d");
		if($this_time !='') $psql = " and b.run_time_h = '".$this_time."' ";

		$sql = "
		
		select b.run_date, b.run_time_h  

		FROM keyword_url_rank b , scrolling_run_info c, scrolling_run_row d 

		WHERE b.site_name = 'naver' AND b.keyword = '턱끝성형' AND b.scrolling_run_info_idx = c.idx AND b.scrolling_run_row_idx = d.idx  and
		
		b.run_date = '".$this_date."'

		$psql

		group by b.run_date, b.run_time_h

		order by b.run_date, b.run_time_h desc
		";
		$rowt = $this->db -> sqlFetchAll($sql);

		for($ii=0; $ii<count($rowt); $ii++) {
			
			$sql = "
				select * FROM

					 keyword_url_rank b , scrolling_run_info c, scrolling_run_row d

					WHERE
					
					b.site_name = '".$site_name."' AND
					b.keyword = '".$keyword."' AND
					
					b.scrolling_run_info_idx = c.idx AND

					b.scrolling_run_row_idx = d.idx  and

					 b.run_date = '".$rowt[$ii][run_date]."' and
					 
					 b.run_time_h  = '".$rowt[$ii][run_time_h]."'  and

					 b.run_date = '".$this_date."'

					order by b.run_time_h, b.keyword_rank asc

			";

			$rowt[$ii]['list'] = $this->db -> sqlFetchAll($sql);
			
		}
		
		return $rowt;
		
    }

    /**
     *  
     *
     * @return	object	$userid		회원아이디
     * @return	void
     */	
    
    function html_view($scrolling_run_row_idx=''){

		$sql = "
			select s_text FROM

				scrolling_run_info 
				WHERE
				
				idx = '".$scrolling_run_row_idx."'

		";

		
		
		$row = $this->db -> sqlFetchOne($sql);

		return $row;
		
    }



	
}

?>