	$(function() {
		<!-- �_�C�A���O�̃t�H�[���v�f�擾 -->
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
		// �����̒����w��
		// @param o �t�H�[���v�f
		// @param n �t�H�[����
		function checkLength( o, n, min, max ) {
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips(n + "��" +
					min + "�����ȏ�" + max + "�����ȉ��œ��͂��Ă��������B" );
				return false;
			} else {
				return true;
			}
		}
		// �����p�^�[��
		function checkRegexp( o, regexp, n ) {
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass( "ui-state-error" );
				updateTips( n );
				return false;
			} else {
				return true;
			}
		}
		
		// �p�X���[�h�m�F
		function checkPassword(){
			if (password.val() === confPassword.val())
				return true;
			else{
				confPassword.addClass("ui-state-error");
				updateTips("�p�X���[�h����v���Ă��܂���B�ēx���͂��Ă�������");
				return false;
			}
		}
		
		// �����Ń_�C�A���O�̃I�v�V�����w��
		$( "#dialog-form" ).dialog({
			autoOpen: false, // true�ɂ���Ɖ�ʂ����[�h���ꂽ���Ɏ����Ń_�C�A���O���I�[�v������܂��B
			height: 300, // �傫���w��
			width: 350,
			modal: true, // ���[�_���_�C�A���O�i�_�C�A���O���J���Ă���Ԃ͑��̑��삪�o���Ȃ��j�w��
			show: "explode", // �J�����ƕ���Ƃ��̃A�j���[�V�����w��ł��B
			hide: "explode",
			buttons: { // �����Ŋe�{�^�������������̏����������܂��B
				"�p�X���[�h�Ĕ��s": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );
					// �����̒������o���f�[�V����
					bValid = bValid && checkLength( email, "email", 6, 80 );
					bValid = bValid && checkLength( password, "password", 5, 16 );
					bValid = bValid && checkPassword();
					
					// E-mail�̕����p�^�[���o���f�[�V����
					bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "���͓��e������������܂���B ��Fhoge@hoge.com" );

					// �o���f�[�g���ʂ������̏���
					if ( bValid ) {
						alert("OK");
						$( this ).dialog( "close" );
					}
				},
				"�L�����Z��": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});
		// �����Ń{�^�������������Ƀ_�C�A���O��OPEN�ɂ��Ă��܂�
		$( "#create-user" )
			.button()
			.click(function() {
				$( "#dialog-form" ).dialog( "open" );
		});
	});
