<?php if (!defined('THINK_PATH')) exit();?><style>
.paging span.current{
background:white;
border:1px #000000 solid;
color:#19a97b;
padding:5px 8px;
display:inlink-block;
cursor:pointer;
}

</style>

<section class="rt_wrap content mCustomScrollbar">
 <div class="rt_content">

 <section>
      <h2><strong style="color:grey;"></strong></h2>
      <div class="page_title">
      </div>
      <table class="table">
       <tr>
        <th>ID编号</th>
    		<th>用户名</th>
    		<th>头像</th>
        <th>手机号码</th>
        <th>城市</th>
        <th>性别</th>
        <th>创建时间</th>
        <th>我的参与</th>
    		<th>我的砍价</th>
    		<th>我的创建</th>
       </tr>
	   <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
        <td><?php echo ($vo["user_id"]); ?></td>
		    <td><?php echo ($vo["user_name"]); ?></td>
        <td><img style="width:45px;height:45px;" src="/<?php echo ($vo["img"]); ?>"></td>
        <td><?php echo ($vo["phone"]); ?></td>
        <td><?php echo ($vo["city"]); ?></td>
        <td><?php if($vo['sex'] == 1){echo '男';}elseif($vo['sex']==0){echo '女';}else{echo '保密';}?></td>
        <td><?php echo date('Y-m-d,H:i:s',$vo['create_time']);?></td>
    		<td><a href="<?php echo U('User/join');?>?user_id=<?php echo ($vo['user_id']); ?>" id="init">查看</a></td>
        <td><a href="<?php echo U('User/order');?>?user_id=<?php echo ($vo['user_id']); ?>" id="create">查看</a></td>
    		<td><a href="<?php echo U('User/activity');?>?user_id=<?php echo ($vo['user_id']); ?>" id="create">查看</a></td>
       </tr><?php endforeach; endif; ?>
      </table>
      <aside class="paging">
		<?php echo ($page); ?>
      </aside>
     </section>
	 
	 </div>
</section>