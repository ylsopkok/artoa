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
    


	<table class="table table-hover">
		<tr>
		<th><a href="<?php echo U('depart/add_area');?>">添加地区</a></th>
		</tr>
		<?php foreach ($area as $v): ?>
			<tr>
				<th>
					<?php echo ($v['name']); ?>
					<a href="<?php echo U('depart/update_area', array('id'=>$v['id']));?>">[修改]</a>
					<a href="<?php echo U('depart/del_area', array('id'=>$v['id']));?>">[删除]</a>
					<a href="<?php echo U('depart/add_depart', array('id'=>$v['id']));?>">[添加部门]</a>
				</th>
			</tr>
			<?php if ($v['child']): ?>
				<tr>
					<td>
						<?php foreach ($v['child'] as $val): ?>
							<?php echo ($val["name"]); ?>
							<a href="<?php echo U('depart/update_depart', array('id'=>$val['id']));?>">[修改]</a>
							<a href="<?php echo U('depart/del_depart', array('id'=>$val['id']));?>">[删除]</a>
							<a href="<?php echo U('depart/manage_team', array('pid'=>$val['id'], 'topid'=>$val['topid']));?>">[管理小组]</a>
							&nbsp;
						<?php endforeach; ?>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</table>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/artoa/Public/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/artoa/Public/js/bootstrap.min.js"></script>
    <script src="/artoa/Public/js/admin.js"></script>
    <script type="text/javascript">
	    $(function(){
	    	$(".year").val(<?php echo ($year); ?>);;
	    	$(".month").val(<?php echo ($month); ?>);	

	    	$(".admin select").val(<?php echo ($user['admin']); ?>);

	    	$(".area select").change(function(){
				var aid = $(this).val();
				$.post("<?php echo U('user/add_user_ajax');?>", {area:aid}, function(data){
					var str = "<option value='0'>全部</option>";
					for (var i in data)
					{
						str += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>";
					}

					$(".depart select").html(str);
					$(".depart select").change();
				})

				score();
			})

			$(".depart select").change(function(){
				var aid = $(this).val();
				$.post("<?php echo U('user/add_user_ajax');?>", {depart:aid}, function(data){
					var str = "<option value='0'>全部</option>";
					for (var i in data)
					{
						str += "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>";
					}

					$(".team select").html(str);

					init();
					score();
					// $(".area select").val(<?php echo ($user['aid']); ?>);
			  //   	$(".depart select").val(<?php echo ($user['did']); ?>);
			  //   	$(".depart select").val(<?php echo ($user['tid']); ?>);

				})
			})


			$(".score select").change(function(){
				score();
			});

			$(".area select").change();

			$(".submit").click(function(){
				$("#score-f").submit();
			});

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

	    function score(){
	    	var ye = $(".year").val();
				var mon = $(".month").val();
				var area = $(".area select").val();
				var depart = $(".depart select").val();
				var team = $(".team select").val();
				$.post("<?php echo U('score/score_ajax');?>", {year:ye,month:mon,aid:area,did:depart,tid:team}, function(data){
					var str = "<input type='hidden' name='year' value='"+ye+"'/><input type='hidden' name='month' value='"+mon+"'/>";
					for (var i in data)
					{
						str += "<tr><td>"+data[i]['name']+"</td>";

						for (var j = 1; j < 8; j++) {
							str += "<td><input name='col"+data[i]['uid']+"[]' type='number' min='0' value='"+data[i]['child']['col'+j]+"'/></td>";
						};

						str += "<td><input type='text' name='col"+data[i]['uid']+"[]' value='"+data[i]['child']['total']+"'/></td></tr>";
					}
					$(".score .scorelist").html(str);

					$(".score td input").change(function(){
						// 总分计算
						var index = $(this).parent().parent().find('td');
						
						var t = index.eq(1).find('input').val()*5+index.eq(2).find('input').val()*4+index.eq(3).find('input').val()*3+index.eq(4).find('input').val()*2.5+index.eq(5).find('input').val()*2+index.eq(6).find('input').val()*1-index.eq(7).find('input').val()*5;

						index.eq(8).find('input').val(t);
					})
				})
	    }

    </script>
  </body>
</html>