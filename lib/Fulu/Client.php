<?php

/**
 * 服务端 API
 * 福禄开放平台SDK提供了用户授权、授权码刷新、接口访问、消息接收等功能接口。
 * 
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Fulu;

class Client
{
	private $_version = '2.0';
	private $_format = 'json';
	private $_charset = 'utf-8';
	private $_sign_type = 'md5';

	// 接口地址
	private $_url = '';
	private $_accessToken = null;
	private $_appKey = null;
	private $_appSecret = null;
	private $_request = null;

	private $_is_ssl = true;
	private $_is_sandbox = false;

	public function __construct($appKey, $appSecret)
	{
		$this->_appKey = $appKey;
		$this->_appSecret = $appSecret;
	}

	public function getAppKey()
	{
		if (empty($this->_appKey)) {
			throw new \Exception("请设定appKey");
		}
		return $this->_appKey;
	}

	public function getAppSecret()
	{
		if (empty($this->_appSecret)) {
			throw new \Exception("请设定appSecret");
		}
		return $this->_appSecret;
	}

	/**
	 * 设定是否ssl请求
	 *
	 * @param boolean $is_ssl        	
	 */
	public function setIsSsl($is_ssl)
	{
		$this->_is_ssl = boolval($is_ssl);
		return $this;
	}

	/**
	 * 设定是否沙箱环境
	 *
	 * @param boolean $is_sandbox        	
	 */
	public function setIsSandbox($is_sandbox)
	{
		$this->_is_sandbox = boolval($is_sandbox);
		return $this;
	}

	/**
	 * 获取accessToken
	 *
	 * @throws Exception
	 */
	public function getAccessToken()
	{
		if (empty($this->_accessToken)) {
			throw new \Exception("请设定access_token");
		}
		return $this->_accessToken;
	}

	/**
	 * 设定access token
	 *
	 * @param string $accessToken        	
	 */
	public function setAccessToken($accessToken)
	{
		$this->_accessToken = $accessToken;
		return $this;
	}

	/**
	 * 初始化认证的http请求对象
	 */
	private function initRequest()
	{
		$this->_request = new \Fulu\Http\Request($this->getAccessToken());
	}

	/**
	 * 获取请求对象
	 *
	 * @return \Fulu\Http\Request
	 */
	private function getRequest()
	{
		if (empty($this->_request)) {
			$this->initRequest();
		}
		return $this->_request;
	}

	/**
	 * 公共参数
请求地址
环境
HTTP地址
HTTPS地址
正式环境	http://openapi.fulu.com/api/getway	https://openapi.fulu.com/api/getway
沙箱环境	http://pre.openapi.fulu.com/api/getway	https://pre-openapi.fulu.com/api/getway

公共请求参数
参数名称	字段类型	是否必填	最大长度	示例值	描述
app_key	string	是	32	i4esv1l+76l/7NQCL3QudG90Fq+YgVfFGJAWgT+7qO1Bm9o/adG/1iwO2qXsAXNB	开放平台分配给商户的app_key
method	string	是	128	fulu.order.record.get	接口方法名称
timestamp	string	是	192	2014-07-24 03:07:50	时间戳，格式为：yyyy-MM-dd HH:mm:ss
version	string	是	3	2.0	调用的接口版本
format	string	是	10	json	接口请求或响应格式
charset	string	是	10	utf-8	请求使用的编码格式，如utf-8等
sign_type	string	是	10	md5	签名加密类型，目前仅支持md5
sign	string	是	344	详见示例	签名串，签名规则详见右侧《常见问题》中的“ 3.签名计算规则说明 ”
app_auth_token	string	是	40		授权码，固定值为“”
biz_content	string	是		"{\"order_record_get_no\": \"AC072426795315681646\",\"topic\": \"2019年12月份对账单\",\"reconciliation_type\": 1,\"excel_column_header\" : [{\"code\": \"OrderId\",\"title\": \"平台订单号\"}],\"begin_create_time\": \"2019-12-01\",\"end_create_time\": \"2019-12-02\",\"channel\": \"\"}"请求参数集合（注意：该参数是以json字符串的形式传输）

公共响应参数
参数名称	字段类型	是否必填	最大长度	示例值描述
code		int			是		1000	返回码，详见底部《业务错误码》
message		string		是		接口调用成功	返回码描述，详见底部《业务错误码》
result		string		是 		响应结果
sign		string		是		d9f7b3bb99741fedcc265162bea6c626	签名串，签名规则详见右侧《常见问题》中的“ 3.签名计算规则说明 ”

业务错误码
错误码 	返回码描述 		解决方案
0		接口调用成功	接口调用成功，按正常流程处理；下单接口中，接口调用成功表示下单成功，但是下单成功不表示订单充值成功，要想获得订单的充值结果，需要调用查单接口来获得订单充值状态。
1000	必须传入API接口名称	错误原因： 接口请求时method参数不能为空，必须传入API接口名称参数； 解决方案： 1、在开放平台在线调试获取模拟请求参数，进行方法名比对；
1001	无效的API接口名称	错误原因： 接口请求时method接口名称错误或不存在； 解决方案： 1、以开放平台具体接口的method为准，替换请求参数中method的接口名称；
1002	必须传入时间戳	错误原因： 接口请求时timestamp参数不能为空，必须传入时间戳参数； 解决方案： 1、在请求接口中填入timestamp参数（格式为：yyyy-MM-dd HH:mm:ss）；
1003	时间戳格式错误	错误原因： 接口请求时timestamp参数格式不正确； 解决方案： 1、时间戳格式为：yyyy-MM-dd HH:mm:ss，请按要求传入参数；
1004	时间戳已超过有效期	错误原因： 接口请求时服务器会校验请求参数的时间戳timestamp，该参数与服务器当前时间误差不能超过10分钟； 解决方案： 1、请检查入参时间戳字段是否是当前请求时间（不建议同一个包体重复请求）； 2、检查请求方服务器时间是否与北京时间同步；
1005	必须传入app_key	错误原因： 接口请求时app_key参数不能为空，必须传入app_key参数； 解决方案： 1、在请求接口中填入app_key参数(生产环境：商户控制台->应用配置->密钥管理 沙箱环境参数获取地址：https://docs.open.fulu.com/question2)；
1006	无效的app_key	错误原因： 接口请求时服务器会校验请求参数的app_key，判断当前app_key是否有效； 解决方案： 1、检查appkey是否复制错误； 2、沙箱环境与生产环境数据不互通； 3、沙箱环境只能使用沙箱数据，沙箱环境数据获取地址：https://docs.open.fulu.com/question2； 4、以上均排查后还未能解决问题，可能是由于账号配置初始化异常，可通过更新回调地址这种方式来重置账号配置，即可解决问题；（操作步骤：登录商户控制台-配置订单回调地址）；
1007	必须传入版本号	错误原因： 接口请求时version参数不能为空，必须传入版本号； 解决方案： 1、目前的版本号参数值为：2.0；
1008	版本号错误	错误原因： 接口请求时version参数值错误； 解决方案： 1、目前的版本号参数值为：2.0；
1009	必须传入format格式	错误原因： 接口请求时format参数不能为空，必须传入format格式参数； 解决方案： 1、目前的format格式仅支持json；
1010	format格式错误	错误原因： 接口请求时format参数值错误； 解决方案： 1、目前的format格式仅支持json；
1011	必须传入编码格式	错误原因： 接口请求时charset参数不能为空，必须传入charset编码格式参数； 解决方案： 1、目前的charset编码格式仅支持utf-8；
1012	编码格式错误	错误原因： 接口请求时charset参数值错误； 解决方案： 1、目前的charset编码格式仅支持utf-8；
1013	必须传入签名加密类型	错误原因： 接口请求时sign_type参数不能为空，必须传入签名加密类型； 解决方案： 1、目前的sign_type签名加密类型支持md5和rsa；
1014	签名加密类型错误	错误原因： 接口请求时sign_type参数值错误； 解决方案： 1、目前的sign_type签名加密类型支持md5和rsa；
1015	必须传入签名	错误原因： 接口请求时sign参数不能为空，必须传入签名参数； 解决方案： 1、在请求接口中填入sign参数；
1016	签名错误	错误原因： 接口请求时服务器会校验请求参数sign的准确性，签名加密参数或方法错误； 解决方案： 1、检查接口地址是否正确，比如沙箱环境和生产环境的地址混淆； 2、检查参数名称和参数值是否按照接口文档规范要求填写； 3、参数值null做为字符串参与签名； 4、按照“签名计算规则说明”文档示例数据在本地进行加密，比对加密结果排查问题； 5、接口请求签名、接口响应签名、异步回调签名规则都是一样，可参考https://docs.open.fulu.com/question3；
1017	必须传入请求参数集合	错误原因： 接口请求时biz_content参数不能为空，必须传入biz_content请求参数； 解决方案： 1、在请求接口中填入biz_content参数，如果没有业务参数，biz_conent的值为"{}"；
1018	缺少必要参数	错误原因： 接口请求时缺少必要参数，接口中缺失必填字段参数； 解决方案： 1、在开放平台在线调试获取模拟请求参数，进行参数比对；
1019	访问IP不在IP白名单内	错误原因： 接口请求服务器的外网IPv4格式IP地址没有添加到福禄商户控制台->应用配置->IP白名单中； 解决方案： 请将接口响应信息中的IP地址添加进去（目前各接口没有校验IP白名单，可不必配置IP白名单）。
2114	必须传入对账单获取单号	错误原因： 对账单申请接口请求时”账单获取单号”不能为空，必须传入”账单获取单号”请求参数； 解决方案： 1、在请求接口中填入”账单获取单号”参数(每次获取对账单的获取单号需要唯一，规则同下单接口中的外部订单号。)；
2115	必须传入对账单主题	错误原因： 对账单申请接口请求时”账单主题”不能为空，必须传入”账单主题”请求参数； 解决方案： 1、在请求接口中填入”账单主题”参数(对账单主题必须是汉字、数字、字母和下划线组成，长度50以内)；
2116	对账单主题格式错误	错误原因： 对账单申请接口请求时”账单主题”格式不符合要求； 解决方案： 1、在请求接口中按要求填入”账单主题”参数(对账单主题必须是汉字、数字、字母和下划线组成，长度50以内)；
2117	必须传入账单类型	错误原因： 对账单申请接口请求时”对账单类型”不能为空，必须传入”对账单类型”请求参数； 解决方案： 1、在请求接口中填入”对账单类型”参数(账单类型只能是1 (excel对账)、2(sftp对账))；
2118	账单类型错误	错误原因： 对账单申请接口请求时”对账单类型”格式不符合要求； 解决方案： 1、在请求接口中按要求填入”对账单类型”参数(账单类型只能是1 (excel对账)、2(sftp对账))；
2119	对账单excel列头错误	错误原因： 对账单申请接口请求时excel_column_header参数不符合规范； 解决方案： 1、在请求接口中按要求填入excel_column_header（生成excel的列头，Code必须是以下值：【OrderId,CustomerOrderNo,ChargeAccount,OrderType,BizType,OrderouterStatus,ProductId,ProductName,InvoiceType,MemberCode,MemberName,FaceValue,Buynum,PayAmount,RefundAmount,Createtime,Finishtime】，Title可以自定义且长度只能是10以内的汉字。列头可以自定义顺序减少列数，但必须与code表示的值相对应）；
2120	必须传入开始时间和结束时间	错误原因： 对账单申请接口请求时”开始时间和结束时间”不能为空，必须传入”开始时间和结束时间”请求参数； 解决方案： 1、在请求接口中填入”开始时间和结束时间”参数(时间格式为：yyyy-MM-dd，开始时间不能大于结束时间且时间差不能超过1个月)；
2121	开始时间或结束时间错误	错误原因： 对账单申请接口请求时“开始时间和结束时间”参数不符合规范； 解决方案： 1、在请求接口中填入”开始时间和结束时间”参数(时间格式为：yyyy-MM-dd，开始时间不能大于结束时间且时间差不能超过1个月)；
4012	查询异常，请重试	错误原因： 1、请求用户接口、获得商品信息接口、获得商品模板接口、查单接口时，请求参数与文档不匹配； 2、请求下单接口时，系统内部异常； 解决方案： 1、查单接口时：在开放平台在线调试获取模拟请求参数进行参数比对，或联系福禄运营处理； 2、下单接口时：联系福禄运营处理。请调用查单接口持续查询订单状态。如果查单返回4011(订单不存在)，并且120分钟后，还是返回4011状态，则人工处理； 注意：不要轻易失败订单，请一定要查单来确认订单状态；
5000	系统异常	错误原因： 1、请求查单接口时，请求参数(值或类型)与文档不匹配； 2、请求下单接口时，系统内部异常； 解决方案： 1、开发环境： ①请求接口方式：仅支持HTTP POST请求，Content-Type必须设置为：application/json； ②biz_content参数值需要正常解析为json的字符串类型，而非对象； ③在开放平台在线调试获取模拟请求参数进行参数比对； 2、生产环境： 联系福禄运营处理。请调用查单接口持续查询订单状态。如果查单返回4011(订单不存在)，并且120分钟后，还是返回4011状态，则人工处理； 注意：不要轻易失败订单，请一定要查单来确认订单状态；
	 */
	public function sendRequest(\Fulu\Request\Base $request, array $options = array())
	{
		$biz_content = $request->getParams();
		$apiMethodName = $request->getApiMethodName();
		// app_key	string	是	32	i4esv1l+76l/7NQCL3QudG90Fq+YgVfFGJAWgT+7qO1Bm9o/adG/1iwO2qXsAXNB	
		// 开放平台分配给商户的app_key
		// method	string	是	128	fulu.order.record.get	
		// 接口方法名称
		// timestamp	string	是	192	2014-07-24 03:07:50	
		// 时间戳，格式为：yyyy-MM-dd HH:mm:ss
		// version	string	是	3	2.0	
		// 调用的接口版本
		// format	string	是	10	json	
		// 接口请求或响应格式
		// charset	string	是	10	utf-8	
		// 请求使用的编码格式，如utf-8等
		// sign_type	string	是	10	md5	
		// 签名加密类型，目前仅支持md5
		// sign	string	是	344	详见示例	
		// 签名串，签名规则详见右侧《常见问题》中的“ 3.签名计算规则说明 ”
		// app_auth_token	string	是	40		
		// 授权码，固定值为“”
		// biz_content	string	是		"{\"order_record_get_no\": \"AC072426795315681646\",\"topic\": \"2019年12月份对账单\",\"reconciliation_type\": 1,\"excel_column_header\" : [{\"code\": \"OrderId\",\"title\": \"平台订单号\"}],\"begin_create_time\": \"2019-12-01\",\"end_create_time\": \"2019-12-02\",\"channel\": \"\"}"请求参数集合（注意：该参数是以json字符串的形式传输）
		$params = array();
		$params['app_key'] = $this->getAppKey();
		$params['method'] = $apiMethodName;
		$params['timestamp'] = date("Y-m-d H:i:s", time());
		$params['version'] = $this->_version;
		$params['format'] = $this->_format;
		$params['charset'] = $this->_charset;
		$params['sign_type'] = $this->_sign_type;
		$params['sign'] = $this->getSign($params);
		$params['app_auth_token'] = $this->_app_auth_token;
		// 无（注意：biz_content请按照空对象 "{}" 传递）
		if (empty($biz_content)) {
			$params['biz_content'] = '{}';
		} else {
			$params['biz_content'] = \json_encode($biz_content, 320);
		}
		$headers = array();
		$rst = $this->getRequest()->post($this->_url, $params, $headers);
		return $this->rst($rst);
	}

	public function getUrl()
	{
		// 正式环境	http://openapi.fulu.com/api/getway	https://openapi.fulu.com/api/getway
		// 沙箱环境	http://pre.openapi.fulu.com/api/getway	https://pre-openapi.fulu.com/api/getway
		if (!$this->_is_sandbox) {
			if ($this->_is_ssl) {
				$this->_url = 'https://openapi.fulu.com/api/getway';
			} else {
				$this->_url = 'http://openapi.fulu.com/api/getway';
			}
		} else {
			if ($this->_is_ssl) {
				$this->_url = 'https://pre-openapi.fulu.com/api/getway';
			} else {
				$this->_url = 'http://pre.openapi.fulu.com/api/getway';
			}
		}
		return $this->_url;
	}

	/**
	 * php签名方法
	 */
	public function getSign($Parameters)
	{
		//签名步骤一：把字典json序列化
		$json = json_encode($Parameters, 320);
		//签名步骤二：转化为数组
		$jsonArr = $this->mb_str_split($json);
		//签名步骤三：排序
		sort($jsonArr);
		//签名步骤四：转化为字符串
		$string = implode('', $jsonArr);
		//签名步骤五：在string后加入secret
		$string = $string . $this->_appSecret;
		//签名步骤六：MD5加密
		$result_ = strtolower(md5($string));
		return $result_;
	}
	/**
	 * 可将字符串中中文拆分成字符数组
	 */
	public function mb_str_split($str)
	{
		return preg_split('/(?<!^)(?!$)/u', $str);
	}

	/**
	 * 标准化处理服务端API的返回结果
	 */
	public function rst($rst)
	{
		return $rst;
	}
}
