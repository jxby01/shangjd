<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController{

	/**
	 * 用户列表
	 *   1.查询用户数据表
	 *   2.渲染用户列表
	 *   3.分页
	 */
	public function index(){
		$customer = M('customer'); // 实例化User对象
		$count = $customer->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $customer->order('user_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//rint_r($list);
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->view('index/index');
	}
	/**
	 * 修改密码
	 * 	 1.post获取密码确认
	 * 	 2.返回验证结果（1-success，2-error）
	 */
	public function admin_edit(){
		$pass = sha1($_POST['pass']);
		$name = $_SESSION['name'];
		if(M('admin')->where(['username'=>$name,'password'=>$pass])->find()){
			echo 1;
		}else{
			echo 2;
		}
	}
	/**
	 *修改登录账户
	 *	1.post接受修改用户名，密码
	 *	2.修改用户名，密码（入库）
	 *	3.返回修改信息（1-success，2-error）
	 */
	public function admin_do_edit(){
		if(!empty($_POST)){
			$data['password'] = sha1($_POST['password']);
			$data['username'] = $_POST['username'];
			$name = $_SESSION['name'];
			$pass = $_SESSION['password'];
			if(M('admin')->where(['password'=>$pass,'name'=>$name])->save($data)){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			$this->assign('name',$_SESSION['name']);
			$this->view();
		}
	}
	/**
	 *
	 */
	public function admin_do_edits(){
		if(!empty($_POST)){
			$data['password'] = sha1($_POST['password']);
			$data['username'] = $_POST['username'];
			$name = $_SESSION['name'];
			if(M('admin')->where(['username'=>$name])->save($data)){
				echo 1;
			}else{
				echo 0;
			}
		}
	}
	
}
?>