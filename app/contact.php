<?php
require_once("../util/defineUtil.php");
require_once(SCRIPT);
require_once(DBACCESS);

$field_name    = isset($_POST['name']) ? $_POST['name']       : '';
$field_email   = isset($_POST['email']) ? $_POST['email']     : '';
$field_message = isset($_POST['message']) ? $_POST['message'] : '';
$mail_to = 'mtba9lear@gmail.com';
$subject = 'Message from a site visitor '.$field_name;
$body_message  = 'From: '.$field_name."\n";
$body_message .= 'E-mail: '.$field_email."\n";
$body_message .= 'Message: '.$field_message;
$headers  = 'From: '.$field_email."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";
$mail_status = mail($mail_to, $subject, $body_message, $headers);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>contact</title>
  <meta name="keywords" content="">
  <meta name="description" content="オリジナルサイト作成">
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href=<?php echo CSS_COMMON;?>>
</head>
<body>
<?php
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
        window.location = 'index.php';
    </script>
<?php
}
?>

<form role="form" action="" method="post">
  <div class="form-group">
    <label for="exampleInputName1">Your Name</label>
    <input type="text" class="form-control" id="exampleInputName1" placeholder="Enter name" name="name" required>
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="email" required>
    <label for="exampleInputText1">Message</label>
    <textarea class="form-control" rows="3" name="message" required></textarea>
  </div>
  <button type="submit" value="SEND MESSAGE" class="btn btn-default">Submit</button>
</form>
</body>
