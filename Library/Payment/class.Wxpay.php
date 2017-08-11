<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/26
 * Time: 上午9:12
 */
namespace Payment;
class Wxpay{
    public $appid = '';
    public $appsecret = '';
    public $mch_id  = '';
    public $mch_key = '';
    public $order_info = array();

    /**
     * Wxpay constructor.
     */
    function __construct()
    {
        $this->appid = setting('wx_appid');
        $this->appsecret = setting('wx_appsecret');
        $this->mch_id    = setting('wx_mch_id');
        $this->mch_key   = setting('wx_mch_key');
    }

    /**
     * @param $data
     * @return $this
     */
    public function data($data){
        $this->order_info = $data;
        return $this;
    }

    /**
     * 生成支付签名
     */
    public function getSign(){
        $trade_data = array(
            'appid'=>$this->appid,
            'mch_id'=>$this->mch_id,
            'body'=>$this->order_info['trade_name'],
            'detail'=>$this->order_info['trade_desc'] ? $this->order_info['trade_desc'] : $this->order_info['trade_name'],
            'nonce_str'=>random(32),
            //'total_fee'=>intval(floatval($this->order_info['trade_fee'])*100),
            'total_fee'=>1,
            'out_trade_no'=>$this->order_info['trade_no'],
            //'out_trade_no'=>date('YmdHis'),
            'spbill_create_ip'=>getIp(),
            'time_start'=>date('YmdHis',time()),
            'trade_type'=>'JSAPI',
            'notify_url'=>$this->order_info['notify_url'],
            'openid'=>$this->order_info['openid']
        );
        if ($this->order_info['device_info']){
            $trade_data['device_info'] = $this->order_info['device_info'];
        }
        $trade_data['sign'] = $this->signArray($trade_data);
        //print_array($trade_data);exit();
        $xmlstr = $this->arrayToXml($trade_data);
        $resxml = httpPost('https://api.mch.weixin.qq.com/pay/unifiedorder', $xmlstr);
        $xmlArray = $this->xmlToArray($resxml);

        //print_array($xmlArray);
        if ($xmlArray['return_code'] == 'SUCCESS'){
            $timestamp = time();
            $parameters = array(
                'appId'=>$this->appid,
                'timeStamp'=>"$timestamp",
                'nonceStr'=>random(32),
                'package'=>"prepay_id=$xmlArray[prepay_id]",
                'signType'=>'MD5',
            );
            $parameters['paySign'] = $this->signArray($parameters);
            return $parameters;
        }else {
            return $xmlArray;
        }
    }

    /**
     * 企业付款
     * @return mixed
     */
    public function mchPay(){
        $data = array(
            'mch_appid'=>$this->appid,
            'mchid'=>$this->mch_id,
            'nonce_str'=>strtoupper(random(10)),
            'partner_trade_no'=>$this->order_info['trade_no'],
            'check_name'=>'NO_CHECK',
            'amount'=>intval(floatval($this->order_info['trade_fee'])*100),
            'desc'=>$this->order_info['trade_desc'],
            'spbill_create_ip'=>getIp(),
            'openid'=>$this->order_info['openid']
        );
        if ($this->order_info['re_user_name']) $data['re_user_name'] = $this->order_info['re_user_name'];

        $data['sign'] = $this->signArray($data);
        $xmldata = $this->arrayToXml($data);
        $res = $this->curl_post_ssl("https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers", $xmldata);
        return $this->xmlToArray($res);
    }

    /**
     * 退款
     * @return mixed
     */
    public function refund(){
        $total_fee = intval(floatval($this->order_info['trade_fee'])*100);
        $data = array(
            'appid'=>$this->appid,
            'mch_id'=>$this->mch_id,
            'nonce_str'=>strtoupper(random(10)),
            'out_trade_no'=>$this->order_info['trade_no'],//订单号
            'out_refund_no'=>$this->order_info['refund_no'],//退款订单号
            'total_fee'=>$total_fee,//订单金额
            'refund_fee'=>$total_fee,//退款金额
        );

        $data['sign'] = $this->signArray($data);
        $xmldata = $this->arrayToXml($data);
        $res = $this->curl_post_ssl("https://api.mch.weixin.qq.com/secapi/pay/refund", $xmldata);
        return $this->xmlToArray($res);
    }

    /*
     请确保您的libcurl版本是否支持双向认证，版本高于7.20.1
     */
    private function curl_post_ssl($url, $vars, $second=50,$aHeader=array()){
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

        //以下两种方式需选择一种
        //第一种方法，cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT, ROOT_PATH.'cert/apiclient_cert.pem');
        //默认格式为PEM，可以注释
        //curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY, ROOT_PATH.'cert/apiclient_key.pem');

        //第二种方式，两个文件合成一个.pem文件
        //curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

        if( count($aHeader) > 0 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }

        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        }
        else {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }
    }

    private function signArray(array $array){
        ksort($array);
        $signStr = $this->arrayToString($array).'&key='.$this->mch_key;
        return strtoupper(md5($signStr));
    }

    private function arrayToString(array $array, $urlencode=0){
        $string = $comma = '';
        foreach ($array as $key=>$value){
            if ($value){
                if ($urlencode){
                    $value = urlencode($value);
                }
                $string.= $comma.$key.'='.$value;
                $comma = '&';
            }
        }
        return $string;
    }

    //数组转xml
    private function arrayToXml($arr){
        $xml = "\n<xml>\n";
        foreach ($arr as $key=>$val)
        {
            //$xml.="<".$key.">".$val."</".$key.">\n";
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">\n";
            }
        }
        $xml.="</xml>\n";
        return $xml;
    }

    /**
     * 	作用：将xml转为array
     */
    private function xmlToArray($xml){
        //将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }
}