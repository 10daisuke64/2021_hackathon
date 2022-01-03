<?php
if ( !isset($_POST['name']) ) {
  exit('お名前が入力されていません');
}
if ( !isset($_POST['answer']) ) {
  exit('スケジュールが全て入力されていません');
}
$name = $_POST['name'];
$answer = $_POST['answer'];
$answer_json = json_encode($answer);
$allergy = $_POST['allergy'];
$allergy_json = json_encode($allergy);
$room_url = $_POST['room_url'];

// var_dump($answer);
// exit();

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

$sql = 'INSERT INTO users(id, name, room_url, answer, allergy, created_at, updated_at) VALUES(NULL, :name, :room_url, :answer_json, :allergy_json, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':room_url', $room_url, PDO::PARAM_STR);
$stmt->bindValue(':answer_json', $answer_json, PDO::PARAM_STR);
$stmt->bindValue(':allergy_json', $allergy_json, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:result.php?room={$room_url}");
exit();
