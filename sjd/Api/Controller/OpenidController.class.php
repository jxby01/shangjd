<?php 
namespace Api\Controller;
use Think\Controller;
class OpenidController extends Controller{
	public function sendappid(){
        $appid = $_GET['appid'];
        $secret = $_GET['secret'];
        $js_code = $_GET['js_code'];
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $data = array
        (
            'appid' => $appid,                    //С����appid
            'secret' => $secret,            //С������Կ
            'js_code' => $js_code,                //С�����¼��ȡ��code
            'grant_type' => 'authorization_code',            //
        );
        $openid = $this->httpRequest($url, 'POST', $data);
		
        $obj = json_decode($openid);
        exit(json_encode(array('openid' => $obj->openid,'session_key'=>$obj->session_key,'unionid'=>$obj->unionid, 'msg' => '�ɹ�')));
    }


/**
 * CURL����
 * @param $url ����url��ַ
 * @param $method ���󷽷� get post
 * @param null $postfields post��������
 * @param array $headers ����header��Ϣ
 * @param bool|false $debug ���Կ��� Ĭ��false
 * @return mixed
 */
function httpRequest($url, $method, $postfields = null, $headers = array(), $debug = false)
{
    $method = strtoupper($method);
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* �ڷ�������ǰ�ȴ���ʱ�䣬�������Ϊ0�������޵ȴ� */
    curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* ����cURL����ִ�е������ */
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    switch ($method) {
        case "POST":
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($postfields)) {
                $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
            }
            break;
        default:
            curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //��������ʽ */
            break;
    }
    $ssl = preg_match('/^https:\/\//i', $url) ? TRUE : FALSE;
    curl_setopt($ci, CURLOPT_URL, $url);
    if ($ssl) {
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https���� ����֤֤���hosts
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // ����֤���м��SSL�����㷨�Ƿ����
    }
    //curl_setopt($ci, CURLOPT_HEADER, true); /*����ʱ�Ὣͷ�ļ�����Ϣ��Ϊ���������*/
    curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*ָ������HTTP�ض�������������ѡ���Ǻ�CURLOPT_FOLLOWLOCATIONһ��ʹ�õ�*/
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);
    /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE����ȥ** */
    $response = curl_exec($ci);
    $requestinfo = curl_getinfo($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    if ($debug) {
        echo "=====post data======\r\n";
        var_dump($postfields);
        echo "=====info===== \r\n";
        print_r($requestinfo);
        echo "=====response=====\r\n";
        print_r($response);
    }
    curl_close($ci);
    return $response;
    //return array($http_code, $response,$requestinfo);
}
}
?>