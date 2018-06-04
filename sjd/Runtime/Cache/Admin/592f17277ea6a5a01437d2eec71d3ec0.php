<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>后台管理系统</title>
<meta name="author" content="DeathGhost" />
<link rel="stylesheet" type="text/css" href="/Public/admin/css/style.css" />
<link rel="stylesheet" href="/Public/admin/css/normalize.css">
<link rel="stylesheet" href="/Public/admin/css/style1.css" media="screen" type="text/css" />

<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<![endif]-->
<script src="/Public/admin/js/jquery-1.8.3.min.js"></script>
<script src="/Public/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/Public/admin/layer/layer.js"></script>
<script>
	(function($){
		$(window).load(function(){
			
			$("a[rel='load-content']").click(function(e){
				e.preventDefault();
				var url=$(this).attr("href");
				$.get(url,function(data){
					$(".content .mCSB_container").append(data); //load new content inside .mCSB_container
					//scroll-to appended content 
					$(".content").mCustomScrollbar("scrollTo","h2:last");
				});
			});
			
			$(".content").delegate("a[href='top']","click",function(e){
				e.preventDefault();
				$(".content").mCustomScrollbar("scrollTo",$(this).attr("href"));
			});
			
		});
	})(jQuery);
</script>
</head>
<body>
<!--header-->
<header>
 <h1><img src="/Public/admin/images/admin_logo.png"/></h1>
 <ul class="rt_nav">
  <li><a id="change" style="cursor:pointer;" class="set_icon">修改密码</a></li>
  <li><a href="<?php echo U('Admin/Login/logout');?>" class="quit_icon">安全退出</a></li>
 </ul>
</header>

<!--aside nav-->
<aside class="lt_aside_nav content mCustomScrollbar">
 <h2>功能全览</h2>
 <ul>
<?php foreach($menu->module as $v):?>
  <li>
   <dl>
    <dt><?php echo $v->name;?></dt>
	<?php foreach($v->controller as $r):?>
    <dd><a href="/index.php/Admin/<?php echo $r->link;?>" <?php if($getU == $r->link){echo 'class="active"';}?>><?php echo $r->name;?></a></dd>
	<?php endforeach;?>
    <!--当前链接则添加class:active-->

   </dl>
  </li>
<?php endforeach;?>
  <li>
  
  </li>
 </ul>
</aside>
<script>
$(function(){
	$("#change").click(function(){
		layer.prompt({title: '输入当前密码，并确认', formType: 1}, function(pass, index){
		$.ajax({
			type:"post",
			url:"<?php echo U('Admin/Index/admin_edit');?>",
			data:{pass:pass},
			success:function(data){
				if(data == 1){
					window.location.href="<?php echo U('Admin/Index/admin_do_edit');?>";
				}else{
					alert('您输入的密码有误');
				}
			}
			
		})
		layer.close(index);
		
		layer.msg('演示完毕！您的口令：'+ pass +'<br>您最后写下了：'+text);
 
});
	})
})
</script>