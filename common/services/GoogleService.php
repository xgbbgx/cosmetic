<?php
namespace common\services;

use common\helpers\CurlHelper;

class GoogleService{
    /**
     *
     * @param unknown $text
     */
    public static function googleTranslate($text,$sl='en',$tl='zh-CN'){
        
        $tk=self::TL($text);
        $text=rawurlencode($text);
        $url='https://translate.google.cn/translate_a/single?client=t&sl='.$sl.'&tl='.$tl.'&hl=zh-CN&dt=at&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&ie=UTF-8&oe=UTF-8&source=btn&ssel=3&tsel=0&kc=0&tk='.
            $tk.'&q='.$text;//rawurlencode($text);
            $res=CurlHelper::query($url,[],'get',5000,5000,false);
            print_r($res);
            exit;
            $res=json_decode($res,true);
            $text='';
            if($res && isset($res[0])){
                foreach ($res[0] as $rs){
                    $text .=$rs[0];
                }
            }
            return $text;
    }
    public static function googleTkk(){
        $timeout = 10 ;
        $url = "https://translate.google.cn" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
        $conts = curl_exec($ch);
        curl_close($ch);
        //"#TKK\=eval\('\(\(function\(\)\{var\s+a\\\\x3d(-?\d+);var\s+b\\\\x3d(-?\d+);return\s+(\d+)\+#isU"
        if(preg_match('/TKK=\'([\d\D]*?)\';/i', $conts, $arr)){
            return $arr['1'];
        }else{
            exit("0");
        }
    }
    public static  function shr32($x, $bits)
    {
        
        if($bits <= 0){
            return $x;
        }
        if($bits >= 32){
            return 0;
        }
        
        $bin = decbin($x);
        $l = strlen($bin);
        
        if($l > 32){
            $bin = substr($bin, $l - 32, 32);
        }elseif($l < 32){
            $bin = str_pad($bin, 32, '0', STR_PAD_LEFT);
        }
        
        return bindec(str_pad(substr($bin, 0, 32 - $bits), 32, '0', STR_PAD_LEFT));
    }
    
    //这个就是javascript的charCodeAt
    //PHP版本的在这里http://www.phpjiayuan.com/90/225.html
    public static function charCodeAt($str, $index)
    {
        $char = mb_substr($str, $index, 1, 'UTF-8');
        
        if (mb_check_encoding($char, 'UTF-8'))
        {
            $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');
            return hexdec(bin2hex($ret));
        }
        else
        {
            return null;
        }
    }
    
    
    //直接复制google
    public static  function RL($a, $b)
    {
        for($c = 0; $c < strlen($b) - 2; $c +=3) {
            $d = $b{$c+2};
            $d = $d >= 'a' ? self::charCodeAt($d,0) - 87 : intval($d);
            $d = $b{$c+1} == '+' ? self::shr32($a, $d) : $a << $d;
            $a = $b{$c} == '+' ? ($a + $d & 4294967295) : $a ^ $d;
        }
        return $a;
    }
    
    //直接复制google
    public  static function TL($a)
    {
        
        $tkk = explode('.', self::googleTkk());
        $b = $tkk[0];
        
        for($d = array(), $e = 0, $f = 0; $f < mb_strlen ( $a, 'UTF-8' ); $f ++) {
            $g = self::charCodeAt ( $a, $f );
            if (128 > $g) {
                $d [$e ++] = $g;
            } else {
                if (2048 > $g) {
                    $d [$e ++] = $g >> 6 | 192;
                } else {
                    if (55296 == ($g & 64512) && $f + 1 < mb_strlen ( $a, 'UTF-8' ) && 56320 == (charCodeAt ( $a, $f + 1 ) & 64512)) {
                        $g = 65536 + (($g & 1023) << 10) + (charCodeAt ( $a, ++ $f ) & 1023);
                        $d [$e ++] = $g >> 18 | 240;
                        $d [$e ++] = $g >> 12 & 63 | 128;
                    } else {
                        $d [$e ++] = $g >> 12 | 224;
                        $d [$e ++] = $g >> 6 & 63 | 128;
                    }
                }
                $d [$e ++] = $g & 63 | 128;
            }
        }
        $a = $b;
        for($e = 0; $e < count ( $d ); $e ++) {
            $a += $d [$e];
            $a = self::RL ( $a, '+-a^+6' );
        }
        $a = self::RL ( $a, "+-3^+b+-f" );
        $a ^= $tkk[1];
        if (0 > $a) {
            $a = ($a & 2147483647) + 2147483648;
        }
        $a = fmod ( $a, pow ( 10, 6 ) );
        return $a . "." . ($a ^ $b);
    }
    
}