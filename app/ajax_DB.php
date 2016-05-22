<?php
header('Content-Type: application/json; charset=utf-8');

require_once("../util/defineUtil.php");
require_once(DBACCESS);
require_once(SCRIPT);

$id   = isset($_POST['id']) ? $_POST['id']     : '';
$mode = isset($_POST['mode']) ? $_POST['mode'] : '';
$on_off = isset($_POST['on_off']) ? $_POST['on_off'] : '';
$data = array();

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

    if(!isset($result_update)){ //エラーが発生しなければ
      $data['success'] = true;
    }else{
      err_log($mode,$result_update);
      $data['success'] = false;
    }
    break;

  default:
    # code...
    break;
}
echo json_encode($data);


?>