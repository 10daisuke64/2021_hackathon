<?php

if ( !isset($_POST['date']) ) {
  exit('paramError');
}

$title = $_POST['title'];
$comment = $_POST['comment'];
$date = $_POST['date'];
$date_json = json_encode($date);
$room_url = md5(uniqid(rand(), true));

// DB接続
$dbn = 'mysql:dbname=2021_hackathon;charset=utf8mb4;port=8889;host=localhost';
$user = 'root';
$pwd = 'root';

try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

$sql = 'INSERT INTO room(id, date, title, comment, room_url, created_at, updated_at) VALUES(NULL, :date_json, :title, :comment, :room_url, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date_json', $date_json, PDO::PARAM_STR);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':room_url', $room_url, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:result.php?room={$room_url}");
exit();
