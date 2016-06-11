<?php
const TOP     = 'index.php'; //トップページ
const MK_ROOM = 'mk_room.php'; //部屋作成ページ
const ROOM    = 'room.php'; //ゲームページ
const HOW     = 'how.php'; //遊び方説明ページ
const CONTACT = 'contact.php'; //お問合せページ
const AJAX_DB = 'ajax_DB.php'; //JSからのDB操作用

const SCRIPT      = "util/scriptUtil.php"; //ＰＨＰ関数
const DBACCESS    = "util/dbUtil.php"; //ＤＢ操作関連
const HEAD_COMMON = "util/head.php"; //ファイル読み込み
const HEADER      = 'util/header.php'; //ヘッダー
const FOOTER      = 'util/footer.php'; //フッター
const JS_INIT     = 'util/jsInit.js'; //初期化
const JS_CLICK    = 'util/jsClickEvents.js'; //イベント
const JS_FUNCTION = 'util/jsFunctions.js'; //関数

const JS_SCROLL = 'js/jquery.slimscroll.min.js'; //スリムスクロール
const JS_BS     = 'js/bootstrap.min.js'; //ブートストラップJS
const JS_JQUERY = '//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'; //jQuery
const JS_MLKCCA = 'https://cdn.mlkcca.com/v2.0.0/milkcocoa.js'; //ミルクココア

const CSS_COMMON   = 'css/common.css'; //自作CSS
const CSS_ICON     = 'css/font-awesome.min.css'; //アイコン
const CSS_PINGENDO = 'http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css'; //ブートストラップCSS

const DB_TYPE     = 'mysql'; //データベースの種類
const DB_HOST     = 'xxx'; //ホスト名
const DB_DBNAME   = 'xxx'; //データベース名
const DB_CHARSET  = 'utf8'; //文字コード
const DB_USER     = 'xxx'; //ユーザ
const DB_PWD      = 'xxx'; //パスワード
const DB_TBL_ROOM = 'xxx'; //テーブル名
const DB_TBL_FRUITS = 'xxx'; //テーブル名
const DB_TBL_PEOPLE = 'xxx'; //テーブル名

const PASS_MLKCCA = 'xxx.mlkcca.com'; //milkcocoa接続用

const CONTACT_TO = 'xxx'; //問合せ先

const MAX_HINT       = 4; //ヒント数上限
const HINT_COUNTER   = 25; //ヒント時間
const ANSWER_COUNTER = 25; //回答時間
