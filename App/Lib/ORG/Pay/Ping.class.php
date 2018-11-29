<?php
require dirname(__FILE__) . '/init.php';
class Ping{
	public $api_key = 'sk_live_5mDmb5jXfzDOGyHabPmXjDK4';
	public $app_id = 'app_jnHO0Sarrj9KPKeT';
	// 支付
	function pay($channel='wx_pub',$amount=1,$ext=array()){
		\Pingpp\Pingpp::setPrivateKeyPath(__DIR__ . '/rsa_private_key.pem');
		/**
		 * $extra 在使用某些渠道的时候，需要填入相应的参数，其它渠道则是 array()。
		 * 以下 channel 仅为部分示例，未列出的 channel 请查看文档 https://pingxx.com/document/api#api-c-new
		 */
		$extra = array();
		switch ($channel) {
		    case 'alipay_wap':
		        $extra = array(
		            'success_url' => $ext['success'],
		            'cancel_url' => $ext['cancel']
		        );
		        break;
		    case 'bfb_wap':
		        $extra = array(
		            'result_url' => 'http://example.com/result',
		            'bfb_login' => true
		        );
		        break;
		    case 'upacp_wap':
		        $extra = array(
		            'result_url' => 'http://example.com/result'
		        );
		        break;
		    case 'wx_pub':
		        $extra = array(
		            'open_id' => $ext['openid']
		        );
		        break;
		    case 'wx_pub_qr':
		        $extra = array(
		            'product_id' => 'Productid'
		        );
		        break;
		    case 'yeepay_wap':
		        $extra = array(
		            'product_category' => '1',
		            'identity_id'=> 'your identity_id',
		            'identity_type' => 1,
		            'terminal_type' => 1,
		            'terminal_id'=>'your terminal_id',
		            'user_ua'=>'your user_ua',
		            'result_url'=>'http://example.com/result'
		        );
		        break;
		    case 'jdpay_wap':
		        $extra = array(
		            'success_url' => 'http://example.com/success',
		            'fail_url'=> 'http://example.com/fail',
		            'token' => 'dsafadsfasdfadsjuyhfnhujkijunhaf'
		        );
		        break;
		}

		// 设置 API Key
		\Pingpp\Pingpp::setApiKey($this->api_key);
		try {
		    $ch = \Pingpp\Charge::create(
		        array(
		            'subject'   => $ext['subject'],
		            'body'      => $ext['body'],
		            'amount'    => $amount,
		            'order_no'  => $ext['orderid'],
		            'currency'  => 'cny',
		            'extra'     => $extra,
		            'channel'   => $channel,
		            'client_ip' => $_SERVER['REMOTE_ADDR'],
		            'app'       => array('id' => $this->app_id)
		        )
		    );
		    echo $ch;
		} catch (\Pingpp\Error\Base $e) {
		    // 捕获报错信息
		    if ($e->getHttpStatus() != NULL) {
		        header('Status: ' . $e->getHttpStatus());
		        echo $e->getHttpBody();
		    } else {
		        echo $e->getMessage();
		    }
		}
	}


	// WEBHOOKS验证签名
	function validhooks(){
		$raw_data = file_get_contents('php://input');
		// 示例
		// $raw_data = '{"id":"evt_eYa58Wd44Glerl8AgfYfd1sL","created":1434368075,"livemode":true,"type":"charge.succeeded","data":{"object":{"id":"ch_bq9IHKnn6GnLzsS0swOujr4x","object":"charge","created":1434368069,"livemode":true,"paid":true,"refunded":false,"app":"app_vcPcqDeS88ixrPlu","channel":"wx","order_no":"2015d019f7cf6c0d","client_ip":"140.227.22.72","amount":100,"amount_settle":0,"currency":"cny","subject":"An Apple","body":"A Big Red Apple","extra":{},"time_paid":1434368074,"time_expire":1434455469,"time_settle":null,"transaction_no":"1014400031201506150354653857","refunds":{"object":"list","url":"/v1/charges/ch_bq9IHKnn6GnLzsS0swOujr4x/refunds","has_more":false,"data":[]},"amount_refunded":0,"failure_code":null,"failure_msg":null,"metadata":{},"credential":{},"description":null}},"object":"event","pending_webhooks":0,"request":"iar_Xc2SGjrbdmT0eeKWeCsvLhbL"}';
		$headers = \Pingpp\Util\Util::getRequestHeaders();
		// 签名在头部信息的 x-pingplusplus-signature 字段
		$signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;
		// 示例
		// $signature = 'BX5sToHUzPSJvAfXqhtJicsuPjt3yvq804PguzLnMruCSvZ4C7xYS4trdg1blJPh26eeK/P2QfCCHpWKedsRS3bPKkjAvugnMKs+3Zs1k+PshAiZsET4sWPGNnf1E89Kh7/2XMa1mgbXtHt7zPNC4kamTqUL/QmEVI8LJNq7C9P3LR03kK2szJDhPzkWPgRyY2YpD2eq1aCJm0bkX9mBWTZdSYFhKt3vuM1Qjp5PWXk0tN5h9dNFqpisihK7XboB81poER2SmnZ8PIslzWu2iULM7VWxmEDA70JKBJFweqLCFBHRszA8Nt3AXF0z5qe61oH1oSUmtPwNhdQQ2G5X3g==';
		// 请从 https://dashboard.pingxx.com 获取「Ping++ 公钥」
		$pub_key_path = __DIR__ . "/pingpp_rsa_public_key.pem";
		$result = $this->verify_signature($raw_data, $signature, $pub_key_path);
		if ($result === 1) {
		    // 验证通过
		    $event = json_decode($raw_data, true);
		    return $event;
		} elseif ($result === 0) {
		    http_response_code(400);
		    echo 'verification failed';
		    exit;
		} else {
		    http_response_code(400);
		    echo 'verification error';
		    exit;
		}
	}

	// 验证 webhooks 签名方法
	protected function verify_signature($raw_data, $signature, $pub_key_path) {
	    $pub_key_contents = file_get_contents($pub_key_path);
	    // php 5.4.8 以上，第四个参数可用常量 OPENSSL_ALGO_SHA256
	    return openssl_verify($raw_data, base64_decode($signature), $pub_key_contents, 'sha256');
	}

	// 退款操作
	public function pullback($id,$amount,$des=''){
		\Pingpp\Pingpp::setPrivateKeyPath(__DIR__ . '/rsa_private_key.pem');
		\Pingpp\Pingpp::setApiKey($this->api_key);
		$ch = \Pingpp\Charge::retrieve($id);
		$re = $ch->refunds->create(
		    array(
		        'amount' => $amount,
		        'description' => $des
		    )
		);
		return json_decode($re,true);
	}


}