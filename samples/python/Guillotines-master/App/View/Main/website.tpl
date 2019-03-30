<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>受控站点 - Guillotines</title>
    <link rel="stylesheet" href="/Public/css/library/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="/Public/css/library/sweetalert.css">
	<link rel="stylesheet" href="/Public/css/branch/base.css">
    <link rel="stylesheet" href="/Public/css/branch/Main_website.css">
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
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default">添加WebShell</button>
                <button type="button" class="btn btn-default">批量添加</button>
                <button type="button" class="btn btn-default">批量删除</button>
            </div>
            <div class="btn-group" role="group">
				<button type="button" class="btn btn-default" onclick="webshellList(1)">首页</button>
			    <button type="button" class="btn btn-default" onclick="webshellList($('.list-page').text()-1)">上一页</button>
				<button type="button" class="btn btn-default" onclick="webshellList(($('.list-page').text()*1+1))">下一页</button>
				<button type="button" class="btn btn-default">当前第<span class="list-page">1</span>页</button>
				<button type="button" class="btn btn-default">共<span class ="totol-page">{{total_page}}</span>页</button>
            </div>
            <button class="button-info">WebShell总数：<b class="webshell-totol">{{total_webshell}}</b></button>
            <button class="button-info button-info-refresh" onclick="webshellList(($('.list-page').text()*1))"><span class="glyphicon glyphicon-refresh"></span></button>
            <table class="table">
                <thead>
                    <tr>
                        <th>序列</th>
                        <th>地址</th>
                        <th>类别</th>
                        <th>时间</th>
                        <th>功能</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
			<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myLargeModalLabel">WebShell管理</h4>
						</div>
						<div class="modal-body">
							<ul class="nav nav-pills nav-justified" role="tablist">
							</ul>
							<div class="tab-content webshellManagementContent">
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="/Public/js/library/jquery.js"></script>
<script type="text/javascript" src="/Public/js/library/bootstrap.js"></script>
<script type="text/javascript" src="/Public/js/library/sweetalert.js"></script>
<script type="text/javascript" src="/Public/js/branch/base.js"></script>
<script type="text/javascript" src="/Public/js/branch/Main_website.js"></script>
<script>
$('.nav-justified:first a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});
</script>
</html>
