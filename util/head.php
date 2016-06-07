<?php
$url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
?>

<meta charset="UTF-8">
<meta name="keywords" content="お題当て,単語当て,スマホ,Android,iPhone,iOS,PC,ネットワーク対戦,ゲーム,チャット,リアルタイム">
<meta name="description" content="PC・iPhone・Androidスマホ対応。You got itは、出されたお題を別のヒントで表現し、相手プレイヤーたちに伝えるリアルタイムクイズゲームです。登録不要、ブラウザ上ですぐに遊べます。">

<meta http-equiv ="X-UA-Compatible" content="IE=edge">
<meta name ="viewport" content="width=device-width, initial-scale=1">

<link href ="<?php echo CSS_PINGENDO;?>" rel ="stylesheet" type ="text/css">
<link href ="<?php echo CSS_ICON;?>"     rel ="stylesheet" type ="text/css">
<link href ="<?php echo CSS_COMMON;?>"   rel ="stylesheet" type ="text/css">

<script src ="<?php echo JS_JQUERY;?>"></script>
<script src ="<?php echo JS_BS;?>"></script>
