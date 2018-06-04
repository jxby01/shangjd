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
		    if($res){
		        echo $res;
            }else{
		        echo 0;
            }
        }
	}

    /**
     * 商品信息的添加
     */
    public function add_commoddity(){
        if(!empty($_POST)){
            $k=count($_POST);
            for($i=0;$i<$k;$i++){
                $result = M('commodity')->add($_POST[$k]);
            }
            if($result){
                $this->ajaxReturn($result);
            }

        }
    }

    /**
     * 券号的导入或者生成
     */
    public function add_ticket(){
        if($_POST['voucher_way']==0){//系统随机生成
            $num = $_POST['num'];//生成券号个数
            $leng = $_POST['leng'];//券号长度
            $data['com_id'] = $_POST['com_id'];
            for($i=0;$i<$num;$i++){
                $data['code'] =getRandCode($leng);
                $res = M('voucher')->add();
            }
            if($res){
                exit(1);
            }else{
                exit(0);
            }
        }else{//手工导入

        }
    }

    /**
     *用户的注册
     */
	public function add_user(){
        header('Access-Control-Allow-Origin:*');
        if(!empty($_POST)){
                $data['phone'] = $_POST['phone'];
                $data['password'] = sha1($_POST['password']);
                $data['create_time'] = time();
                if(M('customer')->add($data)){
                    echo 1;//注册成功
                }else{
                    echo 0;//注册失败
                }
        }
    }

    /**
     * 获取验证码
     */
        public function register(){//发送验证码
            header('Access-Control-Allow-Origin:*');
            if(!empty($_POST)){
            if(M('customer')->where(array('phone'=>$_POST['phone']))->find()){
                exit(0);
            }else{
                $code = rand(1000,9999);//验证码
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
				curl_exec($curl);
				echo $code;

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
            $_SESSION['user_name'] = $name;
            $pass = sha1($_POST['password']);
            $res = M('customer')->where(array('user_name'=>$name,'password'=>$pass))->find();
            if($res){
                 $this->ajaxReturn($res);//成功
            }else{
                echo 0;//失败
            }
        }
    }

    /**
     * 图片上传，返回路径
     */
    public function up_imgs(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  = './Uploads/'; // 设置附件上传根目录
        $upload->savePath  = 'Product/'; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
        $imgs = 'Uploads/'.$info['file']['savepath'].$info['file']['savename'];
        exit(json_encode(array("code"=>0,"msg"=>'上传成功','src'=>$imgs)));//返回到JS中进行处理
    }

}

?>