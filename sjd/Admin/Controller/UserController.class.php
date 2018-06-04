<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController{
	/**
	 * 参与的砍价
	 *   1.后台查看该用户参与的砍价（帮人砍价）
	 *   2.获取用户id（user_id）
	 *   3.根据user_id查询参与列表
	 *   4.渲染列表
	 */
	public function join(){
		$actor=M('actor')->where(array('users_id'=>$_GET['user_id']))->select();//获取关联信息
		foreach($actor as $key=>$val){
			$or_id[]=$val['or_id'];//所有的订单id（砍价的订单id）
		}
		$where['or_id']=array('in',$or_id);
		$order=M('order')->where($where)->select();//该用户参与砍价（帮别人砍）的订单
		foreach($order as $k=>$v){
			$order[$k]['cut_time']=$actor[$k]['cut_time'];
			$order[$k]['cut_money']=$actor[$k]['cut_money'];
		}
		$this->assign('order',$order);
		$this->view('User/join');
	}
	/**
	 * 创建的砍价活动
	 *   1.管理员查看用户创建的活动列表
	 *   2.get获取用户的id（user_id）
	 *   3.根据user_id查询所创建的活动列表
	 *   4.渲染列表
	 */
	public function activity(){
		$activity=M('activity')->where(array('create_id'=>$_GET['user_id']))->select();
		$user=M('customer')->find($_GET['user_id']);
		$this->assign('user',$user);
		$this->assign('activity',$activity);
		$this->view('User/activity');
	}
	/**
	 * 发起砍价的活动（我需要别人帮我砍价）
	 *   1.管理员查看用户发起砍价活动列表
	 *   2.get获取该用户的user_id
	 *   3.根据user_id查询我的砍价订单列表
	 *   4.渲染列表
	 */
	public function order(){
		$order=M('order')->where(array('user_id'=>$_GET['user_id']))->select();
		$this->assign('order',$order);
		$this->view('User/order');
	}
}
?>