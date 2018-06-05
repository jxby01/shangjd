<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>后台登录</title>
<meta name="author" content="DeathGhost" />
<link rel="stylesheet" type="text/css" href="/Public/admin/css/style.css" />
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="/Public/admin/js/jquery-1.8.3.min.js"></script>
<script src="/Public/admin/js/verificationNumbers.js"></script>
<script src="/Public/admin/js/Particleground.js"></script>
<script src="/Public/admin/layer/layer.js"></script>
<script>
$(document).ready(function() {
  //粒子背景特效
  $('body').particleground({
    dotColor: '#fedcbd',
    lineColor: '#fedcbd'
  });
  $('#Imgchange').click(function(){
  $('#Imgchange').attr('src','<?php echo U("Admin/Login/verify");?>');
  })
});
</script>
<script>
$(function(){
	$('#msg_form').submit(function(){
		var yanzhengma = $('#J_codetext').val();
		if(yanzhengma == null || yanzhengma == '' ){
			layer.tips('要输入验证码哦', '#J_codetext');
			
			return false;
		}
	})
		
})
</script>	

</head>
<body>
<dl class="admin_login">

 <form action = "<?php echo U('Admin/Login/login');?>" method="POST" ID="msg_form">
 
	 <dd class="user_icon">
	  <input type="text" placeholder="账号" name="username" class="login_txtbx"/>
	 </dd>
	 <dd class="pwd_icon">
	  <input type="password" placeholder="密码" name="password" class="login_txtbx"/>
	 </dd>
	 <dd class="val_icon">
	  <div style="width:140px;" class="checkcode">
		<input style="width:140px;" type="text" id="J_codetext" placeholder="验证码" maxlength="4" class="login_txtbx" name="yanzhengma">
	  </div>
		<img id="Imgchange" style="float:right;width:140px;" src="<?php echo U('Admin/Login/verify');?>">
	 </dd>
	
	<dd style="width:60px;height:17px;margin-left:244px;" name="remmenber">
	 <input type="checkbox"/>记住我
	</dd>
	 
	 <dd>
	  <input type="submit" value="立即登陆" id="sub" class="submit_btn"/>
	 </dd>
 </form>
 <dd>
  <p>© 2015-2016 DeathGhost 版权所有</p>
  <p>陕B2-20080224-1</p>
 </dd>
</dl>
</body>
</html>