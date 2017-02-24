<?

$menu = array();

$cate1 = 0;

$menu[$cate1]['title'] = "펜션소개";
$menu[$cate1]['title2'] = "ABOUT US";
$menu[$cate1]['link'] = "#/user/page/p?designs=".HOST."&p=aboutus";

$cate2 = 0;
$menu[$cate1]['submenu'][$cate2]['title'] = "인 사 말";
$menu[$cate1]['submenu'][$cate2]['title2'] = "SUMMARY";
$menu[$cate1]['submenu'][$cate2]['w'] = "13%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=aboutus";


$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "오시는 길";
$menu[$cate1]['submenu'][$cate2]['title2'] = "LOCATION";
$menu[$cate1]['submenu'][$cate2]['w'] = "13%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=location";;

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "주변여행지";
$menu[$cate1]['submenu'][$cate2]['title2'] = "TRAVEL";
$menu[$cate1]['submenu'][$cate2]['w'] = "13%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=travel";

$cate1++;

$menu[$cate1]['title'] = "객실안내";
$menu[$cate1]['title2'] = "ROOM";
$menu[$cate1]['link'] = "#/user/page/p?designs=".HOST."&p=room_setting";;

$cate2 = 0;
$menu[$cate1]['submenu'][$cate2]['title'] = "룸 배치도";
$menu[$cate1]['submenu'][$cate2]['title2'] = "ROOM SETTING";
$menu[$cate1]['submenu'][$cate2]['w'] = "11%;margin-left:13%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=room_setting";;

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "외부전경";
$menu[$cate1]['submenu'][$cate2]['title2'] = "EXTERIOR/VIEW";
$menu[$cate1]['submenu'][$cate2]['w'] = "11%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=exview";;

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "스파빌라-A";
$menu[$cate1]['submenu'][$cate2]['title2'] = "SPA VILLA-A";
$menu[$cate1]['submenu'][$cate2]['w'] = "11%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=room_a&number=101";;

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "스파빌라-B";
$menu[$cate1]['submenu'][$cate2]['title2'] = "SPA VILLA-B";
$menu[$cate1]['submenu'][$cate2]['w'] = "11%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=room_b&number=101";;

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "스파빌라-C";
$menu[$cate1]['submenu'][$cate2]['title2'] = "SPA VILLA-C";
$menu[$cate1]['submenu'][$cate2]['w'] = "11%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=room_c&number=101";;


$cate1++;

$menu[$cate1]['title'] = "부대시설";
$menu[$cate1]['title2'] = "FACILITY";
$menu[$cate1]['link'] = "#/user/page/p?designs=".HOST."&p=fa&fa=pool";


$cate2 = 0;
$menu[$cate1]['submenu'][$cate2]['title'] = "수 영 장";
$menu[$cate1]['submenu'][$cate2]['title2'] = "SWIMMING POOL";
$menu[$cate1]['submenu'][$cate2]['w'] = "13%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=fa&fa=pool";

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "카페 쥬아드비브르";
$menu[$cate1]['submenu'][$cate2]['title2'] = "CAFE JOIE DEVIVRE";
$menu[$cate1]['submenu'][$cate2]['w'] = "15%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=fa&fa=cafe";

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "바 비 큐";
$menu[$cate1]['submenu'][$cate2]['title2'] = "BAREBECUE";
$menu[$cate1]['submenu'][$cate2]['w'] = "10%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=fa&fa=bbq";

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "강 당";
$menu[$cate1]['submenu'][$cate2]['title2'] = "SEMINAR";
$menu[$cate1]['submenu'][$cate2]['w'] = "6%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=fa&fa=seminar";

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "족 구 장";
$menu[$cate1]['submenu'][$cate2]['title2'] = "PLAY GROUND";
$menu[$cate1]['submenu'][$cate2]['w'] = "11%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=fa&fa=play";;

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "캠프파이어";
$menu[$cate1]['submenu'][$cate2]['title2'] = "CAMPFIRE";
$menu[$cate1]['submenu'][$cate2]['w'] = "8%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=fa&fa=camp";;

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "매 점";
$menu[$cate1]['submenu'][$cate2]['title2'] = "CONVENIENCE STORE";
$menu[$cate1]['submenu'][$cate2]['w'] = "16%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=fa&fa=store";;

