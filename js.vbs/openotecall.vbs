Option Explicit

Dim objIE
Dim objWshShell
Dim i
Dim objShell
Dim objWindow

'おてこー
Set objIE = WScript.CreateObject("InternetExplorer.Application")
objIE.Navigate2 "http://133.254.134.34/"
objIE.Top = 0:objIE.Left = 0
WScript.Sleep 3000
Set objWshShell = CreateObject("Wscript.Shell")
objWshShell.SendKeys ("~")
WScript.Sleep 3000

'シェルのオブジェクトを作成する
Set objShell = CreateObject("Shell.Application")
'ここから、ウインドウの数だけまわし、起動中のIEを探してみました。
    i = 0
    For Each objWindow In objShell.Windows
        'HTMLDocumentだったら
        If TypeName(objWindow.document) = "HTMLDocument" Then
            'オブジェクトを代入する
	    Set objIE = objWindow
	    If objIE.Document.title = "おてがるコールセンター" Then
        	Exit For  '初めに見つけたオブジェクトを代入して抜ける
            End If
        End If
    i = i + 1
    Next
Set objShell = Nothing

'各項目を設定して検索
objIE.Document.frames(2).f.fOP_ID.value = "2783"
objIE.Document.frames(2).f.fPW.value = "2783cc"
objIE.Document.frames(2).f.Item(4).Click
Set objIE =Nothing
Set objWshShell =Nothing
