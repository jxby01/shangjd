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
        
    }
}
?>