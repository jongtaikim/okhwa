<?
foreach( $_GET as $val => $value )
{

    if(substr($val,0,3) == 'sch' || $val == 'limit' || substr($val,0,7) == 'time_s_' || substr($val,0,7) == 'time_e_'){
        $sch_text .= "&".$val."=".$value;
        if(substr($val,0,3) == 'sch'){
            $sch_text_info .= $value." > ";
        }
    }

}
$sch_text_info = substr($sch_text_info,0,strlen($sch_text_info)-3);
?>
<script type="text/javascript">

    var table_list_data = '';

    function tableListCtrl($scope, $http) {
        $scope.init = function(id) {
            $http.get(id + '/list_json?page=<?=$_GET['page']?>&keyword=<?=$_GET['keyword']?>&config_id=<?=$_GET['config_id']?><?=$sch_text?>')
                .then(function(res){
                    $scope.items = res.data.items;
                    //$scope.pagehtml = res.data.pagehtml;
                    table_list_data =  res.data;
                    try{
                        page_init(table_list_data);
      
                        $('#loading2').hide();

                    }catch (e){

                    }
                });
        };
    }
</script>

<style type="text/css" title="">
.table_e > tbody > tr >  td{padding:5px;line-height:180%}
.table_e > thead > tr > th{padding:5px;    vertical-align: middle;}
</style>
<div class="col-lg-<?if(count($fields)>6){?>12<?}else{?>9<?}?> col-md-12 " style="max-width:1600px">
<div class="card table-responsive">

    <div class="card-heading bg-light lt"  pos_r">

      <strong class="h4">  <?=$schema['name']?> 목록</strong>
        <small class="">
            <? if($top_text){?>
                <?=$top_text?>
            <?}?>
        </small>




        <div class=" pos_a" style="right:5px;top:15px">
            <div class="clearfix">


                <div class="w480 " style="float: right">
                    <div class="f_l w80">

                    </div>
                    <div class="input-group f_r w700" >
                        <? if(!$date_filter){ ?>
                            <div class="form-group l-h m-a-0 f_r col-sm-4  text-right " style="margin-right:0px;padding-right:10px">
                                <div class="input-group input-group-sm f_r">
                                    <input type="text" class="form-control p-x b-a rounded"   type="text" id="keyword" value="<?=$_GET['keyword']?>" placeholder="검색..."><span class="input-group-btn"><button type="button" class="btn btn-dark  search-btn"><i class="fa fa-search"></i></button></span>
                                </div>
                            </div>
                        <?}?>

                    </div>
                </div>

            </div>

        </div>

    </div>
    <div class="card-body b-t">


<?if($total_box && count($total_box) <10){?>
<div class="clearfix m-t10 p-l10">
    <div class="row-col box-shadow2 text-center gray m-b20 b-b b-l b-r b-t " >

        <? for($ii=0; $ii<count($total_box); $ii++) {?>
        <div class="row-cell p-a b-r">
            <div class="m-b10"><?=$total_box[$ii]['title']?></div>
            <h4 class="m-a-0 text-md _600"><?=$total_box[$ii]['cu']?></h4>
        </div>
        <? } ?>

    </div>
</div>
<?}?>

