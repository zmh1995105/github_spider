package vipaser

import (
	"bufio"
	"encoding/base64"
	"errors"
	"fmt"
	"github.com/wulijun/go-php-serialize/phpserialize"
	"io"
	"io/ioutil"
	"net/http"
	"os"
	"regexp"
	"strconv"
	"strings"
)

const (
	SeverityNormal = 0
	SeverityLow    = 3
	SeverityMedium = 5
	SeverityHigh   = 8
)

type Vipaser struct {
	vpFPS              map[string]FPS
	vpSuspiciousFuncRE *regexp.Regexp
}

type FPS struct {
	re     *regexp.Regexp
	fpinfo FPInfo
}

//Fingerprint infomation
type FPInfo struct {
	FPName string
	FPRev  int
	/*
		1: malicious file not a shell
		2: potentially dangerous file (legit file but may be used by hackers)
	*/
	FPFlag     int
	FPFileType string
}

type SuspiciousDetail struct {
	FileLine int
	FuncName []string
}

type Result struct {
	FileName      string
	Severity      int
	Fingerprint   []FPInfo
	SuspiciousKey []SuspiciousDetail
}

var regexpStr string = `(?si)(preg_replace.*\/e|\bpassthru\b|\bshell_exec\b|\bexec\b|\bbase64_decode\b|\beval\b|\bsystem\b|\bproc_open\b|\bpopen\b|\bcurl_exec\b|\bcurl_multi_exec\b|\bparse_ini_file\b|\bshow_source\b)` +
	"|(?si)(`.*?\\$.*?`)"

func New(dbfile string) (*Vipaser, error) {
	var vp Vipaser
	var body []byte

	if _, err := os.Stat(dbfile); err == nil {
		if body, err = ioutil.ReadFile(dbfile); err != nil {
			return nil, err
		}
	} else {
		response, err := http.Get(dbfile)
		if err != nil {
			return nil, err
		}
		if response.StatusCode != 200 {
			return nil, errors.New(fmt.Sprintf("HTTP GET '%s' , retcode:[%d]", dbfile, response.StatusCode))
		}

		defer response.Body.Close()
		if body, err = ioutil.ReadAll(response.Body); err != nil {
			return nil, err
		}
	}
	content, err := base64.StdEncoding.DecodeString((string)(body))
	if err != nil {
		return nil, err
	}
	decodeRes, _ := phpserialize.Decode((string)(content))
	decodeData, ok := decodeRes.(map[interface{}]interface{})
	if !ok {
		return nil, errors.New("phpserialize decode failed.")
	}
	vp.vpFPS = make(map[string]FPS)

	for k, v := range decodeData {
		fingerprint, _ := k.(string)
		shellname, _ := v.(string)

		if fingerprint == "version" {
			continue
		}
		/* phpemailer[0][2][php] */
		shellInfo := strings.Split(strings.Replace(shellname, "]", "", -1), "[")

		var fps FPS
		fps.fpinfo.FPName = shellInfo[0]
		fps.fpinfo.FPRev, _ = strconv.Atoi(shellInfo[1])
		fps.fpinfo.FPFlag, _ = strconv.Atoi(shellInfo[2])
		fps.fpinfo.FPFileType = shellInfo[3]

		newFingerprint := fingerprint

		if strings.Contains(newFingerprint, "bb:") {
			newFingerprint = strings.Replace(newFingerprint, "bb:", "", 1)
			decodeFingerprint, err := base64.StdEncoding.DecodeString(newFingerprint)
			if err != nil {
				return nil, err
			}
			newFingerprint = (string)(decodeFingerprint)
		}
		if fps.re, err = regexp.Compile(regexp.QuoteMeta(newFingerprint)); err != nil {
			return nil, err
		}

		vp.vpFPS[fingerprint] = fps
	}

	if vp.vpSuspiciousFuncRE, err = regexp.Compile(regexpStr); err != nil {
		return nil, err
	}
	return &vp, nil
}

func (vp *Vipaser) Detect(file string, showline bool) (Result, error) {
	var result Result
	content, err := ioutil.ReadFile(file)
	if err != nil {
		return result, err
	}

	result.FileName = file
	result.Severity = SeverityNormal
	matches := vp.vpSuspiciousFuncRE.FindAll(content, -1)
	if matches != nil && len(matches) > 0 {
		result.Severity = SeverityMedium

		if showline {
			lineNum := 0

			f, err := os.Open(file)
			if err != nil {
				return result, err
			}
			defer f.Close()

			rd := bufio.NewReader(f)
			for {
				line, _, err := rd.ReadLine()
				if err != nil || io.EOF == err {
					break
				}

				lineNum += 1
				lineHits := vp.vpSuspiciousFuncRE.FindAll(line, -1)

				if lineHits != nil && len(lineHits) > 0 {
					var detail SuspiciousDetail
					detail.FileLine = lineNum
					for _, funcname := range lineHits {
						detail.FuncName = append(detail.FuncName, (string)(funcname))
					}
					result.SuspiciousKey = append(result.SuspiciousKey, detail)
				}
			}
		}
	}

	for _, fps := range vp.vpFPS {
		results := fps.re.FindAll(content, -1)

		if results != nil && len(results) > 0 {
			result.Severity = SeverityHigh
			result.Fingerprint = append(result.Fingerprint, fps.fpinfo)
		}
	}
	return result, nil
}
