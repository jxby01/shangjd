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
?>