<? if($date_filter){ ?>
    <div class="box clearfix padding m-l10">
        <div class="input-group f_l " >
            <label class="f_l ft16 form-control-label">기간</label>
            <input type="text" class="form-control date-input day-start " name="time_s_<?=$date_filter?>"  id="time_s_<?=$date_filter?>" value="<?=$_GET['time_s_'.$date_filter]?>" style="width:110px" />
            <span class="f_l ft16  form-control-label " style="padding-left: 2px;padding-right: 2px"> ~ </span>
            <input type="text" class="form-control date-input day-end" name="time_e_<?=$date_filter?>" id="time_e_<?=$date_filter?>" value="<?=$_GET['time_e_'.$date_filter]?>" style="width:110px" />

        </div>

        <div class="input-group f_l m-l10 ">
            <input type="text" class="form-control p-x b-a rounded"   type="text" id="keyword" value="<?=$_GET['keyword']?>" placeholder="검색...">
        </div>
        <div class="input-group f_l ">
            <button type="button" class="btn btn-info search-btn f_l m-l5 ">검색</button>
        </div>
    </div>
    </div>
<?}else{?>
    <div class="hide">
        <input type="hidden"  name="time_s_<?=$date_filter?>"  id="time_s_<?=$date_filter?>" value="<?=$_GET['time_s_'.$date_filter]?>" />

        <input type="hidden" name="time_e_<?=$date_filter?>" id="time_e_<?=$date_filter?>" value="<?=$_GET['time_e_'.$date_filter]?>"/>
    </div>
<?}?>


<div id="loading2" class=" pos_a autoheight " style="z-index:999;top:0px;left:0px;width:100%;    ">
    <div class="" style="text-align: left; width: 100px;margin: 20% auto;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw" style="font-size:90px"></i>
    </div>
</div>

<script src="/trunk/scripts/angular.min.js" type="text/javascript"></script>

<div class=" ft12" ng-app="myapp" ng-controller='tableListCtrl' ng-init="init('<?=$schema['id']?>')" >

    <?if($total_box && count($total_box) >10){?>
        <div class="f_l p-t15" style="width:15%">
            <? for($ii=0; $ii<count($total_box); $ii++) {?>
                <div class="box p-a b-r">
                    <div class=""><?=$total_box[$ii]['title']?></div>
                    <h4 class="m-a-0 text-md _600"><?=$total_box[$ii]['cu']?></h4>
                </div>
            <? } ?>
        </div>
        <div class="f_r" style="width:84%">
    <?}?>

    <? if(!$_GET['no_head']){ ?>
        <div id="table-title" class="m-b15 h5 ft15 m-l10"></div>
    <?}?>


    <div class="m-b10">
        <small class="text-muted" id="page_sub_title"></small>
    </div>
    <table class="table table_e box  table-bordered b-b b-l b-t b-r ft12 " style="<?if(count($fields)>6 || ($total_box && count($total_box) >10) ){?>width:100%;margin-left:  0px;margin-right: 0px<?}else{?>margin:10px auto;min-width:700px;<?}?>;table-layout: auto;">

        <!-- Table Header -->
        <thead id="data_table_thead">
        <tr style="background-color: #f4f4f4;border-bottom:2px solid #cdcdcd">
            <? $i=0;?>
            <? foreach ($fields as $key => $val) : ?>

                <? if($i==0){?>
                    <? if(!$no_hidden){ ?>
                    <!--<th class="text-center w60">번호</th>-->
                    <?}?>
                <?}?>

                <? if($val['list_hide']) continue; ?>
                <? if($key=="no" && !$enable_add) continue ?>
                <? if($key=="no") : ?>
                    <th class="text-center"><?=$edit_btn_name?></th>
                <? else : ?>
                    <th ng-click="predicate = '<?=$key?>'; reverse=!reverse" class="text-center"><?=$fields[$key]['title']?></th>
                <? endif; ?>


                <? $i++;?>
            <? endforeach; ?>

        </tr>
        </thead>
        <!-- Table Header -->


        <? if($one_page) : ?>
            <!-- Table Body -->
            <tbody class="items" id="items_tbody">
            <tr ng-repeat="item in items | filter:query " id="tr{{item.no}}"  >
                <? $i=0;?>
                <? foreach ($fields as $key => $val) : ?>

                    <? if($i==0){?>
                        <? if(!$no_hidden){ ?>
                           <!-- <td class="text-center">{{item.no}}</td>-->
                        <?}?>
                    <?}?>

                    <? if($val['list_hide']) continue; ?>

                    <? if($key=="no" && !$enable_add) continue ?>


                <td style="<?=$val['list_style']?>"  class="<? if($key=="no") {?> text-center <?}?>"><span style="<?=$val['sub_style']?>" class="" <? if($key!="no" && $val['html']) { ?>ng-bind-html-unsafe="item.<?=$key?>"<?}?> >



                                <? if($key=="no") { ?>
                                           <a href="javascript:" onclick="page_view('/<?=$schema['id']?>/edit?no={{item.no}}');" class=" btn btn-default btn-xs" style="<?=$val['sub_style']?>"><?=$edit_btn_name?></a>
                                           <a href="javascript:" onclick="delete_action({{item.no}})" class=" btn btn-default btn-xs" style="<?=$val['sub_style']?>">삭제</a>

                                <? }else{?>
                                        
                                    <? if($val['image']) { ?>
                                    <img src="{{item.<?=$key?>}}" <?if($val['img_w']){?>width="<?=$val['img_w']?>"<?}?> <?if($val['img_h']){?>height="<?=$val['img_h']?>"<?}?> style="<?=$val['sub_style']?>" class="<?=$val['sub_class']?>"/>
                                    <?}else{?>
                                        {{item.<?=$key?>}}<?=$val['label']?>
                                    <? } ?>
                                <? } ?>




	                </span></td>
                <? $i++;?>
                <? endforeach; ?>
            </tr>
            </tbody>
            <!-- Table Body -->

        <? else : ?>
        <? endif; ?>


    </table>


            <? if($one_page) : ?>
                <? if($enable_add) : ?>
                    <div class="   text-right" >

                        <a href="javascript:" onclick="page_view('/<?=$schema['id']?>/add')" class="btn btn-sm btn-dark " style="color:#fff" >+ 새 <?=$schema['name']?></a>

                    </div>
                <? endif; ?>


            <? endif; ?>

            <div class="text-center" id="pagehtml">

            </div>


            <?if($total_box && count($total_box) >10){?></div><?}?>
