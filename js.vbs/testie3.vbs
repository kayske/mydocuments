Option Explicit

Dim CDate

'�n�[���t(**/**)
Set CDate = "11/1"

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
'            WScript.Echo objIE.Document.title & ":" & i & "/" & objShell.Windows.Count
	    If objIE.Document.title = "���Ă���R�[���Z���^�[" Then
        	Exit For  '���߂Ɍ������I�u�W�F�N�g�������Ĕ�����
            End If
        End If
    i = i + 1
    Next
Set objShell = Nothing

Wscript.Echo objIE.Document.frames(2).Document.title

objIE.Document.frames(2).f1.fRECP_OP_FL.checked = False
objIE.Document.frames(2).f1.fCORP_CD.value = "COS"
objIE.Document.frames(2).f1.fCOPE_STAT_FL.selectedIndex = 0
objIE.Document.frames(2).f1.fRECP_DATE_FL.checked = True
objIE.Document.frames(2).f1.fRECP_DATE1.value = CDate
objIE.Document.frames(2).f1.Item(25).Click
'Dim submit
'For i=15 To 25
'	submit = objIE.Document.frames(2).f1.Item(i).Value
'	Wscript.Echo submit & "/" & i
'Next
'IE�I�u�W�F�N�g.Document.�t�H�[����.�e�L�X�g�{�b�N�X(hidden)��.value = �ݒ肵�������e

'IEShell.Windows.Item(i).document.frames("frame1").myFORM.text.value="�t�H�[���ɏ������݂�����e"















If false Then
HFrame = objIE.document.frames.Length

'�t���[��������ꍇ
If HFrame <> 0 Then
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

end if
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
