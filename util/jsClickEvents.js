
//参加ボタンが押されたときの処理(空なら何も起きない)
$('#join').click(function(){
  if ($('#text').val() != '') {
    ds.push({user: $('#text').val()},function(err,pushed){
      user_id   = pushed.id;
      user_name = $('#text').val(); //ユーザー名は変数にも格納
      join      = true;
      $('#text').val('');
      $('#join').hide();
      $('#remark').css('display','inline');
    },function(err){
      $('#err').append('<p>参加できませんでした。errar内容:' + data.value.user + '</p>');
    });
  }
});

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

    if ($('#people ul li').size() > 1) { //入室者が二人以上の時
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
        $('#err').text('エラー発生。ゲームを開始できません')
      }else {
        $("#start").prop("disabled", true);

        //全問題をここで取得してしまう
        var words = ['りんご','おれんじ','ますかっと'];
        var all_questions =[];
        for (var i = 0; i < $('#people ul li').size() * rounds; i++) {
          var rand = Math.floor( Math.random() * 3 ) ;
          all_questions.push(words[rand]);
        }

        ds.send({mode: 'start',all: all_questions});
      }
    }
  });
});

//実験用
$('#exam').click(function(){
  console.log($('#people ul li').size());

  // ds.stream().next(function(err,datas){
  //   console.log(datas);
  //   console.log($('#people ul li').size());
  // });
  // if (user_id == people[th]) {
  //   $('#people ul li').eq(0).css('color', 'red');
  // }
});
