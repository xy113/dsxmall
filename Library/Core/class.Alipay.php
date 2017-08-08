<?php
namespace Core;
class Alipay{
	public $config = array(
			//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
			'partner'=>'',
			//收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
			'seller_id'=>'',
			//商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
			'private_key'=>'',
			//支付宝的公钥，查看地址：https://b.alipay.com/order/pidAndKey.htm
			'alipay_public_key'=>'',
			// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
			'notify_url'=>'',
			// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
			'return_url'=>'',
			//签名方式
			'sign_type'=>'RSA',
			//字符编码格式 目前支持 gbk 或 utf-8
			'input_charset'=>'utf-8',
			//ca证书路径地址，用于curl中ssl校验
			//请保证cacert.pem文件在当前文件夹目录中
			'cacert'=>'',
			//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
			'transport'=>'http',
			// 支付类型 ，无需修改
			'payment_type'=>'1',
			// 产品类型，无需修改
			'service'=>'create_direct_pay_by_user',
			// 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
			'anti_phishing_key'=>'',
			// 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
			'exter_invoke_ip'=>''
	);
	
	public $orderinfo = array(
			'out_trade_no'=>'',
			'subject'=>'',
			'total_fee'=>'',
			'body'=>''
	);
	
	private $alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';
	private $https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
	private $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
	
	function __construct($config=array(),$orderinfo=array()){
		$this->config = array_merge($this->config, $config);
		$this->orderinfo = array_merge($this->orderinfo, $orderinfo);
		if (!$this->config['cacert']) $this->config['cacert'] = DATA_PATH.'cacert.pem';
		if (!$this->config['notify_url']) $this->config['notify_url'] = getSiteURL().'/?m=payment&c=notify&paytype=alipay';
		if (!$this->config['return_url']) $this->config['return_url'] = getSiteURL().'/?m=payment&c=result&paytype=alipay';
	}
	
	/**
	 * 发送支付请求
	 * @param string $method
	 * @param string $button_name
	 */
	public function submit($method='get', $button_name='DONE'){
		$para_temp = array(
				'service'=>$this->config['service'],
				'partner'=>$this->config['partner'],
				'seller_id'=>$this->config['seller_id'],
				'payment_type'=>$this->config['payment_type'],
				'notify_url'=>$this->config['notify_url'],
				'return_url'=>$this->config['return_url'],
				'anti_phishing_key'=>$this->config['anti_phishing_key'],
				'exter_invoke_ip'=>$this->config['exter_invoke_ip'],
				'_input_charset'=>strtolower($this->config['input_charset']),
				
				//'out_trade_no'=>$this->orderinfo['out_trade_no'],
				//'subject'=>$this->orderinfo['subject'],
				//'total_fee'=>$this->orderinfo['total_fee'],
				//'total_fee'=>'0.01',
				//'body'=>$this->orderinfo['body']
				
		);
		$para_temp = array_merge($para_temp, $this->orderinfo);
		//$para_temp['total_fee'] = '0.01';
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp);
		$sHtml = '<html><head><title>支付宝支付</title></head><body>';
		$sHtml.= "\n<form id=\"alipaysubmit\" name=\"alipaysubmit\" action=\"".$this->alipay_gateway_new."_input_charset=".trim(strtolower($this->config['input_charset']))."\" method=\"".$method."\">\n";
		while (list ($key, $val) = each ($para)) {
			$sHtml.= "<input type=\"hidden\" name=\"".$key."\" value=\"".$val."\"/>\n";
		}
		
		//submit按钮控件请不要含有name属性
		$sHtml.="<input type=\"submit\"  value=\"".$button_name."\" style=\"display:none;\"></form>";
		
