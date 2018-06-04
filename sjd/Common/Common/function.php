<?php
/**
 * Created by PhpStorm.
 * User: YangeraYR
 * Date: 2017/9/26
 * Time: 9:45
 */
 function getRandCode($leng)  
    {  
        $charts = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz0123456789";  
        $max = strlen($charts);  
        $noncestr = "";  
        for($i = 0; $i < $leng; $i++)  
        {  
            $noncestr .= $charts[mt_rand(0, $max)];  
        }  
        return $noncestr;
    }
    function sendMsg($phone){
        $code = rand(1000,9999);//验证码
        $host = "https://feginesms.market.alicloudapi.com";//api访问链接
        $path = "/codeNotice";//API访问后缀
        $method = "GET";
        $appcode = "a7155429978941afbf2bcdc407e1e53c";//替换成自己的阿里云appcode
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "param=".$code."&phone=".$phone."&sign=1&skin=8";  //参数写在这里
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
?>