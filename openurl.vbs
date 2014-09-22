Option Explicit

Dim objwshell

'PC起動時用にあるプロセスが起動していないと待ち
'http://yozda.exblog.jp/15574326

'（BB4U）
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\池辺\js.vbs\openbb4u.vbs", 1, false
set objwshell = nothing

'VAポータル
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\池辺\js.vbs\openvaportal.vbs", 1, false
set objwshell = nothing
WScript.Sleep 500

'NetworkPass
Dim objWshNetwork
Set objWshNetwork = WScript.CreateObject("WScript.Network")
Dim objFSO
Set objFSO = WScript.CreateObject("Scripting.FileSystemObject")
'接続済みのネットワークドライブを調査し、未接続なら接続する
If Not objFSO.DriveExists("Z:") Then
    objWshNetwork.MapNetworkDrive "Z:", "\\Uninas05.uninas.mew.co.jp\UN1345I", False, "E182414@japan.gds.panasonic.com", "Ikb1406" 'or"ftf417"
End If

Set objFSO = Nothing
Set objWshNetwork = Nothing

 
'Schedule Watcher
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\池辺\js.vbs\opensch.vbs", 1, false
set objwshell = nothing
WScript.Sleep 3000

'おてこー
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\池辺\js.vbs\openotecall.vbs", 1, false
set objwshell = nothing
WScript.Sleep 500
'Notes
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\池辺\js.vbs\opennotes.vbs", 1, false
set objwshell = nothing
WScript.Sleep 1000

'esmile
'要修正
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\池辺\js.vbs\openesmiletest.vbs", 1, false
set objwshell = nothing