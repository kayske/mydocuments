	$(function() {
		<!-- ダイアログのフォーム要素取得 -->
		var email = $( "#email" ),
		password = $( "#password" ),
		confPassword = $("#confPassword"),
		allFields = $( [] ).add( email ).add( password ).add(confPassword),
		tips = $( ".validateTips" );

		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}
		// 文字の長さ指定
		// @param o フォーム要素
		// @param n フォーム名
		function checkLength( o, n, min, max ) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips(n + "は" +
					min + "文字以上" + max + "文字以下で入力してください。" );
				return false;
			} else {
				return true;
			}
		}
		// 文字パターン
		function checkRegexp( o, regexp, n ) {
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass( "ui-state-error" );
				updateTips( n );
				return false;
			} else {
				return true;
			}
		}
		
		// パスワード確認
		function checkPassword(){
			if (password.val() === confPassword.val())
				return true;
			else{
				confPassword.addClass("ui-state-error");
				updateTips("パスワードが一致していません。再度入力してください");
				return false;
			}
		}
		
		// ここでダイアログのオプション指定
		$( "#dialog-form" ).dialog({
			autoOpen: false, // trueにすると画面がロードされた時に自動でダイアログがオープンされます。
			height: 300, // 大きさ指定
			width: 350,
			modal: true, // モーダルダイアログ（ダイアログが開いている間は他の操作が出来ない）指定
			show: "explode", // 開く時と閉じるときのアニメーション指定です。
			hide: "explode",
			buttons: { // ここで各ボタンを押した時の処理を書きます。
				"パスワード再発行": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );
					// 文字の長さをバリデーション
					bValid = bValid && checkLength( email, "email", 6, 80 );
					bValid = bValid && checkLength( password, "password", 5, 16 );
					bValid = bValid && checkPassword();
					
					// E-mailの文字パターンバリデーション
					bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "入力内容が正しくありません。 例：hoge@hoge.com" );

					// バリデートが通った時の処理
					if ( bValid ) {
						alert("OK");
						$( this ).dialog( "close" );
					}
				},
				"キャンセル": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});
		// ここでボタンを押した時にダイアログをOPENにしています
		$( "#create-user" )
			.button()
			.click(function() {
				$( "#dialog-form" ).dialog( "open" );
		});
	});
