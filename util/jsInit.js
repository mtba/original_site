
var room_id     = '<?php echo $room_id;?>';
var user_name   = '<?php echo $user_name;?>'; //ユーザーの名前
var user_id     = '' //データストア上の自分のID
// var people   = []; //それぞれのユーザーのIDを入れる配列
var th          = 0; //親は何人目か
var owner       = false; //オーナー権を持っているか否か
var join        = false; //参加しているか否か
var game_on     = <?php echo $result_search[0]['started'];?>; //ゲームスタートしているか否か
var rounds      = <?php echo $result_search[0]['rounds'];?>; //ラウンド数
var parent      = false; //親か否か
// var word        = ''; //お題
var hint_num    = 0; //何番目のヒントか
var answer_time = false; //回答時間か否か
var all         = [];
var q_num       = 0;

//MilkCocoa接続
//部屋のIDを基にデータストアを作成、または接続
var milkcocoa = new MilkCocoa("leadinzocv7h.mlkcca.com");
var ds = milkcocoa.dataStore(room_id);

//まず全データ取得
ds.stream().next(function(err,datas){

  //部屋を立てた人の初期処理
  //オーナーとなり、ユーザー名をデータストアにプッシュ
  if (datas.length == 0) {

    owner = true;
    $("#start").prop("disabled", true); //スタートボタン禁止

    ds.push({user: user_name},function(err,pushed){
      user_id = pushed.id;
      join    = true;
      $('#join').hide();
    },function(err){
      $('#err').append('<p>参加できませんでした。errar内容:' + data.value.user + '</p>');
    });

  }else { //二人目以降の入室者の初期処理
    $('#remark').hide();
    $('#people ul li').remove();

    datas.forEach(function(data) {
      $('#people ul').append('<li>' + data.value.user + '</li>');
    });

    $('#start').hide();

    //ゲームが開始されているなら参加ボタンを押せない
    if (game_on == true) {
      $("#join").prop("disabled", true);
    }
  }
});
