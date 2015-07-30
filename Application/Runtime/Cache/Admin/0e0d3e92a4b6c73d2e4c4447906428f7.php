<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟 随其后！ -->
    <title>Artoa</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/artoa/Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/artoa/Public/css/common.css">
    <link rel="stylesheet" href="/artoa/Public/css/admin.css">
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    


	<div class="add-user row">
		<?php if ($error): ?>
			<div class="alert alert-danger">
				<?php echo ($error); ?>
				<!-- <strong>Whoops!</strong> There were some problems with your input.<br><br> -->
				<!-- <ul>
						<li>333</li>
				</ul> -->
			</div>
		<?php endif; ?>
		<form class="form-horizontal" role="form" method="POST" action="<?php echo U('user/update_user_handler',array('uid'=>$user['uid']));?>">
			<input type="hidden" name="_token" value="">

			<div class="form-group">
			<label class="col-sm-2 control-label">用户名：</label>
				<div class="col-sm-3">
					<p class="form-control-static"><?php echo ($user["name"]); ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">密码：</label>
				<div class="col-sm-3">
					<input type="password" placeholder="password" class="form-control" name="password">
				</div>
			</div>

			<div class="admin form-group">
				<label class="col-sm-2 control-label">用户组：</label>
				<div class="col-sm-3">
					<select class="form-control" name="admin">
						<?php if ($admin == 2): ?>
							<option value="0">普通员工</option>
							<option value="1">管理员</option>
							<option value="2">总管理员</option>
						<?php else: ?>
							<option value="0">普通员工</option>
							<option value="1">管理员</option>
						<?php endif; ?>
					</select>
				</div>
			</div>

			<div class="area form-group">
				<label class="col-sm-2 control-label">地区：</label>
				<div class="col-sm-3">
					<select class="form-control" name="area">
						<?php foreach ($area as $v): ?>
							<option value=<?php echo ($v["id"]); ?>><?php echo ($v["name"]); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="depart form-group">
				<label class="col-sm-2 control-label">部门：</label>
				<div class="col-sm-3">
					<select class="form-control" name="depart">
						
					</select>
				</div>
			</div>

			<div class="team form-group">
				<label class="col-sm-2 control-label">小组：</label>
				<div class="col-sm-3">
					<select class="form-control" name="team">
						
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-3 col-sm-offset-2">
					<button type="submit" class="btn btn-primary">修改</button>
				</div>
			</div>
		</form>
	</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/artoa/Public/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/artoa/Public/js/bootstrap.min.js"></script>
    <script src="/artoa/Public/js/admin.js"></script>
    <script type="text/javascript">
	    $(function(){
	    	$(".admin select").val(<?php echo ($user['admin']); ?>);

	    	$(".area select").change(function(){
				var aid = $(this).val();
				$.post("<?php echo U('user/add_user_ajax');?>", {area:aid}, function(data){
					var str = ' ';
					for (var i in data)
					{
						str += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>";
					}

					$(".depart select").html(str);
					$(".depart select").change();
				})
			})

			$(".depart select").change(function(){
				var aid = $(this).val();
				$.post("<?php echo U('user/add_user_ajax');?>", {depart:aid}, function(data){
					var str = ' ';
					for (var i in data)
					{
						str += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>";
					}

					$(".team select").html(str);

					init()
					// $(".area select").val(<?php echo ($user['aid']); ?>);
			  //   	$(".depart select").val(<?php echo ($user['did']); ?>);
			  //   	$(".depart select").val(<?php echo ($user['tid']); ?>);

				})
			})


			$(".score select").change(function(){
				var ye = $(".year").val();
				var mon = $(".month").val();
				var area = $(".area select").val();
				var depart = $(".depart select").val();
				var team = $(".team select").val();
				$.post("<?php echo U('score/score_ajax');?>", {year:ye,month:mon,aid:area,did:depart,tid:team}, function(data){
					var str = " ";
					for (var i in data)
					{
						str += "<tr><td colspan='9' scope='row'>"+data[i]['name']+"<td></tr>"
					}
					$(".score .scorelist").html(str);
				})
			});

			$(".area select").change();

	    })

	    var flag = 1;

	    function init(){
	    	if (flag == 1) 
	    	{
	    		$(".area select").val(<?php echo ($user['aid']); ?>);
		    	$(".depart select").val(<?php echo ($user['did']); ?>);
		    	$(".team select").val(<?php echo ($user['tid']); ?>);
	    	};
	    	flag = 0;
	    }




    </script>
  </body>
</html>