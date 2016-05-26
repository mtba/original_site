
/**
 * 同じ部屋の人すべてに作用する処理
 */

//誰かがデータストアを操作した際に、すべてのユーザーの下でその操作に応じた関数が動作する
ds.on('send', signal); //信号を受け取ったとき
ds.on('push', enter); //参加者が増えたとき
ds.on('remove', exit); //減ったとき

//送られた信号のモードに応じて、各処理を実行する関数
function signal(sent){
  switch (sent.value.mode) {

    //発言
    case 'chat':
      $('#output').prepend('<p>' + sent.value.name + '：' + sent.value.remark + '</p>');
      break;

    //ヒント提示
    case 'hint':
      answer_time = true;
      $('#hints').append("<div class='hint'>ヒント"+hint_num+":"+sent.value.remark+"</div>");
      $('#output').prepend('<p class="green">回答時間です。</p>');
      clearTimeout(timerID);
      count(20);
      break;

    //正解
    case 'success':
      if (answer_time == true) {

        var plus = <?php echo(MAX_HINT*10); ?> - (hint_num-1) * 10;
        var $point_parent = $('#people tr').eq(th).children('.point');
        var $point_success = $('#'+sent.value.id+' .point');

        clearTimeout(timerID);
        answer_time = false;

        $('#output').prepend('<p>' + sent.value.name + '：' + sent.value.remark + '  <span class="red">←正解！</span></p>');
        $('#output').prepend('<p class="green">' + name_parent + 'さんに10点。' + sent.value.name + 'さんに' + plus + '点。5秒後に次のお題が出されます。</p>');

        $point_parent.text( parseInt($point_parent.text()) + 10 );
        $point_success.text( parseInt($point_success.text()) + plus );

        to_next();

      }
      break;

    //オーナー権譲渡
    case 'transfer':
      if (user_id == sent.value.next) {
        owner = true;
        $('#output').prepend('<p class="blue">' + $('#'+sent.value.next+' .user_name').text() + 'さんがオーナーになりました。</p>');
        $('#start').css('display','inline');
      }
      break;

    //ゲームスタート
    case 'start':
      game_on = true;
      all = sent.value.all;
      name_parent = $('#people tr').eq(th).children('.user_name').text();

      $('.point').text('0');
      $('#output').prepend('<p class="green">ゲームスタート。</p>');

      $("#join").prop("disabled", true);

      question();

      break;

    //ゲーム終了
    case 'finish':
      $('#output').prepend('<p class="green">ゲーム終了。優勝は○○さんです。</p>');
      th         = 0;
      game_on    = false;
      parent     = false;
      hint_num   = 1;
      all        = [];
      q_num      = 0;
      what_round = 1;
      $('.user_name').css('color', 'black');
      $('#word').text('(待機中)');
      $('#counter').text('0');
      $('.point').remove('0');
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
    $('#people').text('');

    //参加者を全表示
    datas.forEach(function(datas) {
      var text = '<tr id="'+datas.id+'"><td class=user_name>'+datas.value.user+'</td><td class=point>0</td></tr>';
      $('#people').append(text); //表示
    });

    $('#output').prepend('<p class="blue">' + pushed.value.user + 'さんが入室しました。</p>');
    cntrol_startBtn();

  });
}

//参加者が減るたびに呼ばれる関数
function exit(data){

  $('#output').prepend('<p class="blue">' + $('#'+data.id+' .user_name').text() + 'さんが退室しました</p>');
  $('#'+data.id).remove();
  cntrol_startBtn();

}

//一人ならスタートボタンを押せなくする
//二人以上なら解除
function cntrol_startBtn(){
  if (owner == true && game_on == false) {
    if ($('#people tr').size() > 1) {
      $("#start").prop("disabled", false);
    }else {
      $("#start").prop("disabled", true);
    }
  }
}

//出題
function question(){

  if (hint_num == 1) {

    $('#people tr').eq(th).css('color', '#e65a16');

    if (user_id == $('#people tr').eq(th).attr("id")) {
      parent = true;
      $('#word').text('お題：' + all[q_num]);
    }else {
      parent = false;
      $('#word').text('お題：');
      for (var i = 0; i < all[q_num].length; i++) {
        $('#word').append('○');
      }
    }

  }

  $('#output').prepend('<p class="green">'+name_parent+'さんは'+hint_num+'つ目のヒントを出してください。</p>');

  count(20);

}

//カウントダウン
function count(seconds){
  function show(){
    $('#counter').text(seconds);
    seconds = seconds - 1;
    timerID = setTimeout(function(){
      show();
    },1000);

    if (seconds==0) {

      $('#counter').text(seconds);
      clearTimeout(timerID);

      if (answer_time == true) {

        answer_time = false;
        $('#remark').prop("disabled", false);

        if (hint_num != <?php echo MAX_HINT;?>) {
          hint_num++;
          question();
        }else {
          $('#output').prepend('<p class="green">答えは「'+all[q_num]+'」でした。5秒後に次のお題が出されます。</p>');
          to_next();
        }

      }else {
        $('#output').prepend('<p class="green">時間切れです。答えは「'+all[q_num]+'」でした。5秒後に次のお題が出されます。</p>');
        to_next();
      }

    }
  }
  show();
}

//次の問題へ。またはゲーム終了へ
function to_next(){

  $('#word').text('答え：' + all[q_num]);

  //5秒待って処理を実行
  setTimeout(function(){
    $('#hints').text('');
    $('#remark').prop("disabled", false);

    if (rounds == what_round && th == $('#people tr').size()-1) {

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
              $('#output').prepend('<p class="purple">エラー発生。ゲームを終了できません。退室してください。</p>')
            }else {
              ds.send({mode: 'finish'});
            }
          }
        });
      }

    }else {
      if (th < $('#people tr').size()-1) {
        th++;
      }else {
        th = 0;
        what_round++;
        $('#output').prepend('<p class="grreen">ここから' + what_round + 'ラウンド目です。</p>');
      }
      q_num++;
      hint_num = 1;
      name_parent = $('#people tr').eq(th).children('.user_name').text();

      if (th >= 1) {
        $('#people tr').eq(th-1).css('color', 'black');
      }else {
        $('#people tr').eq($('#people tr').size() - 1).css('color', 'black');
      }

      question();

    }
  },5000);
}
