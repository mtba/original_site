/**
 * 部屋に入ったときに自動で動作する初期化処理
 */

var room_id     = '<?php echo $room_id;?>';
var user_name   = '<?php echo $user_name;?>'; //ユーザーの名前
var user_id     = ''; //データストア上の自分のID
var th          = 0; //親は何人目か
var owner       = false; //オーナー権を持っているか否か
var join        = false; //参加しているか否か
var game_on     = <?php echo $result_search[0]['started'];?>; //ゲームスタートしているか否か
var rounds      = <?php echo $result_search[0]['rounds'];?>; //ラウンド数
var what_round  = 1; //何ラウンド目か
var password    = '<?php echo $password;?>'; //パスワードが存在するか否か
var parent      = false; //親か否か
var name_parent = ''; //親はだれか
var hint_num    = 1; //何番目のヒントか
var answer_time = false; //回答時間か否か
var all         = [];
var q_num       = 0;
// var point    = 0;
var timerID; //タイマー管理用

//MilkCocoa接続
//部屋のIDを基にデータストアを作成、または接続
var milkcocoa = new MilkCocoa("leadinzocv7h.mlkcca.com");
var ds = milkcocoa.dataStore(room_id);

$('#text').focus();

//まず全データ取得
ds.stream().next(function(err,datas){

  //部屋を立てた人の初期処理
  //オーナーとなり、ユーザー名をデータストアにプッシュ
  if (datas.length == 0) {

    ds.push({user: user_name},function(err,pushed){
      owner = true;
      $('#output').prepend('<p class="blue">部屋を作りました。</p>');
      $("#start").prop("disabled", true); //スタートボタン禁止
      user_id = pushed.id;
      join    = true;
      $('#join').hide();
    },function(err){
      //強制退出
      $.ajax({
        type: "POST",
        url: "ajax_DB.php",
        datatype: "json",
        data: {
          "mode": "delete",
          "id": room_id
        },
        success: function(res){
          ds.remove(user_id);
          window.location.href = '<?php echo TOP;?>';
        }
      });
    });

  }else { //二人目以降の入室者の初期処理
    $('#remark').hide();
    $('#people').text('');

    //参加者を全表示
    datas.forEach(function(datas) {
      var text = '<tr id="' + h(datas.id) + '"><td class=user_name>' + h(datas.value.user) + '</td><td class=point>0</td></tr>';
      $('#people').append(text); //表示
    });

    $('#start').hide();

    //ゲームが開始されているなら参加ボタンを押せない
    if (game_on == true) {
      $("#join").prop("disabled", true);
    }
  }

  //チャット欄にスクロールバー設置
  $('#output').slimScroll({
    height: '240px',
    // railVisible: true,
    // railColor: '#f00',
    // position: 'left',
    // distance: '200px'
  });

});
