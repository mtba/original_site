
//誰かがデータストアを操作した際に、すべてのユーザーの下でその操作に応じた関数が動作する
ds.on('send', signal); //信号を受け取ったとき
ds.on('push', enter); //参加者が増えたとき
ds.on('remove', exit); //減ったとき

//送られた信号のモードに応じて、各処理を実行する関数
function signal(sent){
  switch (sent.value.mode) {

    //発言
    case 'chat':
      $('#output').append(sent.value.name + '：' + sent.value.remark + '<br>');
      break;

    //ヒント提示
    case 'hint':
      answer_time = true;
      $('.hint').eq(hint_num).text(sent.value.remark);
      break;

    //正解
    case 'success':
      if (answer_time == true) {
        answer_time = false;
        $('#output').append(sent.value.name + '：' + sent.value.remark + '  <span class="red">←正解！</span><br>');
        $('#word h1').text(word);

        var $point = $('#'+sent.value.id+' .point');
        $point.text( parseInt($point.text()) + 10 );

        //3秒待って処理を実行
        setTimeout(function(){
          $('.hint').text('');
          $('#remark').prop("disabled", false);

          if (q_num == all.length-1) {

            if (owner == true) {
              $.ajax({
                type: "POST",
                url: "ajax_DB.php",
                datatype: "json",
                data: {
                  "mode": "game_switch",
                  "id": room_id,
                  "on_off": false
                },
                success: function(res){
                  if (res.success == false) {
                    $('#err').text('エラー発生。ゲームを終了できません')
                  }else {
                    ds.send({mode: 'finish'});
                  }
                }
              });
            }

          }else {
            if (th < $('#people ul li').size()-1) {
              th++;
            }else {
              th = 0;
            }
            q_num++;

            if (th >= 1) {
              $('#people ul li').eq(th-1).css('color', 'black');
            }else {
              $('#people ul li').eq($('#people ul li').size() - 1).css('color', 'black');
            }

            question();

          }
        },3000);
      }

    //オーナー権譲渡
    case 'transfer':
      if (user_id == sent.value.next) {
        owner = true;
        $('#output').append('<p class="green">' + $('#'+sent.value.next+' .user_name').text() + 'さんがオーナーになりました</p>');
        $('#start').css('display','inline');
      }
      break;

    //ゲームスタート
    case 'start':
      game_on = true;
      all = sent.value.all;

      $("#join").prop("disabled", true);
      $('#people ul li').append('<span class=point>0</span>');

      question();

      break;

    //ゲーム終了
    case 'finish':
      th       = 0;
      game_on  = false;
      parent   = false;
      hint_num = 0;
      all      = [];
      q_num    = 0;
      $('#people ul li').css('color', 'black');
      $('#message h2').text('');
      $('#word h1').text('');
      $('.point').remove();
      $("#start").prop("disabled", false);
      $("#join").prop("disabled", false);

      break;

    default:
      break;
  }
}

//参加者が増えるたびに呼ばれる関数
function enter(pushed){

  ds.stream().next(function(err,datas){

    //まず全消去
    $('#people ul li').remove();
    // people = [];

    //参加者を全表示
    datas.forEach(function(datas) {
      $('#people ul').append('<li id="'+datas.id+'"><span class=user_name>'+datas.value.user+'</span></li>'); //表示
      // people.push(datas.id); //参加中のユーザーのIDを配列に格納しておく
    });

    $('#output').append('<p class="blue">' + pushed.value.user + 'さんが入室しました</p>');
    cntrol_startBtn();

  });
}

//参加者が減るたびに呼ばれる関数
function exit(data){

  $('#output').append('<p class="blue">' + $('#'+data.id+' .user_name').text() + 'さんが退室しました</p>');
  $('#'+data.id).remove();
  cntrol_startBtn();

}

//一人ならスタートボタンを押せなくする
//二人以上なら解除
function cntrol_startBtn(){
  if (owner == true && game_on == false) {
    if ($('#people ul li').size() > 1) {
      $("#start").prop("disabled", false);
    }else {
      $("#start").prop("disabled", true);
    }
  }
}

//出題
function question(){

  $('#people ul li').eq(th).css('color', '#e65a16');

  if (user_id == $('#people ul li').eq(th).attr("id")) {
    parent = true;
    $('#word h1').text(all[q_num]);
    $('#message h2').text('あなたが親です。ヒントを出してください');
  }else {
    parent = false;
    $('#message h2').text('');
    $('#word h1').text('');
    for (var i = 0; i < all[q_num].length; i++) {
      $('#word h1').append('○');
    }
  }

}
