jQuery( function( $ ) {

	$("#TagInputHelper a").click(function(){
		var $tagsnow = $("#tags").val();
		if($tagsnow =="<?php esc_attr_e( 'Tag it', 'p2' ); ?>") {$("#tags").val("");}
	});

	var TagInputHelper = new Array($("#TagInputHelper"));  
	var normalClass = { padding : "2px 2px 0 2px", textDecoration : "none", color : "#666", backgroundColor : "none", border : "0" };  //非選択時  
	var selectedClass = { padding : "2px 2px 0 2px", textDecoration : "none", color : "#666", backgroundColor : "none", border : "0"}; //選択時  
	var normalHoverClass = { padding : "2px 2px 0 2px", textDecoration : "none", color : "red", backgroundColor : "none", border : "0"}; //ホバー時  
	$("#tags").jTagging(TagInputHelper, ",", normalClass, selectedClass, normalHoverClass);

//	$("#tags").jTagging($("#TagInputHelper"), ",");  

});