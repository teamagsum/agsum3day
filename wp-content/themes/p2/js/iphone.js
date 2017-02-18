/**
 * Handles toggling the main navigation and new post form menu on iPhone.
 */
jQuery( document ).ready( function( $ ) {

//     alert("ready!");

  var $masthead   = $( '#header' ),
		$postToggle = $( '#mobile-post-button' ),
		$postbox    = $( '#postbox' ),
		$searchToggle = $( '#pm-search' ),
		$searchbox       = $( '#pm-search-form' ),
	    timeout     = false;


  	//スマホなら#postboxを移動しておく
	  if ( $postToggle.is( ':visible' ) ){
			      $postbox.insertAfter("#header");
    }
  
  
  //resize終わった時だけcssの適応状態を見てDOM操作
	var timer = false;

  //初期の幅を取得
  var width = $(window).width();

	$(window).resize(function() {

    //幅が変わった時だけに限定する（iPhoneバーチャルキーボード対策）
		if ($(window).width()==width) return;
	  width = $(window).width();

    if (timer !== false) {
        clearTimeout(timer);
    }

    timer = setTimeout(function() {
        console.log('resized');

      	//#postboxの位置をwindowサイズに合わせて移動
			  if ( $postToggle.is( ':visible' ) ){
			      $postbox.insertAfter("#header");
			      $postbox.css("display","none");
			  } else {
			      $postbox.prependTo(".sleeve_main");
			      $postbox.css("display","block");
			      $searchbox.css("display","none");
	      }

    }, 200);

  });
  
	$postToggle.click( function( e ) {
		e.preventDefault();
		$searchToggle.removeClass("IconActive");
		if ( $postbox.is( ':visible' ) ) {
			$postbox.slideUp( 'fast' );
			$searchbox.slideUp( 'fast' );
			$postToggle.toggleClass("IconActive");
		} else {
			$searchbox.slideUp( 'fast' );
			$postbox.slideDown( 'fast' );
			$postToggle.toggleClass("IconActive");
		}
  } );

	$searchToggle.click( function( e ) {
		e.preventDefault();
		$postToggle.removeClass("IconActive");
		if ( $searchbox.is( ':visible' ) ) {
			$searchbox.slideUp( 'fast' );
			$postbox.slideUp( 'fast' );
			$searchToggle.toggleClass("IconActive");
		} else{
			$postbox.slideUp( 'fast' );
			$searchbox.slideDown( 'fast' );
			$searchToggle.toggleClass("IconActive");
		}
  } );

} );

