Option Explicit

Dim objwshell

'PC�N�����p�ɂ���v���Z�X���N�����Ă��Ȃ��Ƒ҂�
'http://yozda.exblog.jp/15574326

'�iBB4U�j
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\�r��\js.vbs\openbb4u.vbs", 1, false
set objwshell = nothing

'VA�|�[�^��
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\�r��\js.vbs\openvaportal.vbs", 1, false
set objwshell = nothing
WScript.Sleep 500

'NetworkPass
Dim objWshNetwork
Set objWshNetwork = WScript.CreateObject("WScript.Network")
Dim objFSO
Set objFSO = WScript.CreateObject("Scripting.FileSystemObject")
'�ڑ��ς݂̃l�b�g���[�N�h���C�u�𒲍����A���ڑ��Ȃ�ڑ�����
If Not objFSO.DriveExists("Z:") Then
    objWshNetwork.MapNetworkDrive "Z:", "\\Uninas05.uninas.mew.co.jp\UN1345I", False, "E182414@japan.gds.panasonic.com", "Ikb1406" 'or"ftf417"
End If

Set objFSO = Nothing
Set objWshNetwork = Nothing

 
'Schedule Watcher
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\�r��\js.vbs\opensch.vbs", 1, false
set objwshell = nothing
WScript.Sleep 3000

'���Ă��[
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\�r��\js.vbs\openotecall.vbs", 1, false
set objwshell = nothing
WScript.Sleep 500
'Notes
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\�r��\js.vbs\opennotes.vbs", 1, false
set objwshell = nothing
WScript.Sleep 1000

'esmile
'�v�C��
set objwshell = createobject("wscript.shell")
objwshell.run "C:\Users\cl3\Documents\�r��\js.vbs\openesmiletest.vbs", 1, false
set objwshell = nothing