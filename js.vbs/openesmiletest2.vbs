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
WScript.sleep(2000)
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

Do Until objIE.Busy = False
   '�󃋁[�v���Ɩ��ʂ�CPU���g���̂�250�~���b�̃C���^�[�o����u��
   WScript.sleep(250)
Loop

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
