<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付</title>
    <style type="text/css">
        ul {
            margin-left:10px;
            margin-right:10px;
            margin-top:10px;
            padding: 0;
        }
        li {
            width: 32%;
            float: left;
            margin: 0px;
            margin-left:1%;
            padding: 0px;
            height: 100px;
            display: inline;
            line-height: 100px;
            color: #fff;
            font-size: x-large;
            word-break:break-all;
            word-wrap : break-word;
            margin-bottom: 5px;
        }
        a {
            -webkit-tap-highlight-color: rgba(0,0,0,0);
        	text-decoration:none;
            color:#fff;
        }
        a:link{
            -webkit-tap-highlight-color: rgba(0,0,0,0);
        	text-decoration:none;
            color:#fff;
        }
        a:visited{
            -webkit-tap-highlight-color: rgba(0,0,0,0);
        	text-decoration:none;
            color:#fff;
        }
        a:hover{
            -webkit-tap-highlight-color: rgba(0,0,0,0);
        	text-decoration:none;
            color:#fff;
        }
        a:active{
            -webkit-tap-highlight-color: rgba(0,0,0,0);
        	text-decoration:none;
            color:#fff;
        }
    </style>
</head>
<body>
	<div align="center">
        <ul>
            <!--<li style="background-color:#FF7F24"><a href="http://paysdk.weixin.qq.com/example/jsapi.php">JSAPI支付</a></li>
            <li style="background-color:#698B22"><a href="http://paysdk.weixin.qq.com/example/micropay.php">刷卡支付</a></li>
            <li style="background-color:#8B6914"><a href="http://paysdk.weixin.qq.com/example/native.php">扫码支付</a></li>-->
            <!--<li style="background-color:#CD3278"><a href="http://paysdk.weixin.qq.com/example/refund.php">订单退款</a></li>
            <li style="background-color:#848484"><a href="http://paysdk.weixin.qq.com/example/refundquery.php">退款查询</a></li>
            <li style="background-color:#8EE5EE"><a href="http://paysdk.weixin.qq.com/example/download.php">下载订单</a></li>-->

            <!--TODO: 修改lib里面的配置文件，以及下面的yourServer-->
            <a href="yourServer/demo/tool/example/orderquery.php"><li style="background-color:#CDCD00">订单查询</li></a>
            <a href="yourServer/demo/tool/example/refund.php"><li style="background-color:#CD3278">订单退款</li></a>
            <a href="yourServer/demo/tool/example/refundquery.php"><li style="background-color:#848484">退款查询</li></a>
            <a href="yourServer/demo/tool/example/download.php"><li style="background-color:#8EE5EE">下载订单</li></a>
            <a href="yourServer/demo/tool/example/simulateNotify.php"><li style="background-color:#CD3278">模拟微信服务器回调</li></a>
        </ul>
	</div>
</body>
</html>
