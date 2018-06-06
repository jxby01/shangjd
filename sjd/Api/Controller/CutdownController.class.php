<?php
namespace Api\Controller;
use Think\Controller;
class CutdownController extends Controller{
    /**
     * 用户查看所有的砍价商品
     */
    public function look_goods(){
        $id = $_POST['id'];
        $cus_id = $_POST['cus_id'];
        $res = M('activity')->where(array('ac_id'=>$id))->find();
        $res['start_time'] = date('Y年m月d H:i',$res['start_time']);
        $res['end_time'] = date('Y年m月d H:i',$res['end_time']);
        $row = M('commodity')->where(array('ac_id'=>$id))->select();
        $actor = M('actor')->where(array('ac_id'=>$id))->count();
        $order = M('order')->where(array('ac_id'=>$id))->count();
        $orders = M('order')->join("sj_commodity on sj_commodity.com_id=sj_order.com_id")->where(array('sj_order.user_id'=>$cus_id,'if_end'=>1))->select();
        for($i=0;$i<count($orders);$i++){
            $orders[$i]['do_start_time'] = date('Y-m-d', $orders[$i]['do_start_time']);
            $orders[$i]['do_end_time'] = date('Y-m-d', $orders[$i]['do_end_time']);
        }
        $result['if_end'] = $orders;
        $result['tol'] =$actor+$order+$res['participants'];
        $result['huodong'] =$res;
        $result['shangp'] =$row;
        $this->ajaxReturn($result);
    }

    /**
     * 创建砍价
     *  1.生成砍价随机金额
     *  2.数据存放
     */
    public function create_cut(){
        if(!empty($_POST)){
            $data['com_id'] = $_POST['com_id'];//商品ID
            $result = M('commodity')->where(array('com_id'=>$data['com_id']))->find();
            $total=$result['cut_price'];//砍价总额
            $num=$result['cut_num'];// 最多砍价人数
            $min=0.01;//能砍价的最低金额
            $arr = array();
            for ($i=1;$i<$num;$i++)
            {
                $safe_total=($total-($num-$i)*$min)/($num-$i);//随机安全上限
                $money=mt_rand($min*100,$safe_total*100)/100;
                $total=$total-$money;
                array_push($arr,$money);
            }
            array_push($arr,$total);
            $cut_arr = json_encode($arr);
            $data['user_id'] = $_POST['user_id'];//用户ID
            $data['com_name'] = $_POST['com_name'];//商品名称
            $data['original_price'] = $_POST['original_price'];//商品原价
            $data['cut_price'] = $_POST['cut_price'];//砍价目标
            $data['thumb'] = $_POST['thumb'];//商品图片
            $data['subtitle'] = $_POST['subtitle'];//商品副标题
            $data['if_end'] = 0;//是否砍价完成
            $data['if_prize'] = 0;//是否已兑奖
            $data['cut_arr'] = $cut_arr;
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
            $this->ajaxReturn($res);
        }
    }

    /**
     * 帮忙砍价，进入请传get
     */
    public function cut_help(){
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            if (!empty($_POST)) {
                $data['or_id'] = $_POST['or_id'];//传入的砍价的id
                $com_id = $_POST['com_id'];//商品Id
                $rs = M('order')->where(array('or_id' => $data['or_id']))->find();//查询砍价金额
                $re = M('actor')->where(array('or_id' => $data['or_id']))->select();//查询需砍价商品的参与人数
                $ro = M('commodity')->where(array('com_id' => $com_id))->find();//查询需砍价商品的限制人数
                $num = count($re);
                if ($num < $ro['cut_num']) {
                    $data['cus_id'] = $_POST['cus_id'];//砍价用户的ID
                    $data['create_time'] = time();
                    $cut = json_decode($rs['cut_arr']);
                    $cut_money = $cut['$num'];
                    $data['cut_money'] = $cut_money;
                    if (M('actor')->add($data)) {
                        $this->ajaxReturn($data['cut_money']);//成功入库,砍价金额回传
                    } else {
                        $this->ajaxReturn(0);//入库失败
                    }
                } else {
                    exit(json_encode(array('res' => '0', 'msg' => "超出最大限制")));
                }
            } else {
                $id = $_GET['or_id'];
                $res = M('order')->join("sj_actor on sj_actor.or_id = sj_order.or_id")->where(array('sj_order.or_id' => $id))->find();
                $this->ajaxReturn($res);
            }
        }else{
            return false;
        }
    }

    /**
     * “我”的活动列表
     */
    public function my_activity_list(){
        if(!empty($_POST)){
            $id = $_POST['user_id'];
            $res = M('activity')->where(array("create_id"=>$id))->select();
            $this->ajaxReturn($res);
        }
    }

}
?>