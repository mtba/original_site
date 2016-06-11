<?php
//DBへの接続を行う。成功ならPDOオブジェクトを、失敗なら中断、メッセージの表示を行う
function connect2MySQL(){
    try{
        //ユーザとパスを変更
        $pdo = new PDO( DB_TYPE.':host='.DB_HOST.';dbname='.DB_DBNAME.
            ';charset='.DB_CHARSET,DB_USER,DB_PWD );
        //SQL実行時のエラーをtry-catchで取得できるように設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        return $pdo;
    } catch (PDOException $e) {
        die('DB接続に失敗しました。次記のエラーにより処理を中断します:'.$e->getMessage());
    }
}

//レコードの挿入を行う。失敗した場合はエラー文を返却する
function insert($data,$tbl_name){

    //現在時をdatetime型で取得
    $date = now();

    //db接続を確立
    $insert_db = connect2MySQL();

    //DBにレコードを登録するSQL
    $insert_sql = "INSERT INTO $tbl_name(";
    foreach ($data as $key => $value) {
      $insert_sql .= $key.',';
    }
    $insert_sql .= "newDate) VALUES(";
    foreach ($data as $value) {
      $insert_sql .= '?,';
    }
    $insert_sql .= "?)";

    //クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);

    //SQL文にセッションから受け取った値＆現在時をバインド
    $i = 1;
    foreach ($data as $value) {
      $insert_query->bindValue($i,$value);
      $i++;
    }
    $insert_query->bindValue($i,$date);

    //SQLを実行
    try{
        $insert_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_db=null;
        return $e->getMessage();
    }
    $last_id = $insert_db->lastInsertId('id');
    $insert_db=null;
    return (int)$last_id;
}

function search_rooms($id = null){
    //db接続を確立
    $search_db = connect2MySQL();

    $search_sql = "SELECT * FROM ".DB_TBL_ROOM;
    if (!empty($id)) {
      $search_sql .= " WHERE id = :id";
    }

    //クエリとして用意
    $seatch_query = $search_db->prepare($search_sql);
    if(!empty($id)){
        $seatch_query->bindValue(':id',$id);
    }

    //SQLを実行
    try{
        $seatch_query->execute();
    } catch (PDOException $e) {
        $seatch_db=null;
        return $e->getMessage();
    }
    $seatch_db=null;
    //該当するレコードを連想配列として返却
    return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}

function search_words($genre,$num){
    //db接続を確立
    $search_db = connect2MySQL();

    $search_sql = "SELECT name FROM $genre WHERE id = $num";

    //クエリとして用意
    $seatch_query = $search_db->query($search_sql);

    //SQLを実行
    try{
        $seatch_query->execute();
    } catch (PDOException $e) {
        $seatch_db=null;
        return $e->getMessage();
    }
    $seatch_db=null;
    //該当するレコードを連想配列として返却
    return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}

function delete_room($id){
    //db接続を確立
    $delete_db = connect2MySQL();

    $delete_sql = "DELETE FROM ".DB_TBL_ROOM." WHERE id =:id";

    //クエリとして用意
    $delete_query = $delete_db->prepare($delete_sql);

    $delete_query->bindValue(':id',$id);

    //SQLを実行
    try{
        $delete_query->execute();
    } catch (PDOException $e) {
        $delete_db=null;
        return $e->getMessage();
    }
    $delete_db=null;
    return null;
}



function game_switch($id,$value){
    //db接続を確立
    $update_db = connect2MySQL();

    //SQL文作成
    $update_sql = "UPDATE ".DB_TBL_ROOM." SET started = ".$value." WHERE id = :id";

    //クエリとして用意
    $update_query = $update_db->prepare($update_sql);

    $update_query -> bindValue(':id',$id);

    //SQLを実行
    try{
        $update_query->execute();
    } catch (PDOException $e) {
        $update_db=null;
        return $e->getMessage();
    }
    $update_db=null;
    return $update_query->rowCount();
}

function reload_date($id){
    //db接続を確立
    $update_db = connect2MySQL();

    //現在時をdatetime型で取得
    $date = now();

    //SQL文作成
    $update_sql = "UPDATE ".DB_TBL_ROOM." SET newDate = '$date' WHERE id =$id";

    //クエリとして用意
    $update_query = $update_db->prepare($update_sql);

    // $update_query -> bindValue(1,$date);
    // $update_query -> bindValue(1,$id);

    //SQLを実行
    try{
        $update_query->execute();
    } catch (PDOException $e) {
        $update_db=null;
        return $e->getMessage();
    }
    $update_db=null;
    return $update_query->rowCount();
}

function clean(){
    //db接続を確立
    $delete_db = connect2MySQL();

    $delete_sql = "DELETE from ".DB_TBL_ROOM." WHERE TIMESTAMPDIFF(second,newDate,now()) > 43200";

    $delete_query = $delete_db->prepare($delete_sql);

    //SQLを実行
    try{
        $delete_query->execute();
    } catch (PDOException $e) {
        $delete_db=null;
        return $e->getMessage();
    }
    $delete_db=null;
    return $delete_query->rowCount();
}
