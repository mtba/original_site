<?php
require_once("../util/defineUtil.php");
// require_once(SCRIPT);
require_once(DBACCESS);

$room_id   = isset($_GET['room_id']) ? $_GET['room_id']     : '';
$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';

//部屋の存在判定
$result_search = search_rooms($room_id);
if( ! is_array($result_search) ){

  err_log('search',$result_search);
  echo "<p>部屋が見つかりません</p>";

}else if( empty($result_search) ){
  ?>
  <h2>この部屋は存在しません</h2>
  <a href="<?php echo TOP;?>">トップページへ</a>
  <?php
}else{
  $password = !empty($result_search[0]['password']) ? TRUE : FALSE;
  ?>

  <!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>room</title>
    <meta name="keywords" content="">
    <meta name="description" content="オリジナルサイト">
    <!-- <link href="style.css" rel="stylesheet" media="all"> -->
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="../util/jquery.slimscroll.min.js"></script>
    <script src="https://cdn.mlkcca.com/v2.0.0/milkcocoa.js"></script>
    <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
  </head>

  <body>
    <section>

      <div id="wrap">
        <div id="room_top">
          <div id="word">(待機中)</div>
        </div>

        <div id="room_left">

          <div id="hints"></div>
          <div class="empty"></div>

          <div id="third stage">
            <div id="counter">0</div>
            <div id="room_input">
              <input type="text" id="text" value="">
              <input type="button" id="remark" value="発言">
              <!-- <input type="text" id="user_name" value=""> -->
              <input type="button" id="join" value="参加">
            </div>
            <div class="empty"></div>
          </div>

          <div class="some-content-related-div">
            <div id="output"></div>
          </div>

        </div>

        <div id="room_right">
          <input type="button" id='start' value="ゲームスタート">
          <table id='people'></table>
          <input type="button" id="exit" value="退室">
        </div>

        <!-- <input type="button" id="exam" value="実験"> -->
        <div class="empty"></div>
      </div>

    </section>

    <script type="text/javascript">
      $(document).ready(function() {

        <?php
        require_once(JS_INIT);      //初期処理
        require_once(JS_CLICK);     //ボタンを押したときの処理
        require_once(JS_FUNCTION);  //部屋の人全員に動作する関数
        ?>

      });
    </script>
  </body>
  </html>
  <?php
}
