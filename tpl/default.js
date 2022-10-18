jQuery(function($){
	
	//가입권유 팝업
	$('#xt_join_site_addons').slideDown(500);
	
	//닫기버튼
	$('#xt_join_site_addons .xt_close').click(function(){	$('#xt_join_site_addons').slideUp(500);	});
	$('#xt_join_site_addons .c_hour').click(function(){		$('#xt_join_site_addons').slideUp(500);	$.cookie('ck_view_ct','0',{path:'/'});	});
	$('#xt_join_site_addons .c_reset').click(function(){	$('#xt_join_site_addons').slideUp(500);	$.cookie('ck_view_ct','1',{path:'/'});	});
	
});
