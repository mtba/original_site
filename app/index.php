<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>top</title>
  <meta name="keywords" content="">
  <meta name="description" content="オリジナルサイト作成">
  <!-- <link href="style.css" rel="stylesheet" media="all"> -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <!-- <script src="https://cdn.mlkcca.com/v2.0.0/milkcocoa.js"></script> -->
  <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
</head>

<body>
  <header>
      <div class="title">
          <a href="<?php echo TOP ;?>">未定</a>
      </div>
      <div class="right">
        <ul>
          <li>
            <a href="<?php echo HOW;?>">遊び方</a>
          </li>
          <li>
            <a href="<?php echo CONTACT;?>">お問合せ</a>
          </li>
        </ul>
      </div>
  </header>
  <section>
    <h2>部屋一覧</h2>
    <div id="rooms">
    </div>
    <a href="<?php echo MK_ROOM;?>">部屋を作る</a>
    <?php
    $result = search_rooms();

    if( ! is_array($result) ){

      err_log('トップでの部屋検索',$result);
      echo "<p>データの検索に失敗しました</p>";

    }else{
      // var_dump($result);
      echo "<ul>";
      foreach ($result as $key => $value) {
        // echo "<li><a href='" .ROOM. "?room_id=".$value['id']."'>" .$value['room_name']. "</a></li>";
        $room_info = "<a class='rooms_top' href='" .ROOM. "?room_id=".$value['id']."'><ul><li>" .$value['room_name']. "</li><li>";
        if ( !empty($value['password']) ) {
          $room_info .= "パスワードあり</li>";
        }
        $room_info .= "<li>ラウンド数:".$value['rounds']."</li><li>";
        if ($value['started'] == 0) {
          $room_info .= "待機中</li></a>";
        }else {
          $room_info .= "ゲーム中</li></ul></a>";
        }
        echo $room_info;
      }
    }
    ?>
    <div class="empty"></div>
  </section>
  <!-- <form action="room.php" method="post">
    <input type="submit" value="部屋">
    <input type="submit" name="name" value="">
  </form> -->
</body>
<script type="text/javascript">
  $(document).ready(function(){
    $('#ex').click(function(){
      var room_info;
      if ($('#rooms')) {

      }else {
        room_info=1;
        $('#rooms').append.html('<form action="room.php" method="post"><input type="submit" value="部屋"><input type="submit" name="name" value="'+room_info+'">');
      }
      $('#rooms ul').append.html();
    });
  });
</script>
</html>
