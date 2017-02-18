jQuery( function( $ ) {

	//続きを読むをajaxで読み込み（追加直後のdomにもliveで適応）
	$('a.more-link').live ({
		"click" :function(event) {
			//aリンクの動作を停止
			event.preventDefault();
			//リンク先URLを取得
			var page = $(this).attr('href');
			$(this).parent().parent()
				.load(page+' div.postcontent p')
				.fadeOut()
				.slideDown(200);
		}
	});

	//<!--more-->挿入ツール
	$('#more-buttons a').click(function(event) {
			//aリンクの動作を停止
			event.preventDefault();
			//タグを追加
			var current = $('#posttext').val();

			if ( current.indexOf("<!--more-->") == -1 ) {
				$('#posttext').val(current + "<!--more-->");
			}

	});

});