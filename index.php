<?php
require_once("util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>top</title>
  <?php require_once(HEAD_COMMON); ?>
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
        $room_info .= "<h2 class='text-center'>".$value['room_name']."</h2>";
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
