//  Internet Explorerオブジェクトを取得(Internet Explorerの起動)
var IEApp = new ActiveXObject( "InternetExplorer.Application" );

IEApp.Navigate( "http://bb4u.excite.co.jp/" );

//  Internet Explorerアプリケーションを表示
IEApp.Visible = true;
IEApp.Left = 800;
IEApp.Top = 0;
IEApp.Width = 1000;
//IEApp.Height = 500;
IEApp.StatusBar = false;
IEApp.MenuBar = false;


//実験
//var ie = new ActiveXObject('InternetExplorer.Application');
//ie.navigate('about:blank');
WScript.echo("aa");
//WScript.echo(IEApp.document.parentWindow.screen.width);
//WScript.echo(IEApp.document.parentWindow.screen.height);
//ie.quit();
//ie = null;

WScript.Sleep( 300 );

WScript.Echo( "完了" );

//  オブジェクトを解放
IEApp = null;

