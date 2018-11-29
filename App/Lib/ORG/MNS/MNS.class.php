<?php
require_once(__DIR__.'/mns-autoloader.php');
use AliyunMNS\Client;
use AliyunMNS\Topic;
use AliyunMNS\Constants;
use AliyunMNS\Model\MailAttributes;
use AliyunMNS\Model\SmsAttributes;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;
class MNS{
    public $SMSSignName;
    public $SMSTemplateCode;
    function __construct($sign,$code){
        $this->SMSSignName = $sign; //签名
        $this->SMSTemplateCode = $code; //短信模版编号
    }
    // 传入二维数组 接收手机及信息
    public function SendSMS($tel,$body = array()){
        /**
         * Step 1. 初始化Client
         */
        $this->endPoint = "http://1103229377032475.mns.cn-qingdao.aliyuncs.com"; // eg. http://1234567890123456.mns.cn-shenzhen.aliyuncs.com
        $this->accessId = "9BnPd7F***Xy8y";
        $this->accessKey = "***********";
        $this->client = new Client($this->endPoint, $this->accessId, $this->accessKey);
        /**
         * Step 2. 获取主题引用
         */
        $topicName = "sms.topic-cn-qingdao";
        $topic = $this->client->getTopicRef($topicName);
        /**
         * Step 3. 生成SMS消息属性
         */
        // 3.1 设置发送短信的签名（SMSSignName）和模板（SMSTemplateCode）
        $batchSmsAttributes = new BatchSmsAttributes($this->SMSSignName, $this->SMSTemplateCode);
        // 3.2 （如果在短信模板中定义了参数）指定短信模板中对应参数的值
        if(is_array($tel)){
            for ($i=0; $i < count($tel); $i++) { 
                $batchSmsAttributes->addReceiver("".$tel[$i]."", $body); //批量发送
            }
        }else{
            $batchSmsAttributes->addReceiver("".$tel."", $body); //单个发送
        }
        $messageAttributes = new MessageAttributes(array($batchSmsAttributes));
        /**
         * Step 4. 设置SMS消息体（必须）
         *
         * 注：目前暂时不支持消息内容为空，需要指定消息内容，不为空即可。
         */
         $messageBody = "smsmessage";
        /**
         * Step 5. 发布SMS消息
         */
        $request = new PublishMessageRequest($messageBody, $messageAttributes);
        try
        {
            $res = $topic->publishMessage($request);
            if($res->isSucceed()){
                return $res->getMessageId();
            }else{
                return false;
            }
        }
        catch (MnsException $e)
        {
            //echo $e;
            return false;
        }
    }
}
