Option Explicit

Dim objIE
Dim objWshShell
Dim i
Dim objShell
Dim objWindow

'���Ă��[
Set objIE = WScript.CreateObject("InternetExplorer.Application")
objIE.Navigate2 "http://133.254.134.34/"
objIE.Top = 0:objIE.Left = 0
WScript.Sleep 3000
Set objWshShell = CreateObject("Wscript.Shell")
objWshShell.SendKeys ("~")
WScript.Sleep 3000

'�V�F���̃I�u�W�F�N�g���쐬����
Set objShell = CreateObject("Shell.Application")
'��������A�E�C���h�E�̐������܂킵�A�N������IE��T���Ă݂܂����B
    i = 0
    For Each objWindow In objShell.Windows
        'HTMLDocument��������
        If TypeName(objWindow.document) = "HTMLDocument" Then
            '�I�u�W�F�N�g��������
	    Set objIE = objWindow
	    If objIE.Document.title = "���Ă���R�[���Z���^�[" Then
        	Exit For  '���߂Ɍ������I�u�W�F�N�g�������Ĕ�����
            End If
        End If
    i = i + 1
    Next
Set objShell = Nothing

'�e���ڂ�ݒ肵�Č���
objIE.Document.frames(2).f.fOP_ID.value = "2783"
objIE.Document.frames(2).f.fPW.value = "2783cc"
objIE.Document.frames(2).f.Item(4).Click
Set objIE =Nothing
Set objWshShell =Nothing