</div>
<script type="text/javascript">


    function page_init(data) {

        if(data.total >0) {
            $('#pagehtml').html(data.pagehtml);
            $('#page_sub_title').html("총 " + number_format(data.total) + '건의 데이터가 검색되었습니다.');


            $('.pagination > li > a').each(function () {
                if ($(this).attr('href')) {
                    var ast = explode("?", location.hash);
                    $(this).attr('href', ast[0] + "?" + str_replace("?", "", $(this).attr('href')));
                }
            });




        }else{
            var f_roe = $('#data_table_thead > tr').children().length;
            $('#items_tbody').html('<tr><td colspan="'+f_roe+'" class="text-center padding">데이터가 없습니다.</td></tr>');
        }

        $('#keyword').focus();
    }
    $('.search-btn').click(function(){
        var ast = explode("?",location.hash);
        location.href=ast[0]+"?keyword="+$('#keyword').val()+"&time_s_<?=$date_filter?>="+$('#time_s_<?=$date_filter?>').val()+"&time_e_<?=$date_filter?>="+$('#time_e_<?=$date_filter?>').val();

    });

    $('#keyword').keyup(function(evert){
        if(evert.keyCode == 13) {
            var ast = explode("?", location.hash);
            location.href = ast[0] + "?keyword=" + $('#keyword').val()+"&time_s_<?=$date_filter?>="+$('#time_s_<?=$date_filter?>').val()+"&time_e_<?=$date_filter?>="+$('#time_e_<?=$date_filter?>').val();

        }



    });

    function balert(url) {
        //encodeURIComponent()
        $.ajax({
        type: 'GET',
        url: url,

        dataType: 'json',
        	success: function(data, status) {
                if(data){
                    if(data.result.html){
                        bootbox.alert(data.result.html);
                    }
                }
        	},
        	error: function(request,status,error) {
        		alert(request.responseText);
        	}
        });
    }

    
    function stop_discussions(no,objid) {
        //encodeURIComponent()
        if(confirm("게시물을 차단하시겠습니까?") == true){
            $.ajax({
                type: 'POST',
                url: '/discussions/edit_stop',
                data: 'no=' + no,
                dataType: 'json',
                success: function (data, status) {
                    alert(data.messages);
                    if (data.error == 200) {
                        //location.reload();

                        $('#' + objid).parent().parent().prev().prev().html('<div class="b-b ftb p-b10"><strong>운영 원칙에 위배되어 삭제 처리된 글입니다.</strong></div><div class="p-t10">운영 원칙에 위배되어 삭제 처리된 글입니다.</div>');
                    }

                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
    }


    $(document).ready(function(){
        $(function() {
            var dateOptions = {
                changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
                changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
                minDate: '-100y', // 현재날짜로부터 100년이전까지 년을 표시한다.
                nextText: '다음 달', // next 아이콘의 툴팁.
                prevText: '이전 달', // prev 아이콘의 툴팁.
                numberOfMonths: [1,1], // 한번에 얼마나 많은 월을 표시할것인가. [2,3] 일 경우, 2(행) x 3(열) = 6개의 월을 표시한다.
                //stepMonths: 3, // next, prev 버튼을 클릭했을때 얼마나 많은 월을 이동하여 표시하는가.
                yearRange: 'c-100:c+10', // 년도 선택 셀렉트박스를 현재 년도에서 이전, 이후로 얼마의 범위를 표시할것인가.
                showButtonPanel: true, // 캘린더 하단에 버튼 패널을 표시한다.
                currentText: '오늘 날짜' , // 오늘 날짜로 이동하는 버튼 패널
                closeText: '닫기',  // 닫기 버튼 패널
                dateFormat: "yy-mm-dd", // 텍스트 필드에 입력되는 날짜 형식.
                showMonthAfterYear: true , // 월, 년순의 셀렉트 박스를 년,월 순으로 바꿔준다.
                dayNamesMin: ['월', '화', '수', '목', '금', '토', '일'], // 요일의 한글 형식.
                monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] // 월의 한글 형식.
            };
            $( ".day-start" ).datepicker(dateOptions);
            $( ".day-end" ).datepicker(dateOptions);
        });
    });


   function delete_action(no,obj) {
       if(confirm("정말로 이 <?=$schema['name']?>(을)를 삭제하시겠습니까?")) {
           var url = '<?=$schema['id']?>/delete_action';
           $.ajax({
               type: 'post',
               url: url,
               data: "no="+no,
               dataType: 'json',
               error: function(xhr, e){
                   showAlert(word+' 페이지에 접속할 수 없습니다.', 'error', 3000);
                   console.log(xhr.responseText);
               },
               success: function(result) {
                   if(result.error) {
                       bootbox.alert(result.messages);
                       setTimeout(function() {
                           // be careful not to call box.hide() here, which will invoke jQuery's hide method
                           box.modal('hide');
                       }, 3000);
//                        showAlert(result.messages, 'error', 3000);
                   } else {
                       //showAlert("삭제하였습니다.", 'info', 3000);

                       bootbox.alert("삭제하였습니다.");
                       setTimeout(function() {
                           box.modal('hide');
                       }, 3000);
                        $('#tr'+no).remove();

                   }
               }
           });
       }
   }

    function page_view(url){
        //encodeURIComponent()
        $.ajax({
            type: 'GET',
            url: url,

            dataType: 'html',
            success: function(html, status) {
                bootbox.alert(html);
                $('.modal-footer ').remove();
            },
            error: function(request,status,error) {
                alert(request.responseText);
            }
        });
    }

    function list_page_view(url) {
        //encodeURIComponent()
        $.ajax({
            type: 'GET',
            url: url,
            data:'&ajax=y',
            dataType: 'html',
            success: function(html, status) {
                $('#content_body').html(html);
            },
            error: function(request,status,error) {
                alert(request.responseText);
            }
        });
    }
</script>

</div>
</div>
</div>