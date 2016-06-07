<?php
require_once("util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

$room_id   = isset($_GET['room_id']) ? $_GET['room_id']     : '';
$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>room</title>
  <?php require_once(HEAD_COMMON); ?>
  <script src="<?php echo JS_MLKCCA;?>"></script>
  <script src="<?php echo JS_SCROLL;?>"></script>
</head>

<body>
  <?php
  //部屋の存在判定
  $result_search = search_rooms($room_id);
  if( ! is_array($result_search) ){

    err_log('search',$result_search);
    echo "<p>部屋が見つかりません</p>";

  }else if( empty($result_search) ){
    ?>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center">この部屋は存在しません</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <a href="<?php echo TOP;?>">トップページへ</a>
          </div>
        </div>
      </div>
    </div>
    <?php
  }else{
    $password = !empty($result_search[0]['password']) ? TRUE : FALSE;
    ?>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center" id="word">(待機中)</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-8">

            <div class="row" id="hints"></div>

            <div class="row">
              <div class="col-md-1">
                <button id="counter" type="button" class="btn btn-primary">0</button>
              </div>

              <div class="col-md-11 input-group">
                <input type="text" id="text" class="form-control">
                <span class="input-group-btn">
                  <button type="button" id="remark" class="btn btn-primary">発言</button>
                  <button type="button" id="join" class="btn btn-primary">参加</button>
                </span>
              </div>
            </div>

            <div class="row" id="panel">
              <div class="col-md-12">
                <div class="panel panel-primary">
                  <div class="panel-heading">情報</div>
                  <div class="panel-body" id="output"></div>
                </div>
              </div>
            </div>

          </div>

          <div class="col-xs-4" id="break">

            <div class="row" id ="mg_bottom">
              <div class="col-md-12">
                <button type="button" class="btn btn-primary" id='start'>ゲームスタート</button>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered" id='people'>
                </table>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6  text-center">
                <a href="https://twitter.com/share?url=<?php echo $url?>" type="button" class="btn btn-primary" target="_blank">
                  部屋をツイート
                </a>
              </div>

              <div class="col-sm-6  text-center">
                <button type="button" class="btn btn-primary" id="exit">退室</button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <?php require_once(FOOTER); ?>

    <script type="text/javascript">

      $(document).ready(function() {

        <?php
        require_once(JS_INIT);      //初期処理
        require_once(JS_CLICK);     //ボタンを押したときの処理
        require_once(JS_FUNCTION);  //部屋の人全員に動作する関数
        ?>

      });
    </script>
    <?php
  }
?>
</body>
</html>
