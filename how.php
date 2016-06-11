<?php
require_once("util/defineUtil.php");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <title>how_to_play</title>
  <?php require_once(HEAD_COMMON); ?>
</head>
<body>

<?php require_once(HEADER); ?>

<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center">遊び方</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <p>①部屋を作る</p>
        <p>　トップページの「部屋を作る」ボタンから部屋作成ページに移動し、部屋を作成できます。トップページの部屋一覧からほかの人が作った部屋に入ることもできます</p>
        <p>②ゲームスタート</p>
        <p>　部屋を作った人はその部屋のオーナーとなり、ゲームスタートボタンを押してゲームを開始することができます。ゲーム開始するには2人以上が参加している必要があります。</p>
        <p>③ゲーム内容</p>
        <p>　ゲームが始まるとお題が表示されます。参加者の一人が親となり、お題は親にしか見えません。親となったプレイヤーはお題に関するヒントを出します。そのヒントを元にほかのプレイヤーはお題が何なのかを推理し、回答を入力します。正解者にはポイントが加点されます。制限時間内に正解者が出なければ、親はまた次のヒントを出します。早い段階で正解するほど高いポイントを得られます。最終的に最もポイントの高いプレイヤーが勝利となります。</p>
      </div>
    </div>


<?php require_once(FOOTER); ?>

</body>
