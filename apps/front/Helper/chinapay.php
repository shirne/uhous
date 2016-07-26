<?php


//导入数据库配置
#$db_config = include ('../../../configiers/database.php');

/**
* 银联支付
*/
class chinapay {

	//私钥文件，在CHINAPAY申请商户号时获取，请相应修改此处，可填相对路径，下同
	const PRI_KEY = 'C:\windows\MerPrk.key';
	const MER_ID = '808080580107658';

	//无卡商户号
	const PRI_KEY_NO = 'C:\windows\MerPrkNO.key';
	const MER_ID_NO = '808080580107659';

	//公钥文件，示例中已经包含
	const PUB_KEY = 'C:\windows\PgPubk.key';
	const PUB_ID = '999999999999999';
	//支付请求地址(测试)
	//const REQ_URL_PAY='http://payment-test.ChinaPay.com/pay/TransGet';
	//支付请求地址(生产)
	const REQ_URL_PAY = 'https://payment.ChinaPay.com/pay/TransGet';

	//后台处理URL
	private $BG_URL;
	#'http://www.uhous.com/apps/common/chinapay/backASIN98556.php';

	//查询请求地址(测试)
	const REQ_URL_QRY = 'http://payment-test.chinapay.com/QueryWeb/processQuery.jsp';

	//查询请求地址(生产)
	//const REQ_URL_QRY='http://c**ole.chinapay.com/QueryWeb/processQuery.jsp';

	//退款请求地址(测试)
	//const REQ_URL_REF = 'http://payment-test.chinapay.com/refund/SingleRefund.jsp';

	//退款请求地址(生产)
	const REQ_URL_REF='https://bak.chinapay.com/refund/SingleRefund.jsp';

	private $gateid = '';
	private $pd = '';
	private $npc = null;
	
	public $log='';
	
	/**
	* 构造函数
	* @access public
	* @param
	* @return void
	*/
	function __construct() {
	    $this->BG_URL='http://' . $_SERVER['SERVER_NAME'] . url('check','chinapayback');
		$this->npc = new COM("CPNPC.NPC");
		if ($_POST['nocard'] == '1') {
			//秘钥
			$this->npc->setMerKeyFile(self :: PRI_KEY_NO);
			$this->npc->setPubKeyFile(self :: PUB_KEY);

			//参数
			$this->gateid = '8607';
			$this->pd = self :: MER_ID_NO;
		} else {
			//秘钥
			$this->npc->setMerKeyFile(self :: PRI_KEY);
			$this->npc->setPubKeyFile(self :: PUB_KEY);
			$this->pd = self :: MER_ID;
		}
	}

	/**
	* 生成支付代码
	* @param array $order 订单信息
	* @param array $payment 支付方式信息
	*/
	function load($order, $payment, $url, $priv, $date = null) {

		if (!$date)
			$date = time();
		$date = date('Ymd', $date);
		$order = shopsn2chinapaysn($order);
		$payment = formatamount($payment);

		//数字签名
		//$chValue=$this->npc->sign($this->pd, $order, $payment, "156", $date, "0001");

		//字符串签名
		$ckStr = $this->npc->signData($this->pd, $this->pd . $order . $payment . "156" . $date . "0001" . $priv);
		header('Content-type: text/html; charset=utf-8');
		echo '<form action="' . self :: REQ_URL_PAY . '" name="chinapay" METHOD=POST>' .
		'<input type="hidden" name="MerId" value="' . $this->pd . '"/>' .
		'<input type="hidden" name="OrdId" value="' . $order . '"/>' .
		'<input type="hidden" name="TransAmt" value="' . $payment . '"/>' .
		'<input type="hidden" name="CuryId" value="156"/>' .
		'<input type="hidden" name="TransDate" value="' . $date . '"/>' .
		'<input type="hidden" name="TransType" value="0001"/>' .
		'<input type="hidden" name="Version" value="20070129"/>' .
		'<input type="hidden" name="BgRetUrl" value="' . $this->BG_URL . '"/>' .
		'<input type="hidden" name="PageRetUrl" value="' . $url . '"/>' .
		'<input type="hidden" name="GateId" value="' . $this->gateid . '">' .
		'<input type="hidden" name="Priv1" value="' . $priv . '">' .
		'<input type="hidden" name="ChkValue" value="' . $ckStr . '">' .
		'正在转跳中...<input type="submit" value="确认"></form>' .
		'<script>document.chinapay.submit();</script>' .
		'</form>';
	}
	
	function ctype($id){
	    if(self::MER_ID==$id){
	        return 2;
	    }
	    if(self::MER_ID_NO==$id){
	        return 3;
	    }
	    return 0;
	}

	/**
	 * check
	 */
	function check($data) {
		if (self :: MER_ID !== $data['merid'] && self :: MER_ID_NO !== $data['merid']) {
			return false;
		}

		//文档记录:订单ID,订单号,金额,时间,其它信息
		$this->log = $data['Priv1'] . "\t" . $data['orderno'] . "\t" . $data['amount'] . "\t" . date('Y-m-d H:i:s') . "\t";

		if ($data['status'] !== '1001') {
			$this->log .= '交易失败';
			return false;
		}
		
        if ($this->npc->check($data['merid'], $data['orderno'], $data['amount'], '156', $data['transdate'], '0001', $data['status'], $data['checkvalue']) === '0') {
			//验证交易成功,更新数据库
			$this->log .= '验证成功';
			return true;


		} else {
			$this->log .= '验证失败';
			return false;
		}

	}
}

/*
*本地订单号转为银联订单号
*/
function shopsn2chinapaysn($order) {
	$l = strlen($order);
	if ($l < 16) {
		$od = str_repeat('0', 16 - $l) . $order;
	} else
		if ($l > 16) {
			$od = substr($order, $l -16);
		} else
			if ($l == 16) {
				$od = $order;
			}
	return $od;
}

/*
 * 银联订单号转为本地订单号
 */
function chinapaysn2shopsn($chinapaysn) {
	if ($chinapaysn) {
		$year = date('Y', time());
		return substr($year, 0, 2) . substr($chinapaysn, 0, 4) . substr($chinapaysn, 9);
	}
}

/*
 * 格式化交易金额，以分位单位的12位数字。
 */
function formatamount($amount) {
	if ($amount) {
		if (!strstr($amount, ".")) {
			$amount = $amount . ".00";
		}

		$amount = str_replace(".", "", $amount);
		$temp = $amount;
		for ($i = 0; $i < 12 - strlen($amount); $i++) {
			$temp = "0" . $temp;
		}
		return $temp;
	}
}