		$sHtml.= "<script>document.forms['alipaysubmit'].submit();</script>";
		$sHtml.= '</body></html>';
		echo $sHtml;
		exit();
	}
	
	/**
	 * 配置支付参数
	 * @param string $name
	 * @param string $value
	 * @return string[]|string|string
	 */
	public function config($name=null, $value=null){
		if (is_null($name)) {
			return $this->config;
		}else {
			if (is_null($value)) {
				return $this->config[$name];
			}else {
				$this->config[$name] = $value;
				return $value;
			}
		}
	}
	
	/**
	 * 生成签名结果
	 * @param $para_sort 已排序要签名的数组
	 * return 签名结果字符串
	 */
	private function buildRequestMysign($para_sort) {
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = $this->createLinkstring($para_sort);
	
		$mysign = "";
		switch (strtoupper(trim($this->config['sign_type']))) {
			case "RSA" :
				$mysign = $this->rsaSign($prestr, $this->config['private_key']);
				break;
			default :
				$mysign = "";
		}
	
		return $mysign;
	}
	
	/**
	 * 生成要请求给支付宝的参数数组
	 * @param $para_temp 请求前的参数数组
	 * @return 要请求的参数数组
	 */
	private function buildRequestPara($para_temp) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($para_temp);
	
		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);
	
		//生成签名结果
		$mysign = $this->buildRequestMysign($para_sort);
	
		//签名结果与签名方式加入请求提交参数组中
		$para_sort['sign'] = $mysign;
		$para_sort['sign_type'] = strtoupper(trim($this->config['sign_type']));
	
		return $para_sort;
	}
	
	/**
	 * 生成要请求给支付宝的参数数组
	 * @param $para_temp 请求前的参数数组
	 * @return 要请求的参数数组字符串
	 */
	private function buildRequestParaToString($para_temp) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp);
	
		//把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
		$request_data = $this->createLinkstringUrlencode($para);
	
		return $request_data;
	}
	
	
	/**
	 * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
	 * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。
	 * 建议本地调试时使用PHP开发软件
	 * return 时间戳字符串
	 */
	function query_timestamp() {
		$url = $this->alipay_gateway_new."service=query_timestamp&partner=".trim(strtolower($this->config['partner']))."&_input_charset=".trim(strtolower($this->config['input_charset']));
		$encrypt_key = "";
	
		$doc = new DOMDocument();
		$doc->load($url);
		$itemEncrypt_key = $doc->getElementsByTagName( "encrypt_key" );
		$encrypt_key = $itemEncrypt_key->item(0)->nodeValue;
	
		return $encrypt_key;
	}
	
	/* *
	 * 支付宝接口公用函数
	 * 详细：该类是请求、通知返回两个文件所调用的公用函数核心处理文件
	 * 版本：3.3
	 * 日期：2012-07-19
	 * 说明：
	 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
	 */
	
	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	private function createLinkstring($para) {
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$key."=".$val."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);
	
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
	
		return $arg;
	}
	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	private function createLinkstringUrlencode($para) {
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$key."=".urlencode($val)."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);
	
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
	
		return $arg;
	}
	
	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */
	private function paraFilter($para) {
		$para_filter = array();
		while (list ($key, $val) = each ($para)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para_filter[$key] = $para[$key];
		}
		return $para_filter;
	}
	
	/**
	 * 对数组排序
	 * @param $para 排序前的数组
	 * return 排序后的数组
	 */
	private  function argSort($para) {
		ksort($para);
		reset($para);
		return $para;
	}
	
	/**
	 * 写日志，方便测试（看网站需求，也可以改成把记录存入数据库）
	 * 注意：服务器需要开通fopen配置
	 * @param $word 要写入日志里的文本内容 默认值：空值
	 */
	private function logResult($word='') {
		$fp = fopen(DATA_PATH."/log/alipay.txt","a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
		flock($fp, LOCK_UN);
		fclose($fp);
	}
	
	/**
	 * 远程获取数据，POST模式
	 * 注意：
	 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
	 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
	 * @param $url 指定URL完整路径地址
	 * @param $cacert_url 指定当前工作目录绝对路径
	 * @param $para 请求的数据
	 * @param $input_charset 编码格式。默认值：空值
	 * return 远程输出的数据
	 */
	private function getHttpResponsePOST($url, $cacert_url, $para, $input_charset = '') {
	
		if (trim($input_charset) != '') {
			$url = $url."_input_charset=".$input_charset;
		}
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
		curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
		curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		curl_setopt($curl,CURLOPT_POST,true); // post传输数据
		curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
		$responseText = curl_exec($curl);
		//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
		curl_close($curl);
	
		return $responseText;
	}
	
	/**
	 * 远程获取数据，GET模式
	 * 注意：
	 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
	 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
	 * @param $url 指定URL完整路径地址
	 * @param $cacert_url 指定当前工作目录绝对路径
	 * return 远程输出的数据
	 */
	private function getHttpResponseGET($url,$cacert_url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
		curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
		$responseText = curl_exec($curl);
		//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
		curl_close($curl);
	
		return $responseText;
	}
	
	/**
	 * 实现多种字符编码方式
	 * @param $input 需要编码的字符串
	 * @param $_output_charset 输出的编码格式
	 * @param $_input_charset 输入的编码格式
	 * return 编码后的字符串
	 */
	private function charsetEncode($input,$_output_charset ,$_input_charset) {
		$output = "";
		if(!isset($_output_charset) )$_output_charset  = $_input_charset;
		if($_input_charset == $_output_charset || $input ==null ) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")) {
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
	
	/**
	 * 实现多种字符解码方式
	 * @param $input 需要解码的字符串
	 * @param $_output_charset 输出的解码格式
	 * @param $_input_charset 输入的解码格式
	 * return 解码后的字符串
	 */
	private function charsetDecode($input,$_input_charset ,$_output_charset) {
		$output = "";
		if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
		if($_input_charset == $_output_charset || $input ==null ) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")) {
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset changes.");
		return $output;
	}
	
	/* *
	 * 支付宝接口RSA方法
	 * 详细：RSA签名、验签、解密
	 * 版本：3.3
	 * 日期：2012-07-23
	 * 说明：
	 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
	 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
	 */
	
	/**
	 * RSA签名
	 * @param $data 待签名数据
	 * @param $private_key 商户私钥字符串
	 * return 签名结果
	 */
	private function rsaSign($data, $private_key) {
		//以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
		$private_key=str_replace("-----BEGIN RSA PRIVATE KEY-----","",$private_key);
		$private_key=str_replace("-----END RSA PRIVATE KEY-----","",$private_key);
		$private_key=str_replace("\n","",$private_key);
	
		$private_key="-----BEGIN RSA PRIVATE KEY-----".PHP_EOL .wordwrap($private_key, 64, "\n", true). PHP_EOL."-----END RSA PRIVATE KEY-----";
	
		$res=openssl_get_privatekey($private_key);
	
		if($res)
		{
			openssl_sign($data, $sign,$res);
		}
		else {
			echo "您的私钥格式不正确!"."<br/>"."The format of your private_key is incorrect!";
			exit();
		}
		openssl_free_key($res);
		//base64编码
		$sign = base64_encode($sign);
		return $sign;
	}
	
	/**
	 * RSA验签
	 * @param $data 待签名数据
	 * @param $alipay_public_key 支付宝的公钥字符串
	 * @param $sign 要校对的的签名结果
	 * return 验证结果
	 */
	private function rsaVerify($data, $alipay_public_key, $sign)  {
		//以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
		$alipay_public_key=str_replace("-----BEGIN PUBLIC KEY-----","",$alipay_public_key);
		$alipay_public_key=str_replace("-----END PUBLIC KEY-----","",$alipay_public_key);
		$alipay_public_key=str_replace("\n","",$alipay_public_key);
	
		$alipay_public_key='-----BEGIN PUBLIC KEY-----'.PHP_EOL.wordwrap($alipay_public_key, 64, "\n", true) .PHP_EOL.'-----END PUBLIC KEY-----';
		$res=openssl_get_publickey($alipay_public_key);
		if($res)
		{
			$result = (bool)openssl_verify($data, base64_decode($sign), $res);
		}
		else {
			echo "您的支付宝公钥格式不正确!"."<br/>"."The format of your alipay_public_key is incorrect!";
			exit();
		}
		openssl_free_key($res);
		return $result;
	}
	
	
	
	/**
	 * 针对notify_url验证消息是否是支付宝发出的合法消息
	 * @return 验证结果
	 */
	public function verifyNotify(){
		if(empty($_POST)) {
			//判断POST来的数组是否为空
			return false;
		}else {
			//生成签名结果
			$isSign = $this->getSignVeryfy($_POST, $_POST["sign"]);
			//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
			$responseTxt = 'false';
			if (! empty($_POST["notify_id"])) {$responseTxt = $this->getResponse($_POST["notify_id"]);}
				
			//写日志记录
			//if ($isSign) {
			//	$isSignStr = 'true';
				//}
				//else {
				//	$isSignStr = 'false';
				//}
				//$log_text = "responseTxt=".$responseTxt."\n notify_url_log:isSign=".$isSignStr.",";
				//$log_text = $log_text.createLinkString($_POST);
				//logResult($log_text);
					
				//验证
				//$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
				//isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
				if (preg_match("/true$/i",$responseTxt) && $isSign) {
					return true;
				} else {
					return false;
				}
			}
		}
	
		/**
		 * 针对return_url验证消息是否是支付宝发出的合法消息
		 * @return 验证结果
		 */
		public function verifyReturn(){
			if(empty($_GET)) {//判断POST来的数组是否为空
				return false;
			}
			else {
				//生成签名结果
				$isSign = $this->getSignVeryfy($_GET, $_GET["sign"]);
				//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
				$responseTxt = 'false';
				if (! empty($_GET["notify_id"])) {$responseTxt = $this->getResponse($_GET["notify_id"]);}
					
				//写日志记录
				//if ($isSign) {
				//	$isSignStr = 'true';
				//}
				//else {
				//	$isSignStr = 'false';
				//}
				//$log_text = "responseTxt=".$responseTxt."\n return_url_log:isSign=".$isSignStr.",";
				//$log_text = $log_text.createLinkString($_GET);
				//logResult($log_text);
					
				//验证
				//$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
				//isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
				if (preg_match("/true$/i",$responseTxt) && $isSign) {
					return true;
				} else {
					return false;
				}
			}
		}
	
		/**
		 * 获取返回时的签名验证结果
		 * @param $para_temp 通知返回来的参数数组
		 * @param $sign 返回的签名结果
		 * @return 签名验证结果
		 */
		private function getSignVeryfy($para_temp, $sign) {
			//除去待签名参数数组中的空值和签名参数
			$para_filter = $this->paraFilter($para_temp);
	
			//对待签名参数数组排序
			$para_sort = $this->argSort($para_filter);
	
			//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
			$prestr = $this->createLinkstring($para_sort);
	
			$isSgin = false;
			switch (strtoupper(trim($this->config['sign_type']))) {
				case "RSA" :
					$isSgin = $this->rsaVerify($prestr, trim($this->config['alipay_public_key']), $sign);
					break;
				default :
					$isSgin = false;
			}
	
			return $isSgin;
		}
	
		/**
		 * 获取远程服务器ATN结果,验证返回URL
		 * @param $notify_id 通知校验ID
		 * @return 服务器ATN结果
		 * 验证结果集：
		 * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
		 * true 返回正确信息
		 * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
		 */
		private function getResponse($notify_id) {
			$transport = strtolower(trim($this->config['transport']));
			$partner = trim($this->config['partner']);
			$veryfy_url = '';
			if($transport == 'https') {
				$veryfy_url = $this->https_verify_url;
			}else {
				$veryfy_url = $this->http_verify_url;
			}
			$veryfy_url = $veryfy_url."partner=" . $partner . "&notify_id=" . $notify_id;
			$responseTxt = $this->getHttpResponseGET($veryfy_url, $this->config['cacert']);
	
			return $responseTxt;
		}
}