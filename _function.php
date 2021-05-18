<?php
// ==============================
// DB接続
// ==============================
function dbConnect(){
  // 以下3行は自分の環境に合わせて変更してください
  $dsn = 'mysql:dbname=resv_boat;host=localhost;charset=utf8';
  $user = 'root'; // DBのユーザー名、初期設定では'root'
  $password = 'root'; // DBのパスワード、初期設定では''(windows) / 'root'(mac)

  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
  );
  // PDOオブジェクト生成（DBへ接続）
  $dbh = new PDO($dsn, $user, $password, $options);
  return $dbh;
}

// ==============================
// SQL実行関数
// ==============================
function queryPost($dbh, $sql, $data){
  // クエリ作成
  $stmt = $dbh->prepare($sql);

  // クエリ失敗
  if(!$stmt->execute($data)){
    return 0;
  }

  // クエリ成功
  return $stmt;
}

// ==============================
// 日にち毎の予約データをすべて取得
// ==============================
function getResv(){
  // 例外処理
  try {
    // DB接続
    $dbh = dbConnect();

    // クエリ実行
    $sql = 'SELECT date, sum(guest_pax), sum(staff_pax) FROM reservation GROUP BY date ORDER BY date';
    $data = array();
    $stmt = queryPost($dbh, $sql, $data);

    // クエリ結果のデータをすべて取得
    if($stmt){
      $result['data'] = $stmt->fetchAll();
      return $result;
    } else {
      return false;
    }
  } catch (Exception $e) {
    // error_log('エラー発生: ' . $e->getMessage());
  }
}

// ==============================
// 日にちのデータを1件取得
// ==============================
function getDaily($date){
  // 例外処理
  try {
    // DB接続
    $dbh = dbConnect();

    // クエリ実行
    $sql = 'SELECT menu_id, captain FROM daily WHERE date = :date';
    $data = array(':date' => $date);
    $stmt = queryPost($dbh, $sql, $data);

    // クエリ結果のデータをすべて取得
    if($stmt){
      return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return false;
    }
  } catch (Exception $e) {
    // error_log('エラー発生: ' . $e->getMessage());
  }
}

// ==============================
// メニューのデータを1件取得
// ==============================
function getMenu($id){
  // 例外処理
  try {
    // DB接続
    $dbh = dbConnect();

    // クエリ実行
    $sql = 'SELECT max_pax, menu_name FROM menu WHERE id = :id ';
    $data = array(':id' => $id);
    $stmt = queryPost($dbh, $sql, $data);

    // クエリ結果のデータを1件取得
    if($stmt){
      return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return false;
    }
  } catch (Exception $e) {
    // error_log('エラー発生: ' . $e->getMessage());
  }
}

// ==============================
// 1日の予約合計人数を取得
// ==============================
function getPax($date){
  // 例外処理
  try {
    // DB接続
    $dbh = dbConnect();

    // クエリ実行
    $sql = 'SELECT date, sum(guest_pax), sum(staff_pax) FROM reservation GROUP BY date HAVING date = :date';
    $data = array(':date' => $date);
    $stmt = queryPost($dbh, $sql, $data);

    // クエリ結果のデータをすべて取得
    if($stmt){
      return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return false;
    }
  } catch (Exception $e) {
    // error_log('エラー発生: ' . $e->getMessage());
  }
}
