Option Explicit

Dim objIE
Dim i
Dim objShell
Dim objWindow
Dim HTMLSorce
Dim HURL
Dim HFrame
Dim Ftitle
Dim objFso
Dim objFile


'���Ă��[
'Set objIE = WScript.CreateObject("InternetExplorer.Application")
'objIE.Visible = true
'objIE.Navigate2 "http://133.254.134.34/"
'objIE.Top = 0:objIE.Left = 0
'WScript.Sleep 3000
'WScript.Sleep 3000
Set objShell = Nothing
'�V�F���̃I�u�W�F�N�g���쐬����
Set objShell = CreateObject("Shell.Application")
'��������A�E�C���h�E�̐������܂킵�A�N������IE��T���Ă݂܂����B
    i = 0
    For Each objWindow In objShell.Windows
        'HTMLDocument��������
        If TypeName(objWindow.document) = "HTMLDocument" Then
            '�I�u�W�F�N�g��������
	    Set objIE = objWindow
            WScript.Echo "Window���F" & objIE.Document.title & ":" & i & "/" & objShell.Windows.Count
	    If objIE.Document.title = "�u�` Portal" Then
        	Exit For  '���߂Ɍ������I�u�W�F�N�g�������Ĕ�����
            End If
        End If
    i = i + 1
    Next
Set objShell = Nothing

HFrame = objIE.document.frames.Length

msgbox "�t���[��0�^�C�g���F" & objIE.Document.frames(0).Document.title

'�t���[��������ꍇ
If HFrame <> 0 Then
    For i=0 To HFrame
	Ftitle = objIE.Document.frames(i).Document.title
	Dim HTML2Sorce
	HTML2Sorce = objIE.Document.Body.InnerHTML
	HTMLSorce = objIE.Document.frames(i).Document.Body.InnerHTML
	WScript.Echo Ftitle

	Set objFso = CreateObject("Scripting.FileSystemObject")
	Set objFile = objFso.OpenTextFile("C:\Users\cl3\Documents\�r��\" & i & Ftitle & "body.txt", 2, True)

	'�G���[����
	If Err.Number > 0 Then
	    WScript.Echo "Open Error"
	Else
	    'HTML�̃\�[�X���e�L�X�g�t�@�C���ɏ�������
	    objFile.WriteLine HTML2Sorce
'	    WScript.Echo Ftitle & "�e�L�X�g�ɕۑ����܂���"
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
End If

Wscript.Echo "�I��"
Set objFso =Nothing
Set objFile =Nothing
Set Ftitle =Nothing
Set objIE =Nothing
Set objShell = Nothing
Set objWindow =Nothing
Set HTMLSorce =Nothing
Set HURL =Nothing
Set HFrame =Nothing
