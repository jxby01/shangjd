<?php
namespace Api\Controller;
use Think\Controller;
class CutdownController extends Controller{
    /**
     * 用户查看所有的砍价商品
     */
    public function look_goods(){
        $id = $_POST['id'];
        M('activity')->where(array("ac_id"=>$id))->find();

    }
}
?>