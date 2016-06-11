<?php
require_once("util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

$field_name    = isset($_POST['name']) ? $_POST['name']       : '';
$field_email   = isset($_POST['mail']) ? $_POST['mail']     : '';
$field_message = isset($_POST['message']) ? $_POST['message'] : '';

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>contact_page</title>
  <?php require_once(HEAD_COMMON); ?>
</head>
<body>

<?php require_once(HEADER);

if ( !empty($field_name) && !empty($field_email) && !empty($field_message) ) {

  $mail_to = CONTACT_TO;
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
      $field_name    = '';
      $field_email   = '';
      $field_message = '';
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
                  <input type="text" name="name" class="form-control" placeholder="your name" value="<?php echo h($field_name);?>" required>
                </div>
              </td>
            </tr>
            <tr>
              <th>メールアドレス:</th>
              <td>
                <div class="form-group">
                  <input type="email" name="mail" class="form-control" placeholder="mail address" value="<?php echo h($field_email);?>" required>
                </div>
              </td>
            </tr>
            <tr>
              <th>内容:</th>
              <td>
                <div class="form-group">
                  <textarea rows="3" name="message" class="form-control" required><?php echo h($field_message);?></textarea>
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

</body>
