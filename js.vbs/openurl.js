//  
//  Internet Explorer操作 (IEバージョン6)
//  
//  　Internet Explorerの起動と終了。
//  

//  読み込み状態
var READYSTATE_UNINITIALIZED  = 0;  // 初期化中
var READYSTATE_LOADING        = 1;  // 表示データ読み込み中
var READYSTATE_LOADED         = 2;  // 表示データ読み込み完了
var READYSTATE_INTERACTIVE    = 3;  // データの表示中
var READYSTATE_COMPLETE       = 4;  // 全てのデータが表示終了

//  Internet Explorerオブジェクトを取得(Internet Explorerの起動)
var IEApp = new ActiveXObject( "InternetExplorer.Application" );

//  Internet Explorerアプリケーションを表示
IEApp.Visible = true;
IEApp.Left = 0;
IEApp.Top = 0;
IEApp.Width = 900;
IEApp.Height = 800;

//  おてこーを表示
//IEApp.Navigate( "http://133.254.134.34/" );
IEApp.Navigate( "http://office.yahoo.co.jp/" );

//  ページの読み込みが終わるまで処理を止める
while( IEApp.Busy  &&  IEApp.ReadyState == READYSTATE_LOADING )
    WScript.Sleep( 500 );   // ループスピードを抑えるための処理

WScript.Sleep( 500 );

//  オブジェクトを解放
IEApp = null;

//  Internet Explorerオブジェクトを取得(Internet Explorerの起動)
var IEApp = new ActiveXObject( "InternetExplorer.Application" );

//  Internet Explorerアプリケーションを表示
IEApp.Visible = true;
IEApp.Left = 800;
IEApp.Top = 0;
IEApp.Width = 1000;
IEApp.Height = 500;

//実験
var ie = new ActiveXObject('InternetExplorer.Application');
ie.navigate('about:blank');
WScript.echo(ie.document.parentWindow.screen.width);
WScript.echo(ie.document.parentWindow.screen.height);
ie.quit();
ie = null;

//  おてこーを表示
IEApp.Navigate( "http://bb4u.excite.co.jp/" );
WScript.echo(IEApp.document.parentWindow.screen.height);

//  ページの読み込みが終わるまで処理を止める
while( IEApp.Busy  &&  IEApp.ReadyState == READYSTATE_COMPLETE )
    WScript.Sleep( 500 );   // ループスピードを抑えるための処理

WScript.Sleep( 3000 );

WScript.Echo( "完了" );

//  オブジェクトを解放
IEApp = null;

