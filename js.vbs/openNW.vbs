'NetworkPass
Dim objWshNetwork
 Set objWshNetwork = WScript.CreateObject("WScript.Network")
 objWshNetwork.MapNetworkDrive "Z:", "\\Uninas05.uninas.mew.co.jp\UN1345I", False, "E182414@japan.gds.panasonic.com", "Ikb1409" 'or"ftf417"
Set objWshNetwork = Nothing