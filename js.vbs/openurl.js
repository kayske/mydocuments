//  
//  Internet Explorer���� (IE�o�[�W����6)
//  
//  �@Internet Explorer�̋N���ƏI���B
//  

//  �ǂݍ��ݏ��
var READYSTATE_UNINITIALIZED  = 0;  // ��������
var READYSTATE_LOADING        = 1;  // �\���f�[�^�ǂݍ��ݒ�
var READYSTATE_LOADED         = 2;  // �\���f�[�^�ǂݍ��݊���
var READYSTATE_INTERACTIVE    = 3;  // �f�[�^�̕\����
var READYSTATE_COMPLETE       = 4;  // �S�Ẵf�[�^���\���I��

//  Internet Explorer�I�u�W�F�N�g���擾(Internet Explorer�̋N��)
var IEApp = new ActiveXObject( "InternetExplorer.Application" );

//  Internet Explorer�A�v���P�[�V������\��
IEApp.Visible = true;
IEApp.Left = 0;
IEApp.Top = 0;
IEApp.Width = 900;
IEApp.Height = 800;

//  ���Ă��[��\��
//IEApp.Navigate( "http://133.254.134.34/" );
IEApp.Navigate( "http://office.yahoo.co.jp/" );

//  �y�[�W�̓ǂݍ��݂��I���܂ŏ������~�߂�
while( IEApp.Busy  &&  IEApp.ReadyState == READYSTATE_LOADING )
    WScript.Sleep( 500 );   // ���[�v�X�s�[�h��}���邽�߂̏���

WScript.Sleep( 500 );

//  �I�u�W�F�N�g�����
IEApp = null;

//  Internet Explorer�I�u�W�F�N�g���擾(Internet Explorer�̋N��)
var IEApp = new ActiveXObject( "InternetExplorer.Application" );

//  Internet Explorer�A�v���P�[�V������\��
IEApp.Visible = true;
IEApp.Left = 800;
IEApp.Top = 0;
IEApp.Width = 1000;
IEApp.Height = 500;

//����
var ie = new ActiveXObject('InternetExplorer.Application');
ie.navigate('about:blank');
WScript.echo(ie.document.parentWindow.screen.width);
WScript.echo(ie.document.parentWindow.screen.height);
ie.quit();
ie = null;

//  ���Ă��[��\��
IEApp.Navigate( "http://bb4u.excite.co.jp/" );
WScript.echo(IEApp.document.parentWindow.screen.height);

//  �y�[�W�̓ǂݍ��݂��I���܂ŏ������~�߂�
while( IEApp.Busy  &&  IEApp.ReadyState == READYSTATE_COMPLETE )
    WScript.Sleep( 500 );   // ���[�v�X�s�[�h��}���邽�߂̏���

WScript.Sleep( 3000 );

WScript.Echo( "����" );

//  �I�u�W�F�N�g�����
IEApp = null;

