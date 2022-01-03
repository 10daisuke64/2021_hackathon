<?php
  $room_url = $_GET["room"];

  //------------------------------
  // DB接続
  //------------------------------
  $dbn = 'mysql:dbname=2021_hackathon;charset=utf8mb4;port=8889;host=localhost';
  $user = 'root';
  $pwd = 'root';
  try {
    $pdo = new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }

  //------------------------------
  // スケジュール情報
  //------------------------------
  $sql = "SELECT * FROM room WHERE room_url = '{$room_url}'";
  $stmt = $pdo->prepare($sql);
  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // var_dump($result);

  //------------------------------
  // 回答データ
  //------------------------------
  $sql_answer = "SELECT * FROM users WHERE room_url = '{$room_url}'";
  $stmt_answer = $pdo->prepare($sql_answer);
  try {
    $status = $stmt_answer->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
  $result_answer = $stmt_answer->fetchAll(PDO::FETCH_ASSOC);
  // var_dump($result_answer);

  //------------------------------
  // スケジュールのデータ出力
  //------------------------------
  $title = $result[0]["title"];
  $comment = $result[0]["comment"];
  $date_array = json_decode($result[0]["date"]);

  // データの成形
  $answer = [];
  foreach ($date_array as $data) {
    $answer[$data] = [];
  }
  foreach ($result_answer as $result_answer_data) {
    $decode_array = json_decode($result_answer_data["answer"]);
    foreach ($decode_array as $key => $value) {
      array_push($answer[$key], $value);
    }
  }
  // var_dump($answer);

  // 出力
  $output = "";
  foreach ($answer as $key => $array) {

    // カウント
    $counter_m = 0;
    $counter_s = 0;
    $counter_b = 0;
    $counter_all = 0;
    foreach ($array as $data) {
      if ( $data == "○" ) {
        $counter_m++;
        $counter_all++;
      } elseif ( $data == "△" ) {
        $counter_s++;
        $counter_all++;
      } elseif ( $data == "×" ) {
        $counter_b++;
        $counter_all++;
      }
    }

    $output .= "<tr>";
    $output .= "<th>{$key}</th>";
    if ( $counter_all == $counter_m && $counter_all != 0 ) {
      $output .= "<td class='all'><div>";
    } else {
      $output .= "<td><div>";
    }
    // ○のカウント出力
    $output .= "<span>○ {$counter_m}</span>";
    // △のカウント出力
    $output .= "<span>△ {$counter_s}</span>";
    // ×のカウント出力
    $output .= "<span>× {$counter_b}</span>";

    $output .= "</div></td>";
    $output .= "</tr>";
  }

  //------------------------------
  // アレルギーのデータ出力
  //------------------------------
  $allergy = [];
  foreach ($result_answer as $result_answer_data) {
    $decode_array = json_decode($result_answer_data["allergy"]);
    $allergy = array_merge($allergy, $decode_array);
  }
  // 重複した値を除去
  $allergy = array_unique($allergy);
  // var_dump($allergy);

  $allergy_output = "";
  foreach ($allergy as $data) {
    $allergy_output .= "<li>{$data}アレルギーの参加者がいます</li>";
  }
?>

<?php include("header.php"); ?>
<!-- main -->
<main>
  <section class="section section--bg">
    <div class="wrapper">
      <h2 class="section-title">参加者にURLを共有しよう！</h2>
      <button class="result-copy btn" onclick="copyUrl()">URLをコピー</button>
    </div>
  </section>
  <section class="section">
    <div class="wrapper">
      <h2 class="section-title"><?= $title ?></h2>
      <p class="section-lead"><?= $comment ?></p>
      <div class="result">
        <ul class="result-allergy">
          <?= $allergy_output ?>
        </ul>
        <table class="result-table">
          <?= $output ?>
        </table>
      </div>
      <a class="result-action btn" href="answer.php?room=<?= $room_url ?>">回答する</a>
    </div>
  </section>
</main>
<!-- //main -->
<?php include("footer.php"); ?>
