<?php
include_once('./_common.php');

$loginCheck =  _BB_ADMIN_URL_PATH."/login.check.php";

?>

<!doctype html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#47201e" />
    <title>관리자 접속 | NOROO WA</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/login.css" />
    <script src="js/login.js" defer></script>
  </head>
  <body class="login-page">
    <main class="login-layout">
      <section class="login-panel" aria-labelledby="login-title">
        <a class="login-brand" href="index.html" aria-label="NOROO WA 대시보드">
          <span class="login-logo">NOROOWA</span>
          <span class="login-brand-copy">펫 안전 검진존 <i></i> Admin</span>
        </a>

        <div class="login-content">
          <div class="lock-mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><rect x="5" y="10" width="14" height="11" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 10V7a4 4 0 0 1 8 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><circle cx="12" cy="15" r="1.2" fill="currentColor"/></svg>
          </div>
          <p class="login-eyebrow">ADMIN ACCESS</p>
          <h1 id="login-title">관리자 접속</h1>
          <p class="login-description">관리자 접근 코드를 입력해 주세요.</p>

          <form id="access-form" action="<?php echo $loginCheck ?>" method="POST">
            <label for="access-code">접근 코드</label>
            <input
             id="access-code"
              name="accessCode" type="password" autocomplete="one-time-code" placeholder="접근 코드 입력" required />
            <button class="login-submit" type="submit">관리자 접속 <span aria-hidden="true">→</span></button>
            <p class="login-status" id="login-status" role="status" aria-live="polite"></p>
          </form>
          <p class="login-help">접근 코드가 없으신가요?<br />행사 관리자에게 문의해 주세요.</p>
        </div>

        <footer class="login-footer">© NOROO WA · ADMIN</footer>
      </section>
      <aside class="login-art" aria-hidden="true">
        <div class="art-orbit orbit-one"></div><div class="art-orbit orbit-two"></div>
        <div class="art-copy"><span>SAFE HOME, HAPPY PET</span><p>우리의 작은 관심이<br />반려동물의 안전한 하루를 만듭니다.</p></div>
        <span class="art-index">NOROO WA <b>·</b> 2026</span>
      </aside>
    </main>
  </body>
</html>
