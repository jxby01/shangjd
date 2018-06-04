<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController{
	public function index(){
		$customer = M('customer'); // 实例化User对象
		$count = $customer->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $customer->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//rint_r($list);
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->view('index/index');
	}
	public function admin_edit(){
		$pass = sha1($_POST['pass']);
		$name = $_SESSION['name'];
		if(M('admin')->where(['username'=>$name,'password'=>$pass])->find()){
			echo 1;
		}else{
			echo 2;
		}
	}
	
	public function admin_do_edit(){
		if(!empty($_POST)){
			$data['password'] = sha1($_POST['password']);
			$data['username'] = $_POST['username'];
			$name = $_SESSION['name'];
			if(M('admin')->where(['password'=>$pass])->save($data)){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			$this->assign('name',$_SESSION['name']);
			$this->view();
		}
	}
	
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