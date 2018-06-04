<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		parent::__construct();
		$this->CheckLogin();
	}
	
	public function CheckLogin(){
		if(empty($_SESSION['name'])){
			$this->error('未登录',U('Admin/Login/login'),2);
		}
	}
	
	public function GetCateTree($table,$pid = 0,$arr = array(),$level=0){
		$row = M($table)->where(array('pid'=>$pid))->select();
		if(!empty($row)){
			foreach($row as $v){
				$str = '<font color="red">';
				for($i = 0;$i < $level;$i++){
					$str .= '|-';
				}
				$str .= '</font>';
				$v['cate_name'] = $str.$v['cate_name'];
				$arr[] = $v;
				$pid = $v['n_id'];
				$arr = $this->GetCateTree($table,$pid,$arr,$level+1);
			}
		}
		return $arr;
	}
	
	public function DelCateTree($table,$id){
		$result = M($table)->where(array('pid'=>$id))->select();
		//print_r($result);exit;
		if(!empty($result)){
			foreach($result as $v){
				$pid = $v['n_id'];
				$this->DelCateTree($table,$pid);
			}
		}
		$result1 = M($table)->where(array('n_id'=>$id))->delete();
		//print_r($result1);exit;
	}
	
	
    public function view($view){
		$menu = simplexml_load_file('Public/Admin/data/menu.xml');
		//print_r($menu);exit;
		$getU = CONTROLLER_NAME.'/'.ACTION_NAME;
	
		$this->assign('menu',$menu);
		$this->assign('getU',$getU);
		$this->display('public/header');
		$this->display($view);
		$this->display('public/footer');
    }
}