var hashPage = parseInt(location.hash.split("")[1]);
function webshellList(){
	var page = "1";
	if(hashPage > "0" && hashPage <= parseInt($(".totol-page").text())){
		page = hashPage;
	}
	if(typeof(arguments[0]) === 'number'){
		page = arguments[0];
		if(arguments[0] == 0 || parseInt(page) > parseInt($(".totol-page").text())){
			return false;
		}
	}
	$.ajax({
		url: '/RootApi/webshell/list/' + page,
		type: 'get',
		dataType: 'json',
		async:false
	})
	.done(function(json){
		if(json.type == "success"){
			$(".table tbody").text("");
			$(".list-page").text(page);
			window.location = "#"+page;
			for(var i = 0;i < json.info.length;i++){
				$(".table tbody").append('\
					<tr>\
						<th>' + (i+1) + '</th>\
						<td class="webshell-url" data-url="' + myFun.base64.decode(json.info[i].url) + '" data-toggle="modal" data-target=".bs-example-modal-lg">' + myFun.base64.decode(json.info[i].url) + '</td>\
						<td>' + json.info[i].category + '</td>\
						<td data-time="' + json.info[i].time + '">' + json.info[i].time.split(" ")[0] + '</td>\
						<td class="webshell-pwd" style="display:none">' + json.info[i].password + '</td>\
						<td class="webshell-ip" style="display:none">' + json.info[i].ip + '</td>\
						<td class="webshell-address" style="display:none">' + json.info[i].address + '</td>\
						<td class="webshell-br" style="display:none">' + json.info[i].br + '</td>\
						<td class="webshell-pr" style="display:none">' + json.info[i].pr + '</td>\
						<td class="click-dropdown">\
							<div class="btn-group">\
								<button class="glyphicon glyphicon-th-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>\
								<ul class="dropdown-menu pull-right">\
									<li>\
										<a><span class="glyphicon glyphicon-edit"></span>编辑</a>\
									</li>\
									<li>\
										<a><span class="glyphicon glyphicon-eye-open"></span>浏览</a>\
									</li>\
									<li onClick="deleteWebshell(this)">\
										<a><span class="glyphicon glyphicon-trash"></span>删除</a>\
									</li>\
								</ul>\
							</div>\
						</td>\
					</tr>\
				');
			}
			myFun.substr(".webshell-url","80");
			showWebshellInfo();
		}
	})
}
function addWebShell(){
	$(".col-xs-9 .btn-group button:first").click(function(){
		swal({
			title: "添加WebShell",
			text: '<input type="text" class="form-control alert-input" placeholder="URL"><input type="text" class="form-control alert-input" placeholder="PassWord"><button id="scriptCategory" onClick="fun_scriptCategory()">脚本类型</button><ul class="dom-hidden"><li onClick="reviseButtonText(this)">PHP</li><li onClick="reviseButtonText(this)">ASP</li><li onClick="reviseButtonText(this)">JSP</li><li onClick="reviseButtonText(this)">ASPX</li></ul>',
			html: true,
			showCancelButton: true,
			closeOnConfirm: false,
			confirmButtonText:"添加",
			cancelButtonText:"取消",
		},
		function(){
			var url = $(".alert-input:first").val();
	    	var password = $(".alert-input:eq(1)").val();
	    	var scriptCategory = $(".sweet-alert #scriptCategory").text();
			if(url === "") {
				swal.showInputError("WebShell地址为空！");
				$(".alert-input:first").focus();
				return false;
			}
			if(password === ""){
				swal.showInputError("PassWord为空！");
				$(".alert-input:eq(1)").focus();
				return false;
			}
			if(scriptCategory === "脚本类型"){
				swal.showInputError("脚本类型为空！");
				return false;
			}
			$.ajax({
				url: '/RootApi/webshell/add',
				type: 'post',
				dataType: 'json',
				data:{
					url:url,
					password:password,
					category:scriptCategory.toUpperCase()
				},
				async:false
			})
			.done(function(data){
				if(data.type == "success"){
					swal({
					    title: "添加成功",
					    text: url + '<br/>' + password,
					    type: 'success',
					    html:true,
					    showCancelButton: false,
					    confirmButtonText:"确定",
					},function(){
						$(".table tbody tr").remove();
						webshellList();
						webshellTotal();
					});
				}
				else{
					swal({
						title: "添加失败",
						text: data.info,
						type: 'error',
						html:true,
						showCancelButton: false,
						confirmButtonText:"确定",
					});
				}
			})
		});
		$(".sweet-alert p input:eq(0)").blur(function(){
			var scriptFile,fileType,webshellFile;
			if($(this).val() == ""){
				return false;
			}
			scriptFile = ['PHP','ASP','ASPX','JSP'];
			webshellFile = myFun.parseURL($(this).val()).file.split(".").pop();
			if(webshellFile.indexOf("?") != "-1"){
				webshellFile = webshellFile.split("?")[0];
			}
			scriptFile.forEach(function(index, item){
				if(index == webshellFile.toUpperCase()){
					fileType = index;
				}
			})
			if(fileType){
				$("#scriptCategory").text(fileType);
			}else{
				$("#scriptCategory").text("脚本类型");
			}
		});
	})
}
function showWebshellInfo(){
	$(".table tbody tr").each(function(index,item){
    	$(item).find("td:first").click(function(){
			for(var i = 0;i < 4;i++){
				if($(".nav-justified:first li span").eq(i).text() == $(this).text()){
					$('.bs-example-modal-lg').modal();
					$(".nav-justified:first li").eq(i).find("a").click()
					return false;
				}
			}
			if($(".nav-justified:first li").length < 4){
				var webshellManagementLen = myFun.getRandomString(10);
				var webshellDomain = myFun.parseURL($(item).find("td:first").attr('data-url'));
				$(".nav-justified:first").append('\
				<li role="presentation">\
					<a href="#webshell' + webshellManagementLen + '" id="webshell-tab' + webshellManagementLen + '" role="tab" data-toggle="tab" aria-controls="webshell' + webshellManagementLen + '" aria-expanded="false">' + webshellDomain.host + '</a>\
					<span style="display:none">' + $(this).text() + '</span>\
					<button onClick="closeWebshellTab(this)">\
						<span class="glyphicon glyphicon-remove"></span>\
					</button>\
				</li>');
				$(".webshellManagementContent").append('\
				<div role="tabpanel" class="tab-pane fade" id="webshell' + webshellManagementLen + '" aria-labelledby="webshell-tab' + webshellManagementLen + '">\
					<ul class="nav nav-pills nav-justified" role="tablist">\
						<li role="presentation" class="active">\
							<a href="#websiteInfo' + webshellManagementLen + '" id="website-info' + webshellManagementLen + '">网站信息</a>\
						</li>\
						<li role="presentation">\
							<a href="#fileManagement' + webshellManagementLen + '" id="file-management' + webshellManagementLen + '">文件管理</a>\
						</li>\
						<li role="presentation">\
							<a href="#virtualTerminal' + webshellManagementLen + '" id="virtual-terminal' + webshellManagementLen + '">虚拟终端</a>\
						</li>\
						<li role="presentation">\
							<a href="#databaseManagement' + webshellManagementLen + '" id="database-management' + webshellManagementLen + '">数据库管理</a>\
						</li>\
					</ul>\
					<div class="tab-content">\
						<div role="tabpanel" class="tab-pane fade active in" id="websiteInfo' + webshellManagementLen + '" aria-labelledby="website-info' + webshellManagementLen + '">\
							<table>\
								<tr>\
									<td>\
										<span class="iconfont">&#xe606;</span>\
										<b><span>网站地址：</span></b>\
									</td>\
									<td>\
										<i><a href="' + webshellDomain.protocol +'://'+ webshellDomain.host + webshellDomain.port + '" target="_blank">' + webshellDomain.protocol +'://'+ webshellDomain.host + webshellDomain.port + '</a></i>\
									</td>\
								</tr>\
								<tr>\
									<td>\
										<span class="iconfont">&#xe606;</span>\
										<b><span>WebShell地址：</span></b>\
									</td>\
									<td>\
										<i><a href="'+ $(item).find("td:first").attr("data-url") +'" target="_blank">'+ $(item).find("td:first").attr("data-url") +'</a></i>\
									</td>\
								</tr>\
								<tr>\
									<td>\
										<span class="iconfont">&#xe600;</span>\
										<b><span>WebShell密码：</span></b>\
									</td>\
									<td>\
										<i>'+ $(item).find("td.webshell-pwd").text() +'</i>\
									</td>\
								</tr>\
								<tr>\
									<td>\
										<span class="iconfont">&#xe604;</span>\
										<b><span>网站所属类型：</span></b>\
									</td>\
									<td>\
										<i>'+ $(item).find("td:eq(1)").text() +'</i>\
									</td>\
								</tr>\
								<tr>\
									<td>\
										<span class="iconfont">&#xe605;</span>\
										<b><span>网站IP：</span></b>\
									</td>\
									<td>\
										<i>'+ $(item).find("td.webshell-ip").text() +'</i>\
									</td>\
								</tr>\
								<tr>\
									<td>\
										<span class="iconfont">&#xe603;</span>\
										<b><span>网站归属地：</span></b>\
									</td>\
									<td>\
										<i>'+ $(item).find("td.webshell-address").text() +'</i>\
									</td>\
								</tr>\
								<tr>\
									<td>\
										<span class="iconfont">&#xe602;</span>\
										<b><span>百度权重：</span></b>\
									</td>\
									<td>\
										<i>'+ $(item).find("td.webshell-br").text() +'</i>\
									</td>\
								</tr>\
								<tr>\
									<td>\
										<span class="iconfont">&#xe607;</span>\
										<b><span>谷歌权重：</span></b>\
									</td>\
									<td>\
										<i>'+ $(item).find("td.webshell-pr").text() +'</i>\
									</td>\
								</tr>\
								<tr>\
									<td>\
										<span class="iconfont">&#xe601;</span>\
										<b><span>项目创建时间：</span></b>\
									</td>\
									<td>\
										<i>2016-09-06 13:25:04</i>\
									</td>\
								</tr>\
							</table>\
						</div>\
						<div role="tabpanel" class="tab-pane fade" id="fileManagement' + webshellManagementLen + '" aria-labelledby="file-management' + webshellManagementLen + '">\
							fileManagement\
						</div>\
						<div role="tabpanel" class="tab-pane fade" id="virtualTerminal' + webshellManagementLen + '" aria-labelledby="virtual-terminal' + webshellManagementLen + '">\
							virtualTerminal\
						</div>\
						<div role="tabpanel" class="tab-pane fade" id="databaseManagement' + webshellManagementLen + '" aria-labelledby="database-management' + webshellManagementLen + '">\
							databaseManagement\
						</div>\
					</div>\
				</div>');
				$('.nav-pills a').click(function (e) {
					e.preventDefault()
					$(this).tab('show')
				})
				$('a#webshell-tab' + webshellManagementLen).click();
			}else{
				swal("展开失败", "显示空间不够，请关闭一个Tab", "warning");
			}
		})
	})
}
function deleteWebshell(shell){
	swal({
		title: "你确定么?",
		text: "你将会删除这条webshell",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "确认",
		cancelButtonText:"取消",
		closeOnConfirm: false
	},function(){
		var urlBase64 = $(shell).parents("tr").find("td:eq(0)").attr("data-url");
		$.ajax({
			url: '/RootApi/webshell/del',
			type: 'post',
			dataType: 'json',
			data:{url:urlBase64}
		})
		.done(function(data){
			if(data.type == "success"){
				swal("删除成功!", "webshell已成功删除", "success");
				webshellList();
				webshellTotal();
			}else{
				swal("删除失败!", data.info, "error");
				webshellList();
			}
		})
	});
}
function reviseButtonText(dom){
	$(dom).parent("ul").prev().text($(dom).text());
	fun_scriptCategory()
}
function fun_scriptCategory(){
	var ul = $(".sweet-alert ul:first");
	if(ul.attr("class") == "dom-hidden"){
		ul.attr('class', 'dom-show');
	}else{
		ul.attr('class', 'dom-hidden');
	}
}
function webshellTotal(){
	$.get("/RootApi/webshell/total",function(data){
		$(".webshell-totol").text(data)
	})
}
function closeWebshellTab(dom){
	if($(dom).parents("ul").find("li").length != 1){
		var tabIndex = $(dom).parent("li").index();
		$(dom).parent("li").remove();
		$(".webshellManagementContent>div").eq(tabIndex).remove();
	}else{
		swal("关闭失败", "目前Tab空间只有一个webshell", "warning");
	}
}
webshellList();
addWebShell();
