'ÅiBB4UÅj
Set objIE = Wscript.CreateObject("InternetExplorer.Application")
objIE.Navigate2 "http://bb4u.excite.co.jp/"
objIE.Top = 0:objIE.Left = 550
objIE.Width = 1050:objIE.Height = 870
objIE.Toolbar = 0:objIE.Statusbar = 0
objIE.Visible = TRUE
Set objIE =Nothing
