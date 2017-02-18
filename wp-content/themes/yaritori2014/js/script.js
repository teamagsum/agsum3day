/*------------------------------
  スムーススクロール
------------------------------*/
$(function(){
	$('a[href^=#]').click(function(){
		var speed = 500;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top;
		$("html, body").animate({scrollTop:position}, speed, "swing");
		return false;
	});
});

/*------------------------------
  ページトップへ戻る
------------------------------*/
$(document).ready(function() {
	var flag = false;
	var pagetop = $('.pagetop');
	$(window).scroll(function () {
		if ($(this).scrollTop() > 500) {
			if (flag == false) {
				flag = true;
				pagetop.stop().animate({
					'bottom': '10px'
				}, 200);
			}
		} else {
			if (flag) {
				flag = false;
				pagetop.stop().animate({
					'bottom': '-70px'
				}, 200);
			}
		}
	});
	pagetop.click(function () {
		$('body, html').animate({ scrollTop: 0 }, 500);
		return false;
	});
});

/*------------------------------
  アンドロイドのバージョン判別
------------------------------*/
function lowerAndroid(n) {
    var bo = false;
    var ua = navigator.userAgent.toLowerCase();
    var version = ua.substr(ua.indexOf('android')+8, 3);
    if(ua.indexOf("android")) if(parseFloat(version) < n) bo = true;
    return bo;
}


/*------------------------------
  UA確認：スマホ(sp)、タブレット(tab)、その他(other)
------------------------------*/
function uaCheck(n) {
    var ua = navigator.userAgent;
    if(ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0){
        return 'sp';
    }else if(ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0){
        return 'tab';
    }else{
        return 'other';
    }
};

/*------------------------------
 viewport処理
------------------------------*/
function viewportChange(n) {
	var thisUA = uaCheck();
	if(thisUA == "tab"){
		document.write('<meta name="viewport" content="width=1000px" />\n');
	}else{
		document.write('<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />\n');
	}
	return;
}

/*------------------------------
  video サウンドオンオフ
------------------------------*/
$(function(){
var video_flg = 0;
	$("#hero .btn-sound").on('click', function(){
		if(!video_flg) {
			video_flg = 1;
			$("#video").prop("muted", false);
			 $(this).attr('src', $(this).attr('src').replace('-off', '-on'));
		} else {
			video_flg = 0;
			$("#video").prop("muted", true);
			$(this).attr('src', $(this).attr('src').replace('-on', '-off'));
		}
	});
});