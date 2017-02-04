<?php
/**
 * 微信支付异步通知处理
*/

//引入相关库文件
require_once('./lib/WxPay.Api.php');
require_once('./lib/WxPay.Notify.php');

//初始化日志
include_once('./lib/log.php');
$logHandler= new CLogFileHandler(WxPayConfig::WX_LOG_DIR . '/' . date('Ymd') . 'notify.log');
$log = Log::Init($logHandler, 15);

//重写回调父类
class PayNotifyCallBack extends WxPayNotify
{

    /**
     * TODO: 充值成功的业务处理，建议添加锁
     * @param $orderNo              你自己的商户订单号
     * @param $serialsNo            微信支付订单号
     * @param $transferredAmount    订单总金额，单位为分
     * @return boolean
     */
    private function yourBusinessHandler($orderNo, $serialsNo, $transferredAmount) {

    }

    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::RECORD("query:" . json_encode($result));

        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        global $config, $db;

        //记录微信服务器回调的数据
        Log::RECORD("call back:" . json_encode($data, JSON_UNESCAPED_UNICODE));

        $notfiyOutput = array();

        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }

        //进行业务处理
        $handlerRet = $this->yourBusinessHandler( $data['out_trade_no'], $data['transaction_id'], $data['total_fee'] );
        if(!$handlerRet) {
            $msg = '商户业务处理失败';
            return false;
        }

        return true;
    }
}

//日志
Log::RECORD("begin notify");

//响应微信服务器
$notify = new PayNotifyCallBack();
$notify->Handle(false);