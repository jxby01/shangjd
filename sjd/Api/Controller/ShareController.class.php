<?php
namespace Api\Controller;
use Think\Controller;
class ShareController extends Controller
{
    /**
     * 微信分享到朋友圈，好友
     */
    public function share_with()
    {
        $appid = 'wx5246c89aea484a59';
        $appSecret = '50fe9f01075df962fecefdac3b6fa31a';
        $urls = $_POST['url'];
        $share = new \Think\Jssdk();
        $signPackage = $share->GetSignPackage($appid, $appSecret, $urls);
        exit(json_encode(array('result' => $signPackage)));
    }

    /**
     * 生成预览图
     */
    public function preview()
    {
        $id = $_GET['ac_id'];
        $rew = M('activity')->join("sj_activity on sj_activity.ac_id = sj_commodity.ac_id")->where(array('sj_activity.ac_id' => $id))->select;
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            $this->ajaxReturn($rew);
        } else {
            $url = "http://zxy.mynatapp.cc/index.php/Api/Share/preview?ac_id=".$id;
            $res = $this->scerweima2($url);
            return $res;
        }
    }

    /**
     * 生成二维码
     * 基于PHPQRCODE GD库
     */

    function scerweima2($url)
    {
        require_once("D:\phpStudy\WWW\shangjd\phpqrcode.php");
        $value = $url;                  //二维码内容
        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = 5;           //生成图片大小
        //生成二维码图片
        $qr = new \QRcode();
        $QR = $qr::png($value, false, $errorCorrectionLevel, $matrixPointSize, 2);
        return '<img src=""'.$QR.'"" alt="查看扫码结果">';
    }

}
?>