<?php

namespace Fulu\Request\Order;

/**
 * fulu.order.direct.add 直充下单接口在线调试（沙箱环境）
接口介绍：直充商品下单接口，供合作方针对直充类型商品进行下单；

1、POST请求，Content-Type必须设置为：application/json；

2、接口是异步，接口调用成功(即下单成功)，不代表充值成功，最终“充值结果”，需要调用“订单查询接口”进行查询，由于是异步操作，建议间隔1-3s循环调用，直至最终结果；

3、“订单查询接口”必须接入；

4、直充商品必须调用商品模板，卡密商品无需调用商品模板；

 */
class DetailRequest extends \Fulu\Request\Base
{
	// 请求参数
	// 参数名称	字段类型	是否必填	最大长度	示例值 	描述
	// product_id	int	是	20	10000001 商品编号
	public $product_id = NULL;
	// customer_order_no	string	是	50	201906281030191013526	外部订单号
	public $customer_order_no = NULL;
	// charge_account	string	是	50	888888	充值账号
	public $charge_account = NULL;
	// buy_num	int	是	10	1	购买数量
	public $buy_num = NULL;
	// charge_game_name	string	否	50	三国群英传	充值游戏名称
	public $charge_game_name = NULL;
	// charge_game_region	string	否	50	电信一区	充值游戏区
	public $charge_game_region = NULL;
	// charge_game_srv	string	否	50	逐鹿中原	充值游戏服
	public $charge_game_srv = NULL;
	// charge_type	string	否	20	Q币	充值类型
	public $charge_type = NULL;
	// charge_password	string	否	50	充值密码，部分游戏类要传
	public $charge_password = NULL;
	// charge_ip	string	否	20	192.168.1.100	下单真实Ip，区域商品要传
	public $charge_ip = NULL;
	// contact_qq	string	否	50	联系QQ
	public $contact_qq = NULL;
	// contact_tel	string	否	15	联系电话
	public $contact_tel = NULL;
	// remaining_number	int	否	20	剩余数量
	public $remaining_number = NULL;
	// charge_game_role	string	否	50	赵云	充值游戏角色
	public $charge_game_role = NULL;
	// customer_price	double	否		1.00	外部销售价
	public $customer_price = NULL;
	// shop_type	string	否		淘宝	店铺类型（PDD、淘宝、天猫、京东、苏宁、其他；非必填字段，可忽略
	public $shop_type = NULL;

	// method	string	是	128	fulu.order.direct.add 接口方法名称
	protected $methodName = "order/detail";

	protected function buildParams()
	{
		$params = array();

		if ($this->isNotNull($this->product_id)) {
			$params['product_id'] = $this->product_id;
		}
		if ($this->isNotNull($this->customer_order_no)) {
			$params['customer_order_no'] = $this->customer_order_no;
		}
		if ($this->isNotNull($this->charge_account)) {
			$params['charge_account'] = $this->charge_account;
		}
		if ($this->isNotNull($this->buy_num)) {
			$params['buy_num'] = $this->buy_num;
		}
		if ($this->isNotNull($this->charge_game_name)) {
			$params['charge_game_name'] = $this->charge_game_name;
		}
		if ($this->isNotNull($this->charge_game_region)) {
			$params['charge_game_region'] = $this->charge_game_region;
		}
		if ($this->isNotNull($this->charge_game_srv)) {
			$params['charge_game_srv'] = $this->charge_game_srv;
		}
		if ($this->isNotNull($this->charge_type)) {
			$params['charge_type'] = $this->charge_type;
		}
		if ($this->isNotNull($this->charge_password)) {
			$params['charge_password'] = $this->charge_password;
		}
		if ($this->isNotNull($this->charge_ip)) {
			$params['charge_ip'] = $this->charge_ip;
		}
		if ($this->isNotNull($this->contact_qq)) {
			$params['contact_qq'] = $this->contact_qq;
		}
		if ($this->isNotNull($this->contact_tel)) {
			$params['contact_tel'] = $this->contact_tel;
		}
		if ($this->isNotNull($this->remaining_number)) {
			$params['remaining_number'] = $this->remaining_number;
		}
		if ($this->isNotNull($this->charge_game_role)) {
			$params['charge_game_role'] = $this->charge_game_role;
		}
		if ($this->isNotNull($this->customer_price)) {
			$params['customer_price'] = $this->customer_price;
		}
		if ($this->isNotNull($this->shop_type)) {
			$params['shop_type'] = $this->shop_type;
		}
		$this->param_json = $params;
	}
}