$cate1++;

$menu[$cate1]['title'] = "패키지";
$menu[$cate1]['title2'] = "PACKAGE";
$menu[$cate1]['link'] = "#";


$cate2 = 0;
$menu[$cate1]['submenu'][$cate2]['title'] = "패키지1";
$menu[$cate1]['submenu'][$cate2]['title2'] = "PACKAGE1";
$menu[$cate1]['submenu'][$cate2]['w'] = "16%;margin-left:10%";
$menu[$cate1]['submenu'][$cate2]['link'] = "javascript:alert('페이지를 준비중입니다.')";

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "패키지2";
$menu[$cate1]['submenu'][$cate2]['title2'] = "PACKAGE2";
$menu[$cate1]['submenu'][$cate2]['w'] = "16%";
$menu[$cate1]['submenu'][$cate2]['link'] = "javascript:alert('페이지를 준비중입니다.')";

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "패키지3";
$menu[$cate1]['submenu'][$cate2]['title2'] = "PACKAGE3";
$menu[$cate1]['submenu'][$cate2]['w'] = "16%";
$menu[$cate1]['submenu'][$cate2]['link'] = "javascript:alert('페이지를 준비중입니다.')";

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "패키지4";
$menu[$cate1]['submenu'][$cate2]['title2'] = "PACKAGE4";
$menu[$cate1]['submenu'][$cate2]['w'] = "16%";
$menu[$cate1]['submenu'][$cate2]['link'] = "javascript:alert('페이지를 준비중입니다.')";



$cate1++;

$menu[$cate1]['title'] = "실시간예약";
$menu[$cate1]['title2'] = "RESERVATION";
$menu[$cate1]['link'] = "#/user/reserve/lists2";;


$cate2 = 0;
$menu[$cate1]['submenu'][$cate2]['title'] = "실시간예약";
$menu[$cate1]['submenu'][$cate2]['title2'] = "RESERVATION";
$menu[$cate1]['submenu'][$cate2]['w'] = "12%;margin-left:55%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/reserve/lists2";


$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "예약안내";
$menu[$cate1]['submenu'][$cate2]['title2'] = "GUIDE";
$menu[$cate1]['submenu'][$cate2]['w'] = "8%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=guide";;

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "예약확인";
$menu[$cate1]['submenu'][$cate2]['title2'] = "RESERVE CHECK";
$menu[$cate1]['submenu'][$cate2]['w'] = "12%";
$menu[$cate1]['submenu'][$cate2]['link'] = "javascript:reserve_chk()";;



$cate1++;

$menu[$cate1]['title'] = "커뮤니티";
$menu[$cate1]['title2'] = "COMMUNITY";
$menu[$cate1]['link'] = "#/user/board/list_view/1010";


$cate2 = 0;
$menu[$cate1]['submenu'][$cate2]['title'] = "공지사항&포토갤러리";
$menu[$cate1]['submenu'][$cate2]['title2'] = "NOTICE&PHOTO GALLERY";
$menu[$cate1]['submenu'][$cate2]['w'] = "20%;margin-left:60%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/board/list_view/1010";

$cate2++;
$menu[$cate1]['submenu'][$cate2]['title'] = "자주하는질문";
$menu[$cate1]['submenu'][$cate2]['title2'] = "FAQ";
$menu[$cate1]['submenu'][$cate2]['w'] = "12%";
$menu[$cate1]['submenu'][$cate2]['link'] = "#/user/page/p?designs=".HOST."&p=faq";;



return $menu;

?>
