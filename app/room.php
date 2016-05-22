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
  ?>

  <!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>room</title>
    <meta name="keywords" content="">
    <meta name="description" content="オリジナルサイト作成">
    <!-- <link href="style.css" rel="stylesheet" media="all"> -->
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdn.mlkcca.com/v2.0.0/milkcocoa.js"></script>
    <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
  </head>

  <body>
    <header>
        <div class="title">
            <a href="<?php echo TOP ;?>">未定</a>
        </div>
    </header>
    <section>

      <div id="word">
        <h1></h1>
      </div>

      <div id="message">
        <h2></h2>
      </div>

      <div id="input">
        <input type="text" id="text" value="">
        <input type="button" id="remark" value="発言">
        <!-- <input type="text" id="user_name" value=""> -->
        <input type="button" id="join" value="参加">
      </div>

      <div id="hints">
        <?php for ($i=0; $i < 6; $i++) {
          echo "<div class='hint'></div>";
        } ?>
      </div>

      <div id="output">
        <p>chat</p>
      </div>

      <div id="people">
        <p>参加者</p>
        <ul>
        </ul>
      </div>

      <div id="err"></div>

      <input type="button" id="exit" value="退室">

      <input type="button" id="exam" value="実験">

      <input type="button" id='start' value="ゲームスタート">

    </section>
    <script type="text/javascript">
    $(document).ready(function() {

      <?php
      require_once(JS_INIT);      //初期処理
      require_once(JS_CLICK);     //ボタンを押したときの処理
      require_once(JS_FUNCTION);  //関数
      ?>

    });
    </script>
  </body>
  </html>
  <?php
}
