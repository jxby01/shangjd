<?php
namespace Api\Controller;
use Think\Controller;
class ShareController extends Controller{
    /**
     * 微信分享到朋友圈，好友
     */
	public function share_with(){
        $appid = 'wx5246c89aea484a59';
        $appSecret = '50fe9f01075df962fecefdac3b6fa31a';
        $urls = $_POST['url'];
	    $share =  new \Think\Jssdk();
        $signPackage = $share->GetSignPackage($appid, $appSecret,$urls);
	   exit(json_encode(array('result'=>$signPackage)));
    }

    /**
     * 生成预览图
     */
    public function preview(){
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            $id = $_POST['ac_id'];
            $rew = M('activity')->join("sj_activity on sj_activity.ac_id = sj_commodity.ac_id")->where(array('sj_activity.ac_id'=>$id))->select;
            $this->ajaxReturn($rew);
        }else{
            return false;
        }
    }
}
?>