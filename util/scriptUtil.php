<?php
/**
 * DB操作時のエラーをログファイルに追記する
 * @param type $mode 操作の種類 $result エラー文
 * @return type
 */
function err_log($mode,$result){
  $text = $mode.'に失敗。次記のエラーにより処理を中断:'.$result;
  $fp = fopen('../logs/log.txt','a');
  fwrite( $fp,$text.'　'.date('Y年n月j日 G時i分s秒')."\r\n" );
  fclose($fp);
}
?>
