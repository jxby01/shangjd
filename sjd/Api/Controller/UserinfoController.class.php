<?php
namespace Api\Controller;
use Think\Controller;
class UserinfoController extends Controller
{
   /**
    * 微信授权
    */
   public function get_user_info(){
        $url1="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxfcaa24e012dc65df&redirect_uri=http://zxy.mynatapp.cc/index.php/Api/Userinfo/rtuser.html&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        Header("Location: $url1");
   }
    //保存获取到用户信息
    public function rtuser(){
        $appid="wxfcaa24e012dc65df";
        $secret="63834ac83f85558c58b048f01971f799";
        $code=$_GET['code'];
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $date=file_get_contents($url);
        $user=get_object_vars(json_decode($date));
        $access_token=$user['access_token'];
        $openid=$user['openid'];
        $url1="https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $date1=file_get_contents($url1);
        $json=get_object_vars(json_decode($date1));
        var_dump($date);var_dump($date1);
        //$this->success('授权完成',U('Index/index'));
    }
}
?>