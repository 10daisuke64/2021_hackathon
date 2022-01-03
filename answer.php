<?php
  $room_url = $_GET["room"];

  $dbn = 'mysql:dbname=2021_hackathon;charset=utf8mb4;port=8889;host=localhost';
  $user = 'root';
  $pwd = 'root';
  try {
    $pdo = new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }

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

  $date_array = json_decode($result[0]["date"]);

  $answer_output = "";
  foreach ($date_array as $date) {
    $answer_output .= "<tr>";
    $answer_output .= "<th>{$date}</th>";
    $answer_output .= "
    <td>
      <div class='answer-radio'>
        <label class='radio'><input type='radio' name='answer[{$date}]' value='○' required><span>○</span></label>
        <label class='radio'><input type='radio' name='answer[{$date}]' value='△' required><span>△</span></label>
        <label class='radio'><input type='radio' name='answer[{$date}]' value='×' required><span>×</span></label>
      </div>
    </td>
    ";
    $answer_output .= "</tr>";
  }

?>
<?php include("header.php"); ?>
<!-- main -->
<main>
  <section class="section">
    <div class="wrapper">
      <h2 class="section-title">出欠を回答する</h2>
      <form class="answer-form" action="answer_send.php" method="POST">
        <input type="text" name="room_url" value="<?= $room_url ?>" hidden>
        <dl class="answer-form__list">
          <dt>お名前</dt>
          <dd>
            <input type="text" name="name" required>
          </dd>
        </dl>
        <table class="answer-table">
          <?= $answer_output ?>
        </table>
        <dl class="answer-form__info">
          <dt>食物アレルギー：</dt>
          <dd>
            <label class="radio">
              <input type="radio" name="allergy_check" value="0" checked>
              <span>無</span>
            </label>
            <label class="radio">
              <input type="radio" name="allergy_check" value="1" id="js-allergy-check">
              <span>有</span>
            </label>
          </dd>
        </dl>
        <dl class="answer-form__allergy" id="js-allergy-list">
          <dt>アレルギー品目（複数選択可）：</dt>
          <dd>
            <?php include("allergy_list.php"); ?>
          </dd>
        </dl>
        <button class="answer-form__submit btn" type="submit">送信</button>
      </form>
    </div>
  </section>
</main>
<!-- //main -->
<?php include("footer.php"); ?>
