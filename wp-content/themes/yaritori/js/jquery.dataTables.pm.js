//初期
jQuery( document ).ready( function( $ ) {

  //1グループのMAX人数
  var  memberMaxNum = 30;
			$("#selectedUserMaxCount").text( " （"+memberMaxNum + "人まで選択可能）" );
  
	var selectedUsers  = [];

	//一覧テーブルセットアップ
	$( '<table cellpadding="0" cellspacing="0" border="0" !class="" id="tableForSelectFrom"></table>').appendTo('td#selectFrom');
	$('#tableForSelectFrom').dataTable( {
		"data": dataSet,
		"columns": [
			{ "title": "id" , "class": "hiddenID"},
			{ "title": "UserID" , "class": "userID" },
			{ "title": "氏名"  , "class": "userName" }
		],
		ordering:  false,
		paging: false,
		scrollY: 200
	} );

	//選択済みテーブルセットアップ
	$( '<table cellpadding="0" cellspacing="0" border="0" !class="" id="tableForSelectTo"></table>').appendTo('td#selectTo');
	$('#tableForSelectTo').dataTable( {
		"data": [],
		"columns": [
			{ "title": "id" , "class": "hiddenID" },
			{ "title": "UserID" , "class": "userID" },
			{ "title": "氏名"  , "class": "userName" }
		],
		searching: false,
		ordering:  false,
		paging: false,
		scrollY: 200
	} );

	//見た目調整（初期化）
	var titleHeightGap =  $('#tableForSelectFrom_filter').height() + $('#UserListBoxTitle').height();
	$('#selectedUserBoxTitle').css('height', titleHeightGap+'px');
	var userTotalCount = $("#tableForSelectFrom tbody").children('tr').length;
	$("#userTotalCount").text( userTotalCount + "人" );
	$("input[name='mode']:eq('new')").attr("checked", true);
	$("input[name='mode']:eq('edit')").attr("checked", false);


	//初期セレクト済みのユーザーを考慮
	setUpDone = false;
	if(initialSelectedUserID.length > 0){
		//処理済み？
		if(setUpDone === true){return}
		for (var i = 0, len = initialSelectedUserID.length; i < len; i++) {
			var thisID = initialSelectedUserID[i];
			var spacePaddedID = ' '+initialSelectedUserID[i]+' ';  
			//Fromでtrをselectedに
			$("#tableForSelectFrom tr td.hiddenID:contains("+spacePaddedID+")").parent().addClass('selected');
			//TOにtrを追加
			$("#tableForSelectFrom tr td.hiddenID:contains("+spacePaddedID+")").parent().clone(true).prependTo("#tableForSelectTo tbody");
			//hiddeninputに追加
			selectedUsers.push(spacePaddedID);
			$("#selectedUserList").val( selectedUsers.join(",") );
			//0になってたら未選択表示
			ToggleNoUserTR('add');
			//選択済み人数表示update
			$("#selectedUserCount").text( selectedUsers.length + "人" );
		}
		setUpDone = true;
	}

	//ユーザーtrのクリック処理
	$('#tableForSelectFrom tbody').on( 'click', 'tr', function () {

		var tmpID = $(this).children("td.hiddenID").text();
		
		//閲覧者のユーザーIDと一致したらfalse（管理者権限の人はcurrentUserIDがNULL）
		if( currentUserID > 0 && currentUserID == tmpID ){
			alert("自分を必ず含めてください。");
			return false;
		}
		
		if ( $(this).hasClass('selected') ) {
      //該当ユーザーのtrのclass除去
			$(this).removeClass('selected');
			//選択済みテーブルから該当ユーザーのtrを除去
			$("#tableForSelectTo tr td.hiddenID:contains("+tmpID+")").parent().remove();
			//hidden値からuid除去
			selectedUsers = deleteFromArray(selectedUsers,tmpID);
			//0になってたら未選択表示
			ToggleNoUserTR('remove');
		}
		else {

      //人数チェック
     var numItems = $('#tableForSelectFrom .selected').length;
    if( numItems > memberMaxNum-1 ){
	    alert("1グループに所属出来る人数は"+memberMaxNum+"人までです。");
      return;
  	}  
      
      //該当ユーザーのtrのclass追加
			$(this).addClass('selected');
			//選択済みテーブルに該当ユーザーのtrを追加
			$(this).clone(true).prependTo("#tableForSelectTo tbody");
			//hidden値にuid追加
			selectedUsers.push(tmpID);
			//0になってたら未選択表示
			ToggleNoUserTR('add');
		}
		selectedUsers = sortArrayByID(selectedUsers);
		$("#selectedUserList").val( selectedUsers.join(",") );
		$("#selectedUserCount").text( selectedUsers.length + "人" );

	} );

	//編集対象を選ぶとテーブルの内容が変わる
	$('select[name="groupTarget"]').change(function(){
		groupTarget = $('select[name="groupTarget"]').val();
		groupTarget = decodeURI(groupTarget);
		var tmp = groupTarget.split("<>");
		var groupName = tmp[0];
		var groupUserIDs = tmp[1];
//		alert('groupTarget changed　'+ groupName +'　'+ groupUserIDs);
//		return false;

		//hiddeninputをリセット
		selectedUsers = [];
		$("#selectedUserList").val('');

		//テーブル削除
		$('#tableForSelectFrom').dataTable().fnDestroy();
		$('#tableForSelectTo').dataTable().fnDestroy();

		//テーブル作り直し
		$('#tableForSelectFrom').dataTable( {
			"data": dataSet,
			"columns": [
				{ "title": "id" , "class": "hiddenID"},
				{ "title": "UserID" , "class": "userID" },
				{ "title": "氏名"  , "class": "userName" }
			],
			ordering:  false,
			paging: false,
			scrollY: 200
		} );
		$('#tableForSelectTo').dataTable( {
			"data": [],
			"columns": [
				{ "title": "id" , "class": "hiddenID" },
				{ "title": "UserID" , "class": "userID" },
				{ "title": "氏名"  , "class": "userName" }
			],
			searching: false,
			ordering:  false,
			paging: false,
			scrollY: 200
		} );

		//selectした値でuserをpreset選択
		var initialSelectedUserID = groupUserIDs.split(",");
		if(initialSelectedUserID.length > 0){
			for (var i = 0, len = initialSelectedUserID.length; i < len; i++) {
				var thisID = initialSelectedUserID[i];
				var spacePaddedID = ' '+initialSelectedUserID[i]+' ';  
				//Fromでtrをselectedに
				$("#tableForSelectFrom tr td.hiddenID:contains("+spacePaddedID+")").parent().addClass('selected');
				//TOにtrを追加
				$("#tableForSelectFrom tr td.hiddenID:contains("+spacePaddedID+")").parent().clone(true).prependTo("#tableForSelectTo tbody");
				//hiddeninputに追加
				selectedUsers.push(spacePaddedID);
				$("#selectedUserList").val( selectedUsers.join(",") );
				//0になってたら未選択表示
				ToggleNoUserTR('add');
				//選択済み人数表示update
				$("#selectedUserCount").text( selectedUsers.length + "人" );
			}
		}

	});

	/*-----------------------------------------------
	   submit処理の前のinput内容チェック
	 -----------------------------------------------*/
	//mode = new
	$("#submitNew").click(function(){
		users = $("#selectedUserList").val();
		mode = $('input[name="mode"]').val();
		newGroup = $('input[name="newGroup"]').val();
		$errFlag = false;
		if(!users || users === '') {
			alert('参加者を1名以上選んでください。');
			$errFlag = true;
		}
		if(!newGroup || newGroup === '') {
			alert('新規グループ名を入力してください。');
			$errFlag = true;
		}
		//新規グループ名が既存と衝突しないかをチェック(後送)
		if($errFlag === true){return false;}
	});

	//mode = edit
	//update
	$("#submitUpdate").click(function(){
		mode = $('input[name="mode"]').val();
		groupTarget = $('select[name="groupTarget"]').val();
		if(!groupTarget || groupTarget === '' ) {
			alert('グループが選択されていません。');
			$errFlag = true;
		}
		if($errFlag === true){return false;}
	});
	//delete
	$("#submitDelete").click(function(){
		mode = $('input[name="mode"]').val();
		groupTarget = $('select[name="groupTarget"]').val();
		$errFlag = false;
		if(!groupTarget || groupTarget === '' ) {
			alert('グループが選択されていません。');
			$errFlag = true;
		}
		if($errFlag === true){return false;}
	});

	//step1を選択するとstep2の内容が変わる
	$( 'input[name="mode"]:radio' ).change( function() {  
		var mode = ( $( this ).val());
		if(mode="new"){
			$(".for_mode_new").toggleClass("HideIt");
			$(".for_mode_edit").toggleClass("HideIt");
		} else {
			$(".for_mode_new").toggleClass("HideIt");
			$(".for_mode_edit").toggleClass("HideIt");
		}
	});

	//選択ユーザーが0のとき対策
	function ToggleNoUserTR(action){
		var len = $("#tableForSelectTo tbody").children('tr').length;
		var action = action;
		if(action === 'add' && len === 2){
			$("#tableForSelectTo tr td.dataTables_empty").parent('tr').css("display","none");
		}
		if(action === 'remove' && len === 1){
			$("#tableForSelectTo tr td.dataTables_empty").parent('tr').css("display","block");
		}
	}

} );//end of document.ready


//配列から重複を削除
function makeUniqueArray(array) {
	var storage = {};
	var uniqueArray = [];
	var i,value;
	for ( i=0; i<array.length; i++) {
		value = array[i];
		if (!(value in storage)) {
			storage[value] = true;
			uniqueArray.push(value);
		}
	}
	return uniqueArray;
}


//配列から該当要素を除去
function deleteFromArray(arr,item){
	myArray = arr;
	var len = myArray.length - 1;
	var i;
	for(i = len; i >= 0; i--){
		if(myArray[i] == item){
			myArray.splice(i,1);
		}
	}
	return myArray;
}


//配列をソート
function sortArrayByID(arr) {
	myArray = arr;
	myArray.sort(function(myArray, b){
		return myArray - b;
	});
	return myArray;
}