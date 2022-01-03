<?php include("functions.php"); ?>
<?php include("header.php"); ?>

    <div class="hero">
      <canvas class="hero-canvas" id="js-hero-canvas"></canvas>
      <div class="wrapper">
        <h2 class="hero-lead">食物アレルギーを<br><span>幹事だけに "やんわりと"</span> 伝えられる<br>日程調整アプリ</h2>
      </div>
    </div>

    <!-- main -->
    <main>
      <section class="section">
        <div class="wrapper">
          <h2 class="section-title">イベントを作成しよう！</h2>
          <form class="date-form" action="create.php" method="POST">
            <dl class="date-form__list">
              <dt>イベントのタイトル</dt>
              <dd><input type="text" name="title" required></dd>
            </dl>
            <dl class="date-form__list">
              <dt>コメント（任意）</dt>
              <dd><textarea name="comment"></textarea></dd>
            </dl>
            <div class="date-form__calender" id="js-calender"></div>
            <button class="date-form__submit btn" type="submit">イベントを作成する</button>
          </form>
        </div>
      </section>
    </main>
    <!-- //main -->

<?php include("footer.php"); ?>
