/**
 * 部屋に入ったときに自動で動作する初期化処理
 */

var room_id     = '<?php echo $room_id;?>';
var user_name   = '<?php echo $user_name;?>';
var user_id     = '';
var th          = 0; //親は何人目か
var owner       = false;
var join        = false;
var game_on     = <?php echo $result_search[0]['started'];?>;
var rounds      = <?php echo $result_search[0]['rounds'];?>;
var what_round  = 1;
var password    = '<?php echo $password;?>'; //パスワードが存在するか否か
var parent      = false;
var name_parent = '';
var hint_num    = 1;
var answer_time = false; //回答時間か否か
var all         = []; //全問題
var q_num       = 0;
var timerID; //タイマー管理用
var str_q = "<?php echo $result_search[0]['questions'];?>";
// var array_q = [];
// if ( array_s.match(/_/)) {
//   array_q = array_s.split("_");
// }else {
//   array_q.push(array_s);
// }

var $start  = $('#start');
var $join   = $('#join');
var $remark = $('#remark');
var $exit   = $('#exit');

var $text    = $('#text');
var $output  = $('#output');
var $people  = $('#people');
var $word    = $('#word');
var $hints   = $('#hints');
var $counter = $('#counter');

var milkcocoa = new MilkCocoa("<?php echo PASS_MLKCCA;?>");
var ds = milkcocoa.dataStore(room_id);

$text.focus();

ds.stream().next(function(err,datas){

  if (datas.length == 0) {

    ds.push({user: user_name},function(err,pushed){
      owner = true;
      $output.prepend('<p class="blue">部屋を作りました。</p>');
      $start.prop("disabled", true);
      user_id = pushed.id;
      join    = true;
      $join.hide();
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
          window.location.href = '<?php echo TOP;?>';
        }
      });
    });

  }else {
    $remark.hide();
    $people.text('');

    //参加者を全表示
    datas.forEach(function(datas) {
      var text = '<tr class="user_track" id="' + h(datas.id) + '"><td class="user_name">' + h(datas.value.user) + '</td><td class="point text-center">0</td></tr>';
      $people.append(text);
    });

    $start.hide();

    if (game_on == true) {
      $join.prop("disabled", true);
    }
  }

  $output.slimScroll({
    height: '280px',
    // railVisible: true,
    // railColor: '#f00',
    // position: 'left',
    // distance: '200px'
  });

});
