<?php
namespace Api\Controller;
use Think\Controller;
class CutdownController extends Controller{
    /**
     * 用户查看所有的砍价商品
     */
    public function look_goods(){
        $id = $_POST['id'];
        $res = M('activity')->join("sj_commodity ON sj_commodity.ac_id = sj_activity.ac_id")->where(array(" sj_activity.ac_id"=>$id))->select();
        $this->ajaxReturn($res);
    }

    /**
     * 商品列表/创建砍价
     */
    public function create_cut(){
        if(!empty($_POST)){
            $data['user_id'] = $_POST['user_id'];//用户ID
            $data['com_id'] = $_POST['com_id'];//商品ID
            $data['com_name'] = $_POST['com_name'];//商品名称
            $data['original_price'] = $_POST['original_price'];//商品原价
            $data['cut_price'] = $_POST['cut_price'];//砍价目标
            $data['thumb'] = $_POST['thumb'];//商品图片
            $data['subtitle'] = $_POST['subtitle'];//商品副标题
            $data['if_end'] = 0;//是否砍价完成
            $data['if_prize'] = 0;//是否已兑奖
            $data['times'] = time();//创建时间
            $res = M('order')->add($data);
            if($res){
                echo 1;
            }else{
                echo 0;
            }
        }else{//get传值,拿到单条商品信息
            $id = $_GET['id'];
            $res = M('commodity')->where(array('com_id'=>$id))->find();
            $this->ajaxReturn();
        }
    }

   // public function

}
?>