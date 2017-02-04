<?php
/**
 * 生成微信预付订单
 */

//初始化日志
include_once('./lib/wechatPay/WxPay.Api.php');
include_once( './lib/wechatPay/log.php');
$logHandler= new CLogFileHandler(WxPayConfig::WX_LOG_DIR . '/' . date('Ymd') . 'createPrePay' .'.log');
$log = Log::Init($logHandler, 15);

//TODO: 商家自己的业务处理，需要生成商户订单号、交易总金额


//根据预支付所需要的参数，生成数据对象
$input = new WxPayUnifiedOrder();
$input->SetBody( WxPayConfig::GOODS_DESC ); //商品描述(APP——需传入应用市场上的APP名字-实际商品名称，天天爱消除-游戏充值。)
$input->SetOut_trade_no( $rechargeOrderNo );    //商户订单
$input->SetTotal_fee( $totalFee );      //总金额，单位分
$input->SetTrade_type('APP');               //交易类型

//根据订单的数据对象，生成预支付
try{

    $prePayRes = WxPayApi::unifiedOrder($input);

} catch (WxPayException $e) {

    //日志
    Log::RECORD( "preparePay fail[orderNo:$rechargeOrderNo]:错误原因({$e->errorMessage()})" );

    //TODO: 给APP返回错误结果

};


//判断创建预支付订单的结果
if($prePayRes['return_code'] == 'SUCCESS' ) {

    if($prePayRes['result_code'] == 'SUCCESS') {
        //根据APP端所需传递微信服务器的参数，生成签名
        $reInput = new WxReturnPrepay();
        $reInput->SetAppid( WxPayConfig::APPID );
        $reInput->SetPartnerid( WxPayConfig::MCHID );
        $reInput->SetPrepayid( $prePayRes['prepay_id'] );
        $reInput->SetPackage('Sign=WXPay');
        $reInput->SetNoncestr( WxPayApi::getNonceStr(32) );
        $reInput->SetTimestamp( time() );
        $reInput->SetSign();
        //$reXml = $reInput->ToXml();

        //返回成功结果
        $result['Result']['resultCode'] = 0;
        $result['Result']['rechargeOrderNo'] = $rechargeOrderNo;
        $result['PrePayData']['appId'] = $reInput->GetAppid();
        $result['PrePayData']['partnerId'] = $reInput->GetPartnerid();
        $result['PrePayData']['prepayId'] = $reInput->GetPrepayid();
        $result['PrePayData']['packageValue'] = $reInput->GetPackage();
        $result['PrePayData']['nonceStr'] = $reInput->GetNoncestr();
        $result['PrePayData']['timeStamp'] = $reInput->GetTimestamp();
        $result['PrePayData']['sign'] = $reInput->GetSign();
        //$result['OrderNo'] = $rechargeOrderNo;

        //充值日志
        Log::RECORD("preparePay success[orderNo:$rechargeOrderNo]:" . json_encode($result));

    } else {
        //TODO: 创建预支付失败，给APP返回结果


    }

} else {

    //TODO: 创建预支付失败，给APP返回结果


}