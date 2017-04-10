

<h4 class="title"><?=$schema['name']?> <?=$is_edit?"수정":"생성"?></h4>


<script>
var word = '<?=$is_edit?"수정":"생성"?>';
$(document).ready(function (){
	$('#act-button').click(function() {


			var url = '/<?=$schema['id']?>/<?=$is_edit?"edit_action":"add_action"?>';
			$.ajax({
				type: 'post',
				url: url,
				data: $('#item-form').serialize(),
				dataType:"json",
				error: function(xhr, e){
					alert(word+' 페이지에 접속할 수 없습니다.');
					console.log(xhr.responseText);
				},
				success: function(result) {
					if(result.error) {
						showAlert(result.messages, 'error', 3000);

                        //alert(result.messages);
                  

					} else {
						//showAlert(word+"하였습니다.", 'info', 3000);
                        bootbox.hideAll();
                        bootbox.alert(word+"하였습니다.",function () {
                            bootbox.hideAll();
                            if(strstr(location.hash,"?")){
                            //    document.location.href=location.hash+"&v="+date("YmdHis");
                            }else{
                              //  document.location.href=location.hash+"?v="+date("YmdHis");
                            }

                            location.reload();


                        });





					}
				}
			});


	});

	$('#del-button').click(function() {
		if(confirm("정말로 이 <?=$schema['name']?>(을)를 삭제하시겠습니까?")) {
			var url = '<?=$schema['id']?>/delete_action';
			$.ajax({
				type: 'post',
				url: url,
				data: $('#item-form').serialize(),
				dataType: 'json',
				error: function(xhr, e){
					alert(word+' 페이지에 접속할 수 없습니다.', 'error', 3000);
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

                        bootbox.hideAll();
                        bootbox.alert("삭제 하였습니다.",function () {
                            bootbox.hideAll();
                            if(strstr(location.hash,"?")){
                            //    document.location.href=location.hash+"&v="+date("YmdHis");
                            }else{
                              //  document.location.href=location.hash+"?v="+date("YmdHis");
                            }

                            location.reload();
                        });
					}
				}
			});
		}
	});

	$('.multiselect_uncheck_btn').click(function(){
		$(this).closest('.control-group').find('.controls').find('select option:selected').prop('selected',false);
	});
});
</script>
<?
if(!$to_col) $to_col = '6';
if(!$to_col_mo) $to_col_mo = '6';
?>

<div class=" panel-body  pos_r" id="in_add_form" >



            <form id="item-form" class="form-horizontal">



                <? if(count($fields)>$to_col){?>
                <div class="col-md-<?=$to_col_mo?>">
                <?}?>
                <?php $is_focused = false; ?>
                <? $ii=0;?>
                <?php foreach($fields as $key => $val) : ?>


                    <? if(!$val['not_field'] ) {?>
                    <div class="

                    <? if($val['col-md']){?>col-md-<?=$val['col-md']?><?}else{?>col-md-12<?}?>
                    "

                        <?php if($val['is_key'] || $val['type']=='now' || $val['edit_hide']==true) echo "style='display:none'"; ?>>

                            <? if($val['type']!='hidden'  ){?>
                            <div class="md-form-group p-t30">
                            <?}?>
                            <? if($val['type'] == 'date'){?>

                                <input type="date" name="<?=$key?>" value="<?=$val['value']?$val['value']:$rows[$key]?>" id="<?=$key?>" maxlength="<?=$val['max_length']?>" style="<?=$val['style']?>;height:34px" onfocus="this.select()" class="form-control has-value" <? if($is_edit && $val['uneditable']){echo 'readonly';}?> />

                            <? }else if($val['type'] == 'number'){?>

                                <input type="number" name="<?=$key?>" value="<?=$val['value']?$val['value']:$rows[$key]?>" id="<?=$key?>" maxlength="<?=$val['max_length']?>" style="<?=$val['style']?>;height:34px" onfocus="this.select()" class="form-control has-value" <? if($is_edit && $val['uneditable']){echo 'readonly';}?> />

                            <?}else{?>


                            <?=field_to_html($key,
                                $val['value']?$val['value']:$rows[$key],
                                $val['type'],
                                $val['max_length'],
                                $val['options'],
                                $val['selects'],
                                $val['style'],

                                (($is_edit && $val['uneditable'])?'readonly':''),
                                (($is_edit && $val['value']==$rows[$key])?true:false) // checked
                            )?>

                            <? } ?>


                                <? if($val['memo'] ){?>
                                    <div class="text-muted ft12 text-danger m-t5" style="color:blue;font-size:12px"><?=$val['memo']?></div>
                                <?}?>

                            <? if($val['image']){?>
                                <div class="p-t10">
                                    <img src="<?=$val['value']?$val['value']:$rows[$key]?>" <?if($val['img_w']){?>width="<?=$val['img_w']?>"<?}?> <?if($val['img_h']){?>height="<?=$val['img_h']?>"<?}?> style="<?=$val['sub_style']?>" />
                                </div>
                            <?}?>
                            <?  if( $val['type'] != 'hidden' ){?>
                            <label class="control-label m-b5" for="<?=$key?>"><?=strip_tags($val['title'])?></label>
                            <?}?>
                                <? if($val['type']!='hidden'  ){?>
                        </div>
                                <?}?>
                    </div>
                <?php if(!$is_focused) : ?>
                    <script>
                        setTimeout(function () {
                          //  $('#<?=$key?>').focus();
                        },1000);
                    </script>
                    <?php $is_focused = true; ?>
                <?php endif; ?>



                    <? if(($ii+1) %$to_col==0) {?>
                        <? if(count($fields)>$to_col){?>
                            </div>
                            <div class="col-md-<?=$to_col_mo?>">
                        <?}?>

                    <?}?>

                    <? $ii++; ?>

                  <?}?>

                <?php endforeach; ?>

                        </div>

                <div class="clearfix">


                    <div class="control-group clearfix ">

                    <div class="controls text-right col-md-12  p-t15 m-t5">
                        <hr/>
                        <? if($enable_add){?>
                        <button type="button" id="del-button" class="btn btn-danger f_l" <?=$is_edit?"":"style='display:none'"?>><i class="icon-warning-sign"></i> 삭제하기</button>
                        <?}?>


                        <a href="javascript:" class="btn btn-default bootbox-close-button f_r">취소</a>
                        <button type="button" id="act-button" class="btn btn-primary f_r m-r5"><?=$is_edit?"수정하기":"생성"?></button>
                    </div>
                </div>



                </div>







        </div>
    </form>



<script type="text/javascript">

    
    $(document).ready(function(){

       $('input[type="text"],input[type="password"],input[type="number"],input[type="date"]').removeClass('form-control').addClass('md-input');
       $('select').addClass('md-input');
       $('textarea').addClass('md-input');
       $('input[type="checkbox"]').each(function(){
           var def_chk = $(this).parent().html();
           $(this).parent().html('<label class="ui-switch ui-switch-md info m-t-xs">'+def_chk+' <i></i></label>')
       });



        $("#item-form").find("textarea").each(function(){
            $(this).width('100%');
        });
        $("#item-form").find("select[multiple=multiple]").each(function(){
             $(this).select2({tags: true,
                 tokenSeparators: [',', ' ']});
             $('.select2').width('100%').css('border-radius','2px').css('border','1px solid #dcdcdc;').css('margin-bottom','20px');
        });


    });
</script>


