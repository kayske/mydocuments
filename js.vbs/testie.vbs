Option Explicit

Dim objIE
Dim objWShell
Dim objWshShell
Dim wshshell
Dim i
Dim objShell
Dim objWindow
Dim nFLG
Dim HTMLSorce
Dim HURL
Dim HFrame
Dim objFrm
Dim Ftitle

'���Ă��[
Set objIE = WScript.CreateObject("InternetExplorer.Application")
objIE.Navigate2 "http://133.254.134.34/"
'WScript.Echo  objIE.Document.title
'objIE.Top = 0:objIE.Left = 0
'WScript.Sleep 3000
'Set objWshShell = CreateObject("Wscript.Shell")
'objWshShell.SendKeys ("~")
WScript.Sleep 3000
Set objIE =Nothing
'Set objWshShell =Nothing

'�V�F���̃I�u�W�F�N�g���쐬����
Set objIE = CreateObject("InternetExplorer.Application")
Set objShell = CreateObject("Shell.Application")
'��������A�E�C���h�E�̐������܂킵�A�N������IE��T���Ă݂܂����B
    i = 0
    For Each objWindow In objShell.Windows
	WScript.Echo TypeName(objWindow.document)
        'HTMLDocument��������
        If TypeName(objWindow.document) = "HTMLDocument" Then
	    Set objIE = objWindow
            WScript.Echo  objIE.Document.title & ":" & i & "/" & objShell.Windows.Count
	    If objIE.Document.title = "���Ă���R�[���Z���^�[" Then
		HFrame = objIE.document.frames.Length
		WScript.Echo HFrame & "�t���[��"
		Exit For  '���Ă���R�[���Z���^�[�I�u�W�F�N�g����
            End If
        End If
    i = i + 1
    Next
Set objShell = Nothing

'�t���[��������ꍇ
If HFrame <> 0 Then
If false then
Wscript.Echo objIE.Document.frames(1).Document.title
    For i=0 To HFrame
	Ftitle = objIE.Document.frames(i).Document.title
	HTMLSorce = objIE.Document.frames(i).Document.Body.InnerHTML
	WScript.Echo Ftitle

	Set objFso = CreateObject("Scripting.FileSystemObject")
	Set objFile = objFso.OpenTextFile("C:\Users\cl3\Documents\�r��\" & i & Ftitle & "body.txt", 2, True)

	'�G���[����
	If Err.Number > 0 Then
	    WScript.Echo "Open Error"
	Else
	    'HTML�̃\�[�X���e�L�X�g�t�@�C���ɏ�������
	    objFile.WriteLine HTMLSorce
	    WScript.Echo Ftitle & "�e�L�X�g�ɕۑ����܂���"
	    objFile.Close
	    If Ftitle = "��t����" Then
		WScript.Echo "�������܂�"
		Set objFile = objFso.OpenTextFile("C:\Users\cl3\Documents\�r��\" & i & "��t����body.txt", 1, True)

		'����
		Dim myText, inText, inText2
		Dim cText
		Dim Tline
		myText =""
		inText = InputBox("�������镶����")
		inText2 = InputBox("�������镶����2")
		Tline = 0
		Dim file2
		Set file2 = objFso.CreateTextFile("C:\Users\cl3\Documents\�r��\" & inText & "_" & inText2 & "�s.txt")   '�V�K�t�@�C���𐶐�����

		Do Until ( objFile.AtEndOfStream )
		    myText = objFile.ReadLine          '�P�s�ǂݍ���
		    '1�ڌ���
		    cText = InStr( myText, inText )      '��������
		    If cText <> 0 Then
			Tline = Tline + 1
			file2.WriteLine(Tline & " " & myText)        '�ۑ�����
		    End If
		    '2�ڌ���
		    cText = InStr( myText, inText2 )      '��������
		    If cText <> 0 Then
			Tline = Tline + 1
			file2.WriteLine(Tline & " " & myText)        '�ۑ�����
		    End If
		Loop
		objFile.Close
		file2.Close
		Exit For  '��t������̌������I������甲����
	    End If
	End If

	i = i + 1
    Next
end if
End If

Wscript.Echo "�I��"
Set objWshShell =Nothing
Set Ftitle =Nothing
Set objIE =Nothing
Set objShell = Nothing
Set objWindow =Nothing
Set HTMLSorce =Nothing
Set HURL =Nothing
Set HFrame =Nothing
