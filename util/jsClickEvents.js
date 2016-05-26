
/**
 * 自動では発動しないイベント系
 */

//参加ボタンが押されたときの処理(空なら何も起きない)
$('#join').click(function(){
  if ($('#text').val() != '') {
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
            alert( "エラー発生。ゲームに参加できません。" );
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
});
function push(){
  ds.push({user: $('#text').val()},function(err,pushed){
    user_id   = pushed.id;
    user_name = $('#text').val(); //ユーザー名は変数にも格納
    join      = true;
    $('#text').val('');
    $('#join').hide();
    $('#remark').css('display','inline');
  },function(err){
    $('#output').prepend('<p class="purple">参加できませんでした。</p>');
  });
}

//発言ボタンが押されたとき
$('#remark').click(function(){
  if ($('#text').val() != '') {

    var text = $('#text').val();

    //親でなければチャット欄、親であればヒント欄に発言
    //回答時間中にお題と発言が一致すれば正解処理
    if (parent == true) {
      ds.send({mode: 'hint',remark: text});
      $('#remark').prop("disabled", true);
    }else if (answer_time==true && text==all[q_num]) {
      ds.send({mode: 'success', name: user_name, remark: text, id: user_id});
    }else {
      ds.send({mode: 'chat',name: user_name,remark: text});
    }
    $('#text').val('');
  }
});

//退室ボタンが押されたとき
$('#exit').click(function(){
  //参加者であれば、自分の情報をデータストアから削除し、チャット欄に退室と表示
  if (join == true) {

    if ($('#people tr').size() > 1) { //入室者が二人以上の時
      //オーナーならばオーナー権を一つ下の人に譲渡
      if (owner == true) {
        var next_id = $("#"+user_id).next().attr("id");
        ds.send({mode: 'transfer',next: next_id});
      }
      ds.remove(user_id);
      window.location.href = '<?php echo TOP;?>';
    }else { //入室者が自分一人ならば、部屋をDBから削除
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
    }

  }else { //不参加者はただ出る
    window.location.href = '<?php echo TOP;?>';
  }
});

//ゲーム開始ボタンが押されたとき
$('#start').click(function(){

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
        $('#output').prepend('<p class="purple">エラー発生。ゲームを開始できません。<p>')
      }else {
        $("#start").prop("disabled", true);

        //全問題をここで取得してしまう
        var words = ['なし','りんご','おれんじ','ますかっと','ぱいなっぷる'];
        var all_questions =[];
        for (var i = 0; i < $('#people tr').size() * rounds; i++) {
          var rand = Math.floor( Math.random() * words.length ) ;
          all_questions.push(words[rand]);
        }

        ds.send({mode: 'start',all: all_questions});
      }
    }
  });
});

// //実験用
// $('#exam').click(function(){
//   console.log($('#people tr').size());
//
//   ds.stream().next(function(err,datas){
//     console.log(datas);
//     console.log($('#people ul li').size());
//   });
//   if (user_id == people[th]) {
//     $('#people ul li').eq(0).css('color', 'red');
//   }
// });
