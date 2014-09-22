Option Explicit

Dim objIE
Dim objWShell
Dim objWshShell
Dim wshshell
Dim i
Dim objShell
Dim objWindow

'vaポータル
Set objIE = WScript.CreateObject("InternetExplorer.Application")
objIE.Navigate2 "http://portal.arrow.mew.co.jp/wps/"
objIE.Top = 0:objIE.Left = 0:objIE.Statusbar = false:objIE.Toolbar = false
Do While objIE.Busy = True Or objIE.readystate <> 4
	WScript.Sleep 1000
Loop

objIE.Visible = True
WScript.Sleep 1000

Dim TheForm
Set TheForm = objIE.Document.forms("form1")
If TheForm is nothing then
else
'各項目を設定して検索
objIE.Document.form1.uid.value = "E182414"
objIE.Document.form1.psw.value = "Tgikb1407"
objIE.Document.form1.submit

WScript.Sleep 3000

end if

Set objIE =Nothing
Set objWshShell =Nothing
Set TheForm =Nothing
