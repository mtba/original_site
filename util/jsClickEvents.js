
/**
 * 自動では発動しないイベント系
 */

//参加ボタンが押されたとき
$join.click(function(){
  join_func();
});
function join_func(){
  if ($text.val() != '') {
    if (password) {

      myPassWord=prompt("パスワードを入力してください","");
      $.ajax({
        type: "POST",
        url: "ajax_DB.php",
        datatype: "json",
        data: {
          "mode": "check",
          "id": room_id,
          "pass": myPassWord
        },
        success: function(res){
          if (!res.success) {
            alert( "エラー発生。ゲームに参加できません。退室してください。" );
            return 0;
          }else {
            if (res.match) {
              push();
              return 0;
            }
          }
          alert( "パスワードが違います。" );
        }
      });
      return 0;
    }
    push();
  }
}
function push(){
  ds.push({user: $text.val()},function(err,pushed){
    user_id   = pushed.id;
    user_name = $text.val();
    join      = true;
    $text.val('');
    $join.hide();
    $remark.css('display','inline');
  },function(err){
    $output.prepend('<p class="purple">参加できませんでした。</p>');
  });
  $text.focus();
}

//発言ボタンが押されたとき
$remark.click(function(){
  submit();
});
function submit(){
  if ( $text.val() != '' ) {

    var text = $text.val();

    if (parent == true) {
      ds.send({mode: 'hint',remark: text});
      $remark.prop("disabled", true);
    }else if (answer_time==true && text==all[q_num]) {
      ds.send({mode: 'success', name: user_name, remark: text, id: user_id});
    }else {
      ds.send({mode: 'chat',name: user_name,remark: text});
    }
    $text.val('');
  }
  $text.focus();
}

//入力欄をフォーカスしてエンターキー押したとき
$text.keypress(function(e){
  if (e.which == 13) {
    if ($join.css("display")!='none' && $join.prop("disabled")==false) {
      join_func();
    }else if ($remark.css("display")!='none' && $remark.prop("disabled")==false) {
      submit();
    }
    return false;
  }
});

//ゲーム開始ボタンが押されたとき
$start.click(function(){

  $start.prop("disabled", true);
  $output.prepend('<p class="purple">問題をロード中。しばらく時間がかかります。<p>');

  $.ajax({
    type: "POST",
    url: "ajax_DB.php",
    datatype: "json",
    data: {
      "mode": "game_switch",
      "id": room_id,
      "on_off": true
    },
    success: function(res){
      if (res.success == false) {
        $output.prepend('<p class="purple">エラー発生。ゲームを開始できません。一度退室してください<p>');
      }else {

        var all_questions =[];

          $.ajax({
            async: false,
            type: "post",
            dataType: "json",
            url: "ajax_DB.php",
            data: {
              "mode": "get_words",
              "num": $('.user_track').size() * rounds,
              "id": room_id,
              "questions": str_q
            },
            success: function(word) {
              if (word.success == false) {
                $output.prepend('<p class="purple">エラー発生。ゲームを開始できません。一度退室してください<p>');
              }else {
                all_questions = word.name;
                ds.send({mode: 'start',all: all_questions});
              }
            }
          });

      }
    }
  });
  $text.focus();
});

//退室ボタンが押されたとき
$exit.click(function(){
  window.location.href = '<?php echo TOP;?>';
});

//ページを離れるとき
// $(window).on("beforeunload", function() {
//   pageout();
// });
window.onpagehide = function() {
  pageout();
};



function pageout(){

  if (join == true) {

    if ($('.user_track').size() > 1) {
      if (owner == true) {
        var next_id = '';
        if ($("#"+user_id).index() == $('.user_track').size()-1) {
          next_id = $('.user_track').eq(0).attr("id");
        }else {
          next_id = $("#"+user_id).next().attr("id");
        }
        ds.send({mode: 'transfer',next: next_id});
      }
      ds.remove(user_id);
    }else {

      $.ajax({
        type: "POST",
        url: "ajax_DB.php",
        datatype: "json",
        async: false,
        data: {
          "mode": "delete",
          "id": room_id
        },
        success: function(res){
          ds.remove(user_id);
        }
      });

    }
  }
}
