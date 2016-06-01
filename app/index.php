<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>top</title>
  <meta name="keywords" content="">
  <meta name="description" content="オリジナルサイト作成">
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <!-- <link rel="stylesheet" type="text/css" href=<?php //echo CSS_COMMON;?>> -->
  <!-- BootstrapのCSS読み込み -->
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <!-- jQuery読み込み -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
  <!-- <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> -->
  <!-- <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once(HEADER); ?>

<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center">部屋一覧</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-right">
        <a class="btn btn-primary" href="<?php echo MK_ROOM ;?>">部屋を作る</a>
      </div>
    </div>
    <?php
    $result = search_rooms();

    if( ! is_array($result) ){

      err_log('トップでの部屋検索',$result);
      echo "<p>部屋の検索に失敗しました</p>";

    }else if( empty($result) ){
      echo "<h2>部屋がありません</h2>";
    }else{
      $i = 1;
      foreach ($result as $key=> $value) {

        if ( $i%4 == 1 ) {
          echo "<div class='row'>";
        }

        $room_info = "<a href='" .ROOM. "?room_id=".$value['id']."' class='col-sm-3'>";
        $room_info .= "<h1 class='text-center'>".$value['room_name']."</h1>";
        $room_info .= "<ul class='list-unstyled'><li>パスワード";
        if ( !empty($value['password']) ) {
          $room_info .= "あり</li>";
        }else {
          $room_info .= "なし</li>";
        }
        $room_info .= "<li>ラウンド数:".$value['rounds']."</li><li>";
        if ($value['started'] == 0) {
          $room_info .= "待機中</li>";
        }else {
          $room_info .= "ゲーム中</li>";
        }
        $room_info .= "</ul></a>";

        echo $room_info;

        if ( $i%4 == 0 ) {
          echo "</div>";
        }
        $i++;
      }
      if ($i%4 != 0) {
        echo "</div>";
      }
    }
    ?>
  </div>
</div>

<?php require_once(FOOTER); ?>

</body>
</html>
