Option Explicit

Dim objIE
Dim objWShell
Dim objWshShell
Dim wshshell
Dim i
Dim objShell
Dim objWindow

'esmile
Set objIE = WScript.CreateObject("InternetExplorer.Application")
objIE.Navigate2 "http://133.254.64.146/Web/BaseFrame.htm"
objIE.Top = 0:objIE.Left = 0
WScript.Sleep 2000

'�V�F���̃I�u�W�F�N�g���쐬����
Set objShell = CreateObject("Shell.Application")
'��������A�E�C���h�E�̐������܂킵�A�N������IE��T���Ă݂܂����B
    i = 0
    For Each objWindow In objShell.Windows
        'HTMLDocument��������
        If TypeName(objWindow.document) = "HTMLDocument" Then
            '�I�u�W�F�N�g��������
	    Set objIE = objWindow
	    If objIE.Document.title = "�y���C���zeSmileCall" Then
        	Exit For  '���߂Ɍ������I�u�W�F�N�g�������Ĕ�����
            End If
        End If
    i = i + 1
    Next
Set objShell = Nothing

'msgbox objIE.document.frames(2).Item.name
Do While objIE.document.frames.Length < 2
      WScript.Sleep 2000
Loop

WScript.Sleep 5000

'�e���ڂ�ݒ肵�Č���
objIE.Document.frames(2).aspnetForm.ctl00_ContentPlaceHolder1_login_textBoxOperatorId.value = "2267"
objIE.Document.frames(2).aspnetForm.ctl00_ContentPlaceHolder1_login_textBoxPassword.value = "2267bb"
objIE.Document.frames(2).aspnetForm.ctl00_ContentPlaceHolder1_login_buttonLogin.Click

WScript.Sleep 3000
Set objWshShell = CreateObject("Wscript.Shell")
objWshShell.SendKeys ("~")
WScript.Sleep 1000

Set objIE =Nothing
Set objWshShell =Nothing
