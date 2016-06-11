<?php
header('Content-Type: application/json; charset=utf-8');

require_once("util/defineUtil.php");
require_once(DBACCESS);
require_once(SCRIPT);

$id     = isset($_POST['id']) ? $_POST['id']         : '';
$mode   = isset($_POST['mode']) ? $_POST['mode']     : '';
$on_off = isset($_POST['on_off']) ? $_POST['on_off'] : '';
$pass   = isset($_POST['pass']) ? $_POST['pass']     : '';
$num  = isset($_POST['num']) ? $_POST['num']   : '';
$questions  = isset($_POST['questions']) ? $_POST['questions']   : '';
$data   = array();

//送られたモードに応じてＤＢ操作
switch ($mode) {
  case 'delete':

    //部屋を削除
    $result_delete = delete_room($id);

    if(!isset($result_delete)){ //エラーが発生しなければ
      $data['success'] = true;
    }else{
      err_log($mode,$result_delete);
      $data['success'] = false;
    }
    break;

  case 'game_switch':

    //ゲーム中か否かをＤＢに記録
    $result_update = game_switch($id,$on_off);

    if($result_update == 1){ //エラーが発生しなければ
      $data['success'] = true;
    }else{
      err_log($mode,$result_update);
      $data['success'] = false;
    }
    break;

  case 'check':

    //部屋が存在するかをチェック
    $result_search = search_rooms($id);
    if( ! is_array($result_search) ){
      err_log('search',$result_search);
      $data['success'] = false;
    }else {
      $data['success'] = true;
      if ($pass == $result_search[0]['password']) {
        $data['match'] = true;
      }else {
        $data['match'] = false;
      }
    }
    break;

  case 'get_words':

    $update_success = false; //更新に成功したかどうか
    $search_success = false; //お題の取得に成功したかどうか

    //アクセス日時を更新
    $result_update = reload_date($id);

    if($result_update == 1){ //エラーが発生しなければ
      $update_success = true;
    }else{
      err_log("reload_time",$result_update);
    }


    //部屋を作る際に選択したお題のジャンルをそれぞれ配列に格納
    if (strpos($questions,'_') !== false) {
      $array_q = explode("_",$questions);

    }else {
      $array_q[] = $questions;
    }

    //お題をランダムで取得
    for ($i=0; $i < $num; $i++) {

      $rand_q = mt_rand(0, count($array_q)-1);

      if ($array_q[$rand_q] == 'fruits'){
        $result_search = search_words(DB_TBL_FRUITS,mt_rand(1, 39));

      }elseif ($array_q[$rand_q] == 'peopleJhistory') {
        $result_search = search_words(DB_TBL_PEOPLE,mt_rand(1, 72));
      }

      if( ! is_array($result_search) ){ //エラーが発生したら
        err_log('get_word',$result_search);
        $search_success = false;
        break;
      }else {
        $search_success = true;
        $data['name'][] = $result_search[0]['name'];
      }

    }

    if ($update_success && $search_success) {
      $data['success'] = true;
    }else {
      $data['success'] = false;
    }
    break;

  default:
    # code...
    break;
}
echo json_encode($data);

?>
