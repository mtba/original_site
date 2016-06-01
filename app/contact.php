<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

$field_name    = isset($_POST['name']) ? $_POST['name']       : '';
$field_email   = isset($_POST['mail']) ? $_POST['mail']     : '';
$field_message = isset($_POST['message']) ? $_POST['message'] : '';

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>contact</title>
  <meta name="keywords" content="">
  <meta name="description" content="オリジナルサイト作成">
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once(HEADER);

if ( !empty($field_name) && !empty($field_email) && !empty($field_message) ) {

  $mail_to = 'mtba9lear@gmail.com';
  $subject = 'Message from a site visitor '.$field_name;
  $body_message  = 'From: '.$field_name."\n";
  $body_message .= 'E-mail: '.$field_email."\n";
  $body_message .= 'Message: '.$field_message;
  $headers  = 'From: '.$field_email."\r\n";
  $headers .= 'Reply-To: '.$field_email."\r\n";
  $mail_status = mail($mail_to, $subject, $body_message, $headers);

  if ($mail_status) { ?>
      <script language="javascript" type="text/javascript">
        alert('送信しました。');
          // window.location = 'thanks.html#contact（※送信後に移動するページ）';
      </script>
  <?php
  }
  else { ?>
      <script language="javascript" type="text/javascript">
          alert('メッセージ送信に失敗しました。こちらのメールアドレスへお問い合わせください。mtba9lear@gmail.com');
      </script>
  <?php
  }

}else if (isset($_POST['sent'])) {
  echo "<h3>空の項目があります。再度入力してください</h3>";
}
?>
<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center">お問い合わせ</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <form action="" method="post" id="contact_info">
          <table class="table">
            <tr>
              <th>あなたの名前:</th>
              <td>
                <div class="form-group">
                  <input type="text" name="name" class="form-control" placeholder="your name" required>
                </div>
              </td>
            </tr>
            <tr>
              <th>メールアドレス:</th>
              <td>
                <div class="form-group">
                  <input type="email" name="mail" class="form-control" placeholder="mail address" required>
                </div>
              </td>
            </tr>
            <tr>
              <th>内容:</th>
              <td>
                <div class="form-group">
                  <textarea rows="3" name="message" class="form-control" required></textarea>
                </div>
              </td>
            </tr>
          </table>
          <button type="submit" name="sent" value="送信" class="btn btn-primary btn-lg" form="contact_info">送信</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once(FOOTER); ?>
<!-- <form action="" method="post">
  <table>
    <tr>
      <th>あなたの名前:</th><td><input type="text" name="name" placeholder="your name" required></td>
    </tr>
    <tr>
      <th>メールアドレス:</th><td><input type="email" name="mail" placeholder="mail address" required></td>
    </tr>
    <tr>
      <th>お問い合わせ内容:</th><td><textarea rows="3" name="message" required></textarea></td>
    </tr>
  </table>

  <input type="submit" name="send" value="送信">

</form> -->
<!-- <form role="form" action="" method="post">
  <div class="form-group">
    <label for="exampleInputName1">Your Name</label>
    <input type="text" class="form-control" id="exampleInputName1" placeholder="Enter name" name="name" required>
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="email" required>
    <label for="exampleInputText1">Message</label>
    <textarea class="form-control" rows="3" name="message" required></textarea>
  </div>
  <button type="submit" name="sent" value="SEND MESSAGE" class="btn btn-default">Submit</button>
</form> -->
</body>
