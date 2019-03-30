from config import *
from flask import render_template,request,flash,redirect, url_for
from werkzeug.utils import secure_filename
import zipfile
import tempfile
import random
import time
import string




@app.route('/index', methods=['GET','POST'])
@app.route('/', methods=['GET','POST'])
def main():
    return render_template('home.html')


@app.route('/about', methods=['GET','POST'])
def about():
    return render_template('home.html')


@app.route('/check', methods=['GET','POST'])
def check():
    if request.method == 'POST':
        code = request.form['code']
        result = allcheckcode(code)
        flash(result)
        return render_template('check.html')
    return render_template('check.html')

@app.route('/api', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        files = request.files['file']
        if files:
            filename = secure_filename(files.filename)
            filename = bytes(str(filename)+str(time.time()),'utf-8')
            filename = hashlib.sha224(filename).hexdigest()
            files.save(os.path.join('/tmp/', filename))
            code = open('/tmp/'+filename).read()
            result = allcheckcode(code)
            if result == 'M':
                return '木马文件!'
            else:
                return '正常文件。'


def un_zip(file_name):
    allfile = []
    """unzip zip file"""
    path = os.path.split(file_name)[0]
    zip_file = zipfile.ZipFile(file_name)    
    for names in zip_file.namelist():
        if names.endswith('/'):
            os.mkdir(os.path.join(path, names))
        else:
            allfile.append(os.path.join(path,names))
            zip_file.extract(names,path)
    zip_file.close()
    data = runall(allfile)
    #data = zipcheck(allfile).run()
    return data

@app.route('/add', methods=['POST', 'GET'])
def add_file():

    filefolder = tempfile.gettempdir()

    if request.method == 'POST':
        files = request.files['file']
        data = files.read()
        if len(data) > 3145728:
            data = ['文件太大 :(']
            flash(data)
            return redirect(url_for('add_file'))
        filename = secure_filename(files.filename)
        randstr = ''.join([random.choice(string.ascii_lowercase) for _ in range(16)])
        dirpath = '/tmp/'+randstr+filename.split('.')[0]
        try:
            os.mkdir(dirpath)
        except:
            pass
        file_path = os.path.join(dirpath,
                                  '{}_{}.zip'
                                  .format(randstr,int(time.time())))
        open(file_path,'wb').write(data)
        try:
            data = un_zip(file_path)
        except Exception as e:
            print(e)
            data = ['zip error']
        alllen = len(data)
        right = 0
        error = 0
        for i in data:
            if ':N' in i:
                right = right+1
            else:
                error = error+1
        flash(data)
        return render_template('add_file.html',alllen=alllen,right=right,error=error)
    return render_template('add_file.html')


app.run('0.0.0.0',5000,debug=True)
