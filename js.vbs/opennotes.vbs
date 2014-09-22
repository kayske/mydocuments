'Notes
Set objWShell = CreateObject("WScript.Shell")
objWShell.Run "C:\Lotus\Notes7\nlnotes.exe -SA '=C:\Lotus\Notes7\9W3RY\notes.ini'"
WScript.Sleep 5000
objWShell.AppActivate "9W3RY"
objWShell.SendKeys "+lts+nts201310"
objWShell.SendKeys "~"
'ワークスペースの9W3RYをマウスクリック
'http://3rd.geocities.jp/kaito_extra/Source/MouseCtrl.html
Set objWShell = Nothing
