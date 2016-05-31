<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>mk_room</title>
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
    <h2>部屋作成</h2>
    <?php
    $user_name = isset($_POST['userName']) ? $_POST['userName'] : '';
    $room_name = isset($_POST['roomName']) ? $_POST['roomName'] : '';
    $rounds    = isset($_POST['rounds']) ? $_POST['rounds']     : '';
    $password  = isset($_POST['password']) ? $_POST['password'] : '';

    if (isset($_POST['create'])) {
      if (empty($user_name) || empty($room_name) || empty($rounds)) {
        echo "<h3>空の項目があります。再度入力してください</h3>";
      }else {
        //入力データをDBにインサート
        $data = array(
          'room_name' => $room_name,
          'rounds'    => $rounds,
          'password'  => $password,
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
    <p>パスワードを設定しない場合は空欄にしてください。</p>
    <form action="" method="post">
      <p>あなたの名前:<input type="text"name="userName" value="<?php echo h($user_name);?>"></p>
      <p>部屋名:<input type="text" name="roomName" value="<?php echo h($room_name);?>"></p>
      <p>ラウンド数:<input type="text" name="rounds" value="<?php echo h($rounds);?>"></p>
      <p>パスワード(任意):<input type="text" name="password" value="<?php echo h($password);?>"></p>
      <input type="submit" name="create" value="作成">
    </form>
  </section>
</body>
</html>
