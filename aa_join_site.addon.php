<?php
/**
========================================
   요약 : 방문자 가입권유 애드온
=========================================
   제작 : 숭숭군 ( samswnlee@naver.com )
=========================================
   문의 : http://xecenter.com
========================================= 
**/

if(!defined('__XE__')) exit();


//사용시점 세팅 (화면출력전,비로그인시,관리자화면아닐시,봇제외)
if($called_position == 'before_display_content' && Context::getResponseMethod() == 'HTML' && Context::get('module') != "admin" && !isCrawler() && !Context::get('logged_info')){
	
	//회원가입 페이지에서 작동안함
	if(Context::get('act') == 'dispMemberSignUpForm' || Context::get('act') == 'dispMemberLoginForm') return;
	
	//닫기로 인해 쿠키값 0 일경우 리턴 $expire_time 이후 작동
	$pv_ct = $_COOKIE['ck_view_ct'];
	if($pv_ct == '0') return; 
	
	//애드온 기본설정 값 (디폴트)
	$addon_info->ct_type ? $addon_info->ct_type : $addon_info->ct_type = 'page';
	$addon_info->ct ? $addon_info->ct : $addon_info->ct = '5';
	$addon_info->close ? $addon_info->close : $addon_info->close = 'hour';
	$addon_info->p_subject ? $addon_info->p_subject : $addon_info->p_subject = '사이트 이용하면서 도움 되셨나요?';
	$addon_info->p_content ? $addon_info->p_content : $addon_info->p_content = '회원가입 후 더 많은 혜택을 누리세요 <br/>천천히 둘러보세요';
	$addon_info->bt_login ? $addon_info->bt_login : $addon_info->bt_login = 'Y';
	$addon_info->bt_join_link = $addon_info->bt_join_link;
	$addon_info->position ? $addon_info->position : $addon_info->position = 'right:0; bottom:0;';
	$addon_info->colorset = $addon_info->colorset;
	$addon_info->width = $addon_info->width;
	
	//설정값세팅
	Context::set('addon_info',$addon_info);
	
	//쿠키 기본설정 값
	$ck_name = 'ck_view_ct';
	$ck_value = '1';
	$expire_time = time()+ 60*60*6; // 6시간 // 1 = 1초
		
	//쿠키없을시 쿠키생성
	if(!isset($_COOKIE[$ck_name])){
		setcookie($ck_name, $ck_value, $expire_time, '/');
	}
	
	//쿠키있을시
	if(isset($_COOKIE[$ck_name])){
				
		//설정값보다 카운트 높을시 팝업작동
		if($pv_ct >= $addon_info->ct){
			
			//템플릿 설정
			$oTemplate = &TemplateHandler::getInstance();
			$popup_html = $oTemplate->compile('./addons/aa_join_site/tpl/','popup.html');
			//본문삽입
			$output = $output.$popup_html;
			//변수해제
			unset($popup_html,$ck_name,$ck_value,$expire_time);
		}else{
			//카운터 기준이 게시물일경우 문서번호없을시 리턴 
			if($addon_info->ct_type == 'doc' && !Context::get('document_srl')) return;
			//카운터 1 증가
			$ck_value = $pv_ct+1;
			setcookie($ck_name, $ck_value, $expire_time,'/');
		}
	}	
	
}