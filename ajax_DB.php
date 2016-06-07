<?php
header('Content-Type: application/json; charset=utf-8');

require_once("util/defineUtil.php");
require_once(DBACCESS);
require_once(SCRIPT);

$id     = isset($_POST['id']) ? $_POST['id']         : '';
$mode   = isset($_POST['mode']) ? $_POST['mode']     : '';
$on_off = isset($_POST['on_off']) ? $_POST['on_off'] : '';
$pass   = isset($_POST['pass']) ? $_POST['pass']     : '';
// $genre  = isset($_POST['genre']) ? $_POST['genre']   : '';
$num  = isset($_POST['num']) ? $_POST['num']   : '';
$questions  = isset($_POST['questions']) ? $_POST['questions']   : '';
$data   = array();

//送られたモードに応じてＤＢ操作
switch ($mode) {
  case 'delete':

    $result_delete = delete_room($id);

    if(!isset($result_delete)){ //エラーが発生しなければ
      $data['success'] = true;
    }else{
      err_log($mode,$result_delete);
      $data['success'] = false;
    }
    break;

  case 'game_switch':

    $result_update = game_switch($id,$on_off);

    if($result_update == 1){ //エラーが発生しなければ
      $data['success'] = true;
    }else{
      err_log($mode,$result_update);
      $data['success'] = false;
    }
    break;

  case 'check':

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

    if (strpos($questions,'_') !== false) {

      $array_q = explode("_",$questions);

    }else {

      $array_q[] = $questions;

    }

    for ($i=0; $i < $num; $i++) {

      $rand_q = mt_rand(0, count($array_q)-1);

      if ($array_q[$rand_q] == 'fruits'){

        $result_search = search_words('wp_5hunifruits',mt_rand(1, 39));

      }elseif ($array_q[$rand_q] == 'peopleJhistory') {

        $result_search = search_words('wp_5hunipeopleJhistory',mt_rand(1, 72));

      }
      if( ! is_array($result_search) ){
        err_log('get_word',$result_search);
        $data['success'] = false;
        break;
      }else {
        $data['success'] = true;
        $data['name'][] = $result_search[0]['name'];
      }

    }

    break;

  default:
    # code...
    break;
}
echo json_encode($data);

?>
