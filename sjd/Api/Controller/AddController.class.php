<?php 
namespace Api\Controller;
use Think\Controller;
class AddController extends Controller{
    /**创建活动
     *
     */
	public function add_activity(){//创建活动，之后的添加数据均为修改
		$data['create_id'] = 3;//$_POST['create_id'];//创建者的Id
		$data['ac_create_time'] = time();
		$res = M('activity')->add($data);
		if($res){
			echo $res;//创建成功
		}else{
			echo 0;//创建失败
		}
	}
    /**活动修改
     *
     */
	public function edit_activity(){
		if(!empty($_POST)){
		    $id=$_POST['id'];
		    $res = M('activity')->where(array('ac_id'=>$id))->save($_POST);
        }
	}

    /**
     *用户的注册
     */
	public function add_user(){
        if(!empty($_POST)){
            if($_POST['code'] == $_SESSION['code']){//验证码是否正确
                $data['user_name'] = $_POST['name'];
                $data['password'] = sha1($_POST['password']);
                $data['create_time'] = time();
                if(M('customer')->add($data)){
                    echo 1;//注册成功
                }else{
                    echo 0;//注册失败
                }
            }
        }
    }

    /**
     * 获取验证码
     */
        public function register(){//发送验证码
            if(!empty($_POST)){
            if(M('customer')->where(array('phone'=>$_POST['phone']))->find()){
                exit(json_encode(array('msg'=>'账号已被注册','result'=>0)));
            }else{
                $code = rand(1000,9999);//验证码
                $_SESSION['code']=$code;
				$host = "https://feginesms.market.alicloudapi.com";//api访问链接
				$path = "/codeNotice";//API访问后缀
				$method = "GET";
				$appcode = "a7155429978941afbf2bcdc407e1e53c";//替换成自己的阿里云appcode
				$headers = array();
				array_push($headers, "Authorization:APPCODE " . $appcode);
				$querys = "param=".$code."&phone=".$_POST['phone']."&sign=1&skin=8";  //参数写在这里
				$url = $host . $path . "?" . $querys;//url拼接

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($curl, CURLOPT_FAILONERROR, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HEADER, false);
				if (1 == strpos("$".$host, "https://"))
                {
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                }
				// echo(curl_exec($curl));
				curl_exec($curl);
				exit($code);

			 }
		 }else{
			 exit(json_encode(array('msg'=>'未接受到数据')));
		}
	}

	/**
     * 找回密码
     */
    public function edit_password(){
        if(!empty($_POST)){
            $data['phone']=$_POST['phone'];
            $data['password'] = sha1($_POST['password']);
            if(M('customer')->where(array('phone'=>$data['phone']))->find()){
                M('customer')->where(array('phone'=>$data['phone']))->save($data);
                echo 1;//修改成功
            }else{
                echo 0;//未找到该用户的数据
            }
        }
    }

    /**
     *用户的登录
     */
    public function user_login(){
        if(!empty($_POST)){
            $name = $_POST['name'];
            $pass = sha1($_POST['password']);
            if(M('customer')->where(array('user_name'=>$name,'password'=>$pass))->find()){
                echo 1;//成功
            }else{
                echo 0;//失败
            }
        }
    }

}

?>