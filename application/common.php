<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string 
 */
function think_ucenter_md5($str, $key = 'ThinkUCenter'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}


function get_client_ip($type = 0){
    $type      = $type ? 1 : 0;
    static $ip = null;
    if (null !== $ip) {
        return $ip[$type];
    }

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos) {
            unset($arr[$pos]);
        }

        $ip = trim($arr[0]);
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

 function get_code($length=32,$mode=0)//获取随机验证码函数
        {
                switch ($mode)
                {
                        case '1':
                                $str='123456789';
                                break;
                        case '2':
                                $str='abcdefghijklmnopqrstuvwxyz';
                                break;
                        case '3':
                                $str='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                break;
                        case '4':
                                $str='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                                break;
                        case '5':
                                $str='ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                                break;
                        case '6':
                                $str='abcdefghijklmnopqrstuvwxyz1234567890';
                                break;
                        default:
                                $str='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
                                break;
                }
                $checkstr='';
                $len=strlen($str)-1;
                for ($i=0;$i<$length;$i++)
                {
                        //$num=rand(0,$len);//产生一个0到$len之间的随机数
                        $num=mt_rand(0,$len);//产生一个0到$len之间的随机数
                        $checkstr.=$str[$num];

                       
                }
                return $checkstr;
}

function validPost()
{
    // if (!request()->isPost()) {
    //          return json_encode([
    //                 "return_code" => config("REQUEST_METHOD_POST_NEED")[0],
    //                 "return_message" => config("REQUEST_METHOD_POST_NEED")[1]  
    //             ]);
    //     }

    //     if (!input('post.')) {
    //         return json_encode([
    //                 "return_code" => config("REQUEST_NO_PARAMS")[0],
    //                 "return_message" => config("REQUEST_NO_PARAMS")[1]
    //             ]);
    //     }
    // }

}


