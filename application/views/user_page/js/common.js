/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2015-09-21
* 작성자: 김종태
*****************************************************************
* 
*/

function ie_chk(){
	var trident = navigator.userAgent.match(/Trident\/(\d)/i);
	if(trident != null){
		 return 1;
	} else{
		 return 0;
	}
}

//var main_slide_mouserover = '';
//슬라이더 실행

//1184 / 900

function animatedStart(){
//	 if( !$('html').hasClass('ie') ) {
		$('[ani]').css({"opacity":0, "filter": "alpha(opacity = 0)"});
		$('[ani]').each(function(){
			
	
			
			if(($(this).offset().top / 3) <  $(window).scrollTop() || (($(this).offset().top / 5) < 150) && $(window).scrollTop() == 0){
				var delay = $(this).attr('delay');
				var ani = $(this).attr('ani');
				var obj = $(this);
				if(!delay) delay = 100;
				if(!ani) ani = 'fadeIn';
				
				setTimeout(function(){
					obj.addClass('animated '+ani);
				},delay);
			}
		});
//	}
}



function animatedStart2(){
	// if( !$('html').hasClass('ie') ) {
		$('[ani_s]').css({"opacity":0, "filter": "alpha(opacity = 0)"});
		$('[ani_s]').each(function(){
			
				var delay = $(this).attr('delay');
				var ani = $(this).attr('ani_s');
				var obj = $(this);
				if(!delay) delay = 100;
				if(!ani) ani = 'fadeIn';
				
				setTimeout(function(){
					obj.addClass('animated '+ani);
				},delay);
			
		});
	//}
}

$(document).scroll(function(){

animatedStart();

});



function reload_tree(){
	location.reload();
}

$(document).ready(function(){ 
	animatedStart();
	animatedStart2();
	$('.over_plus').hover(function(){ $(this).addClass('opa70'); },function(){ $(this).removeClass('opa70'); })

});
