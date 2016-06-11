<?php

// 特殊文字を HTML エンティティに変換する関数
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * DB操作時のエラーをログファイルに追記する
 * @param type $mode 操作の種類 $result エラー文
 * @return type
 */
function err_log($mode,$result){
  $text = $mode.'に失敗。次記のエラーにより処理を中断:'.$result;
  $fp = fopen('logs/log.txt','a');
  fwrite( $fp,$text.'　'.date('Y年n月j日 G時i分s秒')."\r\n" );
  fclose($fp);
}

/**
 * 自動ＤＢ削除をログファイルに追記する
 * @param type $num 消したレコードの数
 * @return type
 */
function clean_log($num){
  $text = $num.'個の部屋を削除しました。';
  $fp = fopen('logs/clean.txt','a');
  fwrite( $fp,$text.'　'.date('Y年n月j日 G時i分s秒')."\r\n" );
  fclose($fp);
}

/**
 * 現在時をdatetime型で取得し返す
 * @param type
 * @return type datetime型の現在時
 */
function now(){
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');
    return $date;
}
?>
