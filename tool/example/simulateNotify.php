<?php
/**
 * @desc 发送xml数据，并显示对方url响应的数据
 * @author gaojingchang
 * @param $_xml         要发送的xml
 * @param $_sendUrl     接收XML地址
 */
function sendXml($_xml, $_sendUrl) {

    $header = ['Content-type: text/xml'];//定义content-type为xml
    $ch = curl_init(); //初始化curl
    curl_setopt($ch, CURLOPT_URL, $_sendUrl);//设置链接
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置HTTP头
    curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $_xml);//POST数据
    $response = curl_exec($ch);//接收返回信息
    if(curl_errno($ch)){//出错则显示错误信息
        print curl_error($ch);
    }
    curl_close($ch); //关闭curl链接
    return $response;//显示返回信息

}


if($_POST) {
    $url = $_POST['url'];
    $xml = trim( urldecode( $_POST['xml'] ) );

    $response = sendXml($xml, $url);

    header('Content-Type:application/json; charset=utf-8');
    exit( json_encode( ['data'=>$response] ) );
}
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>微信支付样例-模拟回调</title>
</head>

    <div style="margin-left:2%;">回调url：</div><br/>
    <input id="url" type="text" style="width:96%;height:35px;margin-left:2%;" name="notifyUrl" value="http://localhost/demo/asynNotify/wechatNotify.php"/><br /><br />
    <div style="margin-left:2%;">回调数据：</div><br/>
    <textarea id="data" name="data" style='width:96%;height:500px;margin-left:2%;font-size: larger;color: #8d8d8d;background: #f4f5f9;line-height:1.5;font:14px/1.6 "Helvetica Neue","Hiragino Sans GB","Microsoft YaHei","\9ED1\4F53",Arial,sans-serif;text-decoration:none;'>
<xml>
    <appid><![CDATA[wxdf3b0ba50621234a]]></appid>
    <bank_type><![CDATA[CMB_DEBIT]]></bank_type>
    <cash_fee>1000</cash_fee>
    <fee_type><![CDATA[CNY]]></fee_type>
    <is_subscribe><![CDATA[N]]></is_subscribe>
    <mch_id><![CDATA[1403711234]]></mch_id>
    <nonce_str><![CDATA[70x7hdrzlkdy4g6s88qd0tbagp0p4he5]]></nonce_str>
    <openid><![CDATA[ouRibv37_47bLoSRTU4L9frxuuuu]]></openid>
    <out_trade_no><![CDATA[CZ20161111125035193275]]></out_trade_no>
    <result_code><![CDATA[SUCCESS]]></result_code>
    <return_code><![CDATA[SUCCESS]]></return_code>
    <sign><![CDATA[D7975C543D77E0B043A18DE9EB6EFB28]]></sign>
    <time_end><![CDATA[20161111125042]]></time_end>
    <total_fee>1000</total_fee>
    <trade_type><![CDATA[APP]]></trade_type>
    <transaction_id><![CDATA[4002912001201611119405321234]]></transaction_id>
</xml>
    </textarea>

<br/><br/><div style="margin-left:2%;">对方服务器响应：</div><br/>
<textarea id="response" name="data" style='width:96%;height:500px;margin-left:2%;font-size: larger;color: #8d8d8d;background: #f4f5f9;line-height:1.5;font:14px/1.6 "Helvetica Neue","Hiragino Sans GB","Microsoft YaHei","\9ED1\4F53",Arial,sans-serif;text-decoration:none;'>
    </textarea>
    <!--<input name="data" id="data" type="text" value="<tr><td>123</td></tr>" style="width: 96%;height: 500px;">-->
    <div align="center">
        <input type="button" id="submitIt" value="确定" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" />
    </div>

</body>


<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
<script>
    $('#submitIt').bind('click', function () {
        var str = encodeURIComponent($('#data').val());
        var url = $('#url').val();

        $.post('#', {xml: str, url: url}, function (_res) {
            $('#response').val(_res.data);
        })
    })
</script>

<!--<xml>
    <appid><![CDATA[wxdf3b0ba50620564a]]></appid>
    <bank_type><![CDATA[CMB_DEBIT]]></bank_type>
    <cash_fee>1000</cash_fee>
    <fee_type><![CDATA[CNY]]></fee_type>
    <is_subscribe><![CDATA[N]]></is_subscribe>
    <mch_id><![CDATA[1412341234]]></mch_id>
    <nonce_str><![CDATA[70x7hdrzlkdy4g6s88qd0tbagp0p4he5]]></nonce_str>
    <openid><![CDATA[ouRibv37_47bLoSRTU4L9frxuuuu]]></openid>
    <out_trade_no><![CDATA[CZ20161111125035193275]]></out_trade_no>
    <result_code><![CDATA[SUCCESS]]></result_code>
    <return_code><![CDATA[SUCCESS]]></return_code>
    <sign><![CDATA[D7975C543D77E0B043A18DE9EB6EFB28]]></sign>
    <time_end><![CDATA[20161111125042]]></time_end>
    <total_fee>1000</total_fee>
    <trade_type><![CDATA[APP]]></trade_type>
    <transaction_id><![CDATA[4002912001201611119412341234]]></transaction_id>
</xml>-->

</html>
