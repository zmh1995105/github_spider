from App.Common.utils import makePass

#密码admin
#salt为1234567890
md5pass=makePass("21232f297a57a5a743894a0e4a801fc3"+"1234567890")
print(md5pass)
