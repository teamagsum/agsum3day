<?php
//nginxでのリダイレクトloopを回避
remove_filter('template_redirect', 'redirect_canonical');
// メニュー使用
register_nav_menus( array() ); 

// ウィジェット使用
register_sidebar( array(
'name' => 'サイドバーウィジェット',
'id' => 'sidebar-1',
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => '</aside>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
));

// ビジュアルエディタCSS使用
add_editor_style();

// 画質改善
add_filter('jpeg_quality', create_function('$arg','return 100;'));

// ユーザーエージェント判別
function is_mobile(){
    $useragents = array(
        'iPhone', // iPhone
        'iPod', // iPod touch
        'Android', // 1.5+ Android
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate' // Other iPhone browser
    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}

?>