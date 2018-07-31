<?php  
            $request_username = "jonta";  //配置成自己的turn服务器用户名
            if(empty($request_username)) {  
                echo "username == null";  
                exit;  
            }  
            $request_key = "jonta";  //配置成自己的turn服务器密码
            $time_to_live = 600;  
            $timestamp = time() + $time_to_live;//失效时间  
            $response_username = $timestamp.":".$_GET["username"];  
            $response_key = $request_key;  
            if(empty($response_key))  
            $response_key = "CEOD_KEY";//constants.py中CEOD_KEY  

            $response_password = getSignature($response_username, $response_key);  

            $arrayObj = array();
            $arrayObj[0]['username'] = $response_username;
            $arrayObj[0]['credential'] = $response_password;
            //配置成自己的stun/turn服务器
            $arrayObj[0]['urls'][0] = "stun:192.168.1.124:3478";
            $arrayObj[0]['urls'][1] = "turn:192.168.1.124:3478?transport=tcp";
            $arrayObj[0]['uris'][0] = "stun:192.168.1.124:3478";
            $arrayObj[0]['uris'][1] = "turn:192.168.1.124:3478?transport=tcp";
            $jsonObj = new Response();  
            $jsonObj->lifetimeDuration = "300.000s";
            $jsonObj->iceServers = $arrayObj;
            echo json_encode($jsonObj);  

            /**   
            * 使用HMAC-SHA1算法生成签名值   
            *   
            * @param $str 源串   
            * @param $key 密钥   
            *   
            * @return 签名值   
            */
            function getSignature($str, $key) {
                $signature = "";
                if (function_exists('hash_hmac')) {
                    $signature = base64_encode(hash_hmac("sha1", $str, $key, true));
                } else {
                    $blocksize = 64;
                    hashfunc = 'sha1';
                    if (strlen($key) > $blocksize) {
                        $key = pack('H*', $hashfunc($key));
                    }
                    $key = str_pad($key, $blocksize, chr(0x00));
                    $ipad = str_repeat(chr(0x36), $blocksize);
                    $opad = str_repeat(chr(0x5c), $blocksize);
                    $hmac = pack(    
                    'H*', $hashfunc(    
                            ($key ^ $opad) . pack(    
                                    'H*', $hashfunc(    
                                            ($key ^ $ipad) . $str    
                                   )    
                            )    
                        )    
                    ); 
                    $signature = base64_encode($hmac);
                }
                return $signature;
           }

            class Response {
                    public $lifetimeDuration = "";
                    public $iceServers = array("");
            } 
        ?>
