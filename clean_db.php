<?php
/**
 * cronで毎日0時と12時に実行されるファイル
 */

require_once("util/defineUtil.php");
require_once(DBACCESS);
require_once(SCRIPT);

$result_clean = clean();

if(is_numeric($result_clean)){ //エラーが発生しなければ
  clean_log($result_clean);
}else{
  err_log("clean",$result_delete);
}

?>
