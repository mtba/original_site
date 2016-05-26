<?php
const TOP     = 'index.php'; //トップページ
const MK_ROOM = 'mk_room.php'; //部屋作成ページ
const ROOM    = 'room.php'; //ゲームページ
const HOW     = 'how.php'; //遊び方説明ページ
const CONTACT = 'contact.php'; //お問合せページ
const AJAX_DB = 'ajax_DB.php'; //JSからのDB操作用

const SCRIPT      = "../util/scriptUtil.php"; //
const DBACCESS    = "../util/dbUtil.php"; //
const JS_INIT     = '../util/jsInit.js'; //
const JS_CLICK    = '../util/jsClickEvents.js'; //
const JS_FUNCTION = '../util/jsfunctions.js'; //
const CSS_COMMON  = '../util/common.css'; //CSS

const DB_TYPE     = 'mysql';            //データベースの種類
const DB_HOST     = 'localhost';        //ホスト名
const DB_DBNAME   = 'pg_db';      //データベース名
const DB_CHARSET  = 'utf8';             //文字コード
const DB_USER     = 'root';             //ユーザ
const DB_PWD      = '';                 //パスワード
const DB_TBL_ROOM = 'rooms';           //テーブル名

const MAX_HINT = 5; //ヒント数上限
// const MAX_CHAT = 10; //表示発言数上限
