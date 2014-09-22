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


'おてこー
'Set objIE = WScript.CreateObject("InternetExplorer.Application")
'objIE.Visible = true
'objIE.Navigate2 "http://133.254.134.34/"
'objIE.Top = 0:objIE.Left = 0
'WScript.Sleep 3000
'WScript.Sleep 3000
Set objShell = Nothing
'シェルのオブジェクトを作成する
Set objShell = CreateObject("Shell.Application")
'ここから、ウインドウの数だけまわし、起動中のIEを探してみました。
    i = 0
    For Each objWindow In objShell.Windows
        'HTMLDocumentだったら
        If TypeName(objWindow.document) = "HTMLDocument" Then
            'オブジェクトを代入する
	    Set objIE = objWindow
            WScript.Echo "Window数：" & objIE.Document.title & ":" & i & "/" & objShell.Windows.Count
	    If objIE.Document.title = "ＶＡ Portal" Then
        	Exit For  '初めに見つけたオブジェクトを代入して抜ける
            End If
        End If
    i = i + 1
    Next
Set objShell = Nothing

HFrame = objIE.document.frames.Length

msgbox "フレーム0タイトル：" & objIE.Document.frames(0).Document.title

'フレームがある場合
If HFrame <> 0 Then
    For i=0 To HFrame
	Ftitle = objIE.Document.frames(i).Document.title
	Dim HTML2Sorce
	HTML2Sorce = objIE.Document.Body.InnerHTML
	HTMLSorce = objIE.Document.frames(i).Document.Body.InnerHTML
	WScript.Echo Ftitle

	Set objFso = CreateObject("Scripting.FileSystemObject")
	Set objFile = objFso.OpenTextFile("C:\Users\cl3\Documents\池辺\" & i & Ftitle & "body.txt", 2, True)

	'エラー処理
	If Err.Number > 0 Then
	    WScript.Echo "Open Error"
	Else
	    'HTMLのソースをテキストファイルに書き込む
	    objFile.WriteLine HTML2Sorce
'	    WScript.Echo Ftitle & "テキストに保存しました"
	    objFile.Close
	    If Ftitle = "受付履歴" Then
		WScript.Echo "検索します"
		Set objFile = objFso.OpenTextFile("C:\Users\cl3\Documents\池辺\" & i & "受付履歴body.txt", 1, True)

		'検索
		Dim myText, inText, inText2
		Dim cText
		Dim Tline
		myText =""
		inText = InputBox("検索する文字列")
		inText2 = InputBox("検索する文字列2")
		Tline = 0
		Dim file2
		Set file2 = objFso.CreateTextFile("C:\Users\cl3\Documents\池辺\" & inText & "_" & inText2 & "行.txt")   '新規ファイルを生成する

		Do Until ( objFile.AtEndOfStream )
		    myText = objFile.ReadLine          '１行読み込む
		    '1個目検索
		    cText = InStr( myText, inText )      '検索する
		    If cText <> 0 Then
			Tline = Tline + 1
			file2.WriteLine(Tline & " " & myText)        '保存する
		    End If
		    '2個目検索
		    cText = InStr( myText, inText2 )      '検索する
		    If cText <> 0 Then
			Tline = Tline + 1
			file2.WriteLine(Tline & " " & myText)        '保存する
		    End If
		Loop
		objFile.Close
		file2.Close
		Exit For  '受付履歴内の検索が終わったら抜ける
	    End If
	End If

	i = i + 1
    Next
End If

Wscript.Echo "終了"
Set objFso =Nothing
Set objFile =Nothing
Set Ftitle =Nothing
Set objIE =Nothing
Set objShell = Nothing
Set objWindow =Nothing
Set HTMLSorce =Nothing
Set HURL =Nothing
Set HFrame =Nothing
