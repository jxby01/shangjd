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
    		<th>商品名称</th>
    		<th>商品图片</th>
        <th>副标题</th>
        <th>商品原价</th>
        <th>砍价目标</th>
        <th>创建时间</th>
        <th>我砍掉</th>
    		<th>是否兑换</th>
    		<th>参与时间</th>
       </tr>
	    <?php if(is_array($order)): foreach($order as $key=>$vo): ?><tr>
        <td><?php echo ($vo["or_id"]); ?></td>
		    <td><?php echo ($vo["user_name"]); ?></td>
        <td><img style="width:45px;height:45px;" src="/<?php echo ($vo["thumb"]); ?>"></td>
        <td><?php echo ($vo["subtitle"]); ?></td>
        <td><?php echo ($vo["original_price"]); ?></td>
        <td><?php echo ($vo["cut_price"]); ?></td>
        <td><?php echo date('Y-m-d,H:i:s',$vo['times']);?></td>
    		<td><?php echo ($vo["cut_money"]); ?></td>
        <td><?php if($vo['if_prize'] == 1){echo '已兑换';}elseif($vo['if_prize']==0){echo '未兑换';}?></td>
    		<td><?php echo ($vo["cut_time"]); ?></td>
       </tr><?php endforeach; endif; ?>
      </table>
      <aside class="paging">
		  <?php echo ($page); ?>
      </aside>
     </section>
	 </div>
</section>