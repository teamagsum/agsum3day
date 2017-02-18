jQuery(function($){

	/*orderby*/
	if($.cookie('wppm_search_order')){
		selected="#"+$.cookie('wppm_search_order');
		$(selected).addClass('selected');
	} else {
		$("#last_post").addClass('selected');
	}

	$("#orderby a").on( "click", function(){
		if( $(this).attr("id") != $.cookie('wppm_search_order') ){
			$.cookie('wppm_search_order', $(this).attr("id"), { expires: 7 });
			location.reload();
		}
	});

	/*tagfilter*/
	if($.cookie('wppm_tagfilter')){
		selected="#"+$.cookie('wppm_tagfilter');
		$(selected).addClass('selected');
	} else {
		$("#tag_all").addClass('selected');
	}

	$("#tagfilter a").on( "click", function(){
		if( $(this).attr("id") != $.cookie('wppm_tagfilter') ){
			$.cookie('wppm_tagfilter', $(this).attr("id"), { expires: 7 });
			//alert($(this).attr("id"));
			location.reload();
		}
	});


});