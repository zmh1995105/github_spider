# -*- coding: utf-8 -*-
import os, logging

NAME, VERSION, AUTHOR, LICENSE = "CodeInspect", "V0.1", "咚咚呛", "Public (FREE)"

# 代码路径
CODE_DIR_LIST = ['/root/tool/PubilcAssetInfo', '/home/seclogin/test_gdd/testbbb', '/home/seclogin/test_gdd/testrsync']
# 代码同步方式 git / svn / rsync
TYPE = 'rsync'
# 是否执行代码恢复，True / False
ACTION = True
# 可疑文件存放的地方
TMP = '/tmp/codeinspect/'
# rsync服务的登录,替换其中的IP、账户、密码文件
RSYNC_LOGIN_INFO = 'rsync --password-file=/etc/pass.txt test@192.168.1.5::web'


def loging():
    log_file = '/var/log/codeinspect.log'
    logging.basicConfig(
        level=logging.INFO,
        format='%(asctime)s - %(name)s - %(message)s'
    )
    logger = logging.getLogger('LogInfo')
    fh = logging.FileHandler(log_file)
    fh.setLevel(logging.INFO)
    formatter = logging.Formatter('%(asctime)s - %(name)s - %(message)s')
    fh.setFormatter(formatter)
    logger.addHandler(fh)
    return logger


def get_diff(path):
    exception_list = []
    if TYPE == 'git':
        exception_list = os.popen("cd %s && git status -s | awk '{print $2}'" % path).readlines()
    elif TYPE == 'svn':
        exception_list = os.popen("cd %s && svn status | awk '{print $2}'" % path).readlines()
    elif TYPE == 'rsync':
        infos = os.popen("cd %s && %s %s --delete -vzrtopg -n" % (path, RSYNC_LOGIN_INFO, path)).readlines()
        for info in infos:
            if 'deleting' in info:
                exception_list.append(info.replace('deleting ', ''))
        if len(exception_list) > 10:
            exception_list = []

    return exception_list


def action(path, exception_list):
    if TYPE == 'git':
        os.system("cd %s && git checkout . && git clean -df" % path)
    elif TYPE == 'svn':
        os.system("cd %s && svn revert -R ." % path)
        if len(exception_list) > 0:
            for file in exception_list:
                file = file.strip().strip('\n')
                if file:
                    if os.path.isfile("%s/" % path + file):
                        os.remove("%s/" % path + file)
                    else:
                        __import__('shutil').rmtree("%s/" % path + file)
    elif TYPE == 'rsync':
        os.popen("cd %s && %s %s --delete -vzrtopg" % (path, RSYNC_LOGIN_INFO, path))


if __name__ == '__main__':
    logger = loging()
    if not os.path.exists(TMP): os.mkdir(TMP)

    for path in CODE_DIR_LIST:
        if not os.path.exists(path): continue
        exception_list = get_diff(path)
        if len(exception_list) > 0:
            for file in exception_list:
                file = file.strip().strip('\n')
                os.system("cd %s && cp -R %s /tmp/codeinspect/" % (path, file))
                logger.info("Find Exception File OR Dir : %s/%s" % (path, file))
                logger.info(" ")
            if ACTION:
                action(path, exception_list)
