<?php
require_once("util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>make_room_page</title>
  <?php require_once(HEAD_COMMON); ?>
</head>
<body>

<?php require_once(HEADER); ?>

<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center">部屋作成</h1>
      </div>
    </div>
    <?php
    $user_name = isset($_POST['userName']) ? $_POST['userName'] : '';
    $room_name = isset($_POST['roomName']) ? $_POST['roomName'] : '';
    $rounds    = isset($_POST['rounds']) ? $_POST['rounds']     : '';
    $password  = isset($_POST['password']) ? $_POST['password'] : '';
    $questions .= isset($_POST['word1']) ? $_POST['word1'] : '';
    $questions .= isset($_POST['word2']) ? $_POST['word2'] : '';


    if (isset($_POST['create'])) {
      if (empty($user_name) || empty($room_name) || empty($rounds) || empty($questions)) {
        echo "<h3>空の項目があります。再度入力してください</h3>";
      }else {

        $questions = substr( $questions , 0 , strlen($questions)-1 ); //末尾の_を削除

        //入力データをDBにインサート
        $data = array(
          'room_name' => $room_name,
          'rounds'    => $rounds,
          'password'  => $password,
          'questions' => $questions,
          'started'   => false
        );
        $result = insert($data,DB_TBL_ROOM);

        if(!is_string($result)){
          echo '<meta http-equiv="refresh" content="0;URL='.ROOM.'?room_id='.$result.'&user_name='.$user_name.'">';

        }else {
          err_log('mk_room',$result);
          echo '部屋の作成に失敗しました。';
        }

      }
    }
    ?>
    <div class="row">
      <div class="col-md-12">
        <p>※パスワードを設定しない場合は空欄にしてください。</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <form action="" method="post" id="room_info">
          <table class="table">
            <tr>
              <th>あなたの名前:</th>
              <td>
                <div class="form-group">
                  <input type="text" name="userName" class="form-control" placeholder="your name" required>
                </div>
              </td>
            </tr>
            <tr>
              <th>部屋名:</th>
              <td>
                <div class="form-group">
                  <input type="text" name="roomName" class="form-control" placeholder="room name" required>
                </div>
              </td>
            </tr>
            <tr>
              <th>ラウンド数:</th>
              <td>
                <div class="form-group">
                  <select name="rounds" class="form-control">
                    <?php
                    for($i=1; $i<=9; $i++){ ?>
                    <option value=<?php echo $i; if($i==3){echo " selected";}?>><?php echo $i ;?></option>
                    <?php } ?>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <th>お題:</th>
              <td>
                <div class="form-group">
                  <input type="checkbox" name="word1" value="fruits_">果物
                  <input type="checkbox" name="word2" value="peopleJhistory_">人物(日本史)
                </div>
              </td>
            </tr>
            <tr>
              <th>パスワード(任意):</th>
              <td>
                <div class="form-group">
                  <input type="text" name="password" class="form-control" placeholder="password">
                </div>
              </td>
            </tr>
          </table>
          <button type="submit" name="create" value="作成" class="btn btn-primary btn-lg" form="room_info">作成</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once(FOOTER); ?>

</body>
</html>
