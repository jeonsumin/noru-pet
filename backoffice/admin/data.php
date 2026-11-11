<!doctype html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#47201e" />
    <title>참여자 데이터 | NOROO WA</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/data.css" />
    <script src="js/data.js" defer></script>
  </head>
  <body>
    <div class="app-shell">
      <aside class="sidebar">
        <a class="brand" href="dashboard.php" aria-label="NOROO WA 홈">
          <strong>NOROO<br />WA</strong>
          <span>펫 안전 캠페인 · Admin</span>
        </a>
        <nav class="navigation" aria-label="주 메뉴">
          <a class="nav-link" href="dashboard.php"><span class="nav-icon" aria-hidden="true"></span>대시보드</a>
          <a class="nav-link is-active" href="data.php" aria-current="page"><span class="nav-icon" aria-hidden="true"></span>참여자 데이터</a>
        </nav>
        <div class="sidebar-bottom">
          <section class="event-card" aria-label="행사 기간">
            <span>행사</span><strong>2026.11.20 (금) – 11.22 (일)</strong>
          </section>
          <div class="profile">
            <span class="avatar" aria-hidden="true">A</span>
            <span class="profile-name"><strong>admin</strong><small>관리자</small></span>
            <button class="logout" type="button">로그아웃</button>
          </div>
        </div>
      </aside>

      <main class="main-content">
        <header class="page-header">
          <div>
            <h1>참여자 데이터</h1>
            <p class="updated">참여 1건 = 1명 (참여 ID 기준) · 개인 식별 정보는 수집하지 않습니다</p>
          </div>
          <button class="export-button" id="export-csv" type="button"><span aria-hidden="true">↓</span> 엑셀 다운로드</button>
        </header>

        <section class="data-toolbar" aria-label="참여자 데이터 필터">
          <div class="date-tabs" role="group" aria-label="참여 날짜 선택">
            <button class="date-tab" type="button" aria-pressed="false">전체 기간</button>
            <button class="date-tab" type="button" aria-pressed="false">11.20 (금)</button>
            <button class="date-tab is-selected" type="button" aria-pressed="true">11.21 (토)</button>
            <button class="date-tab" type="button" aria-pressed="false">11.22 (일)</button>
          </div>
          <div class="select-filters">
            <label class="visually-hidden" for="sort-order">정렬 순서</label>
            <select id="sort-order"><option>최근 참여순</option><option>오래된 참여순</option></select>
            <label class="visually-hidden" for="page-size">페이지 표시 개수</label>
            <select id="page-size"><option>20개씩 보기</option><option>50개씩 보기</option><option>100개씩 보기</option></select>
          </div>
        </section>

        <section class="data-card" aria-labelledby="data-title">
          <h2 class="visually-hidden" id="data-title">11월 21일 참여 결과</h2>
          <p class="data-summary"><strong>11.21 (토)</strong><span>검색 결과 <b>512건</b></span></p>
          <div class="data-table-wrap">
            <table class="participant-table">
              <thead><tr>
                <th scope="col">No</th><th scope="col">참여 ID</th><th scope="col">참여 일시</th><th scope="col">채널</th>
                <th scope="col">Q1</th><th scope="col">Q2</th><th scope="col">Q3</th><th scope="col">Q4</th><th scope="col">결과 TYPE</th><th scope="col">완료 여부</th>
              </tr></thead>
              <tbody>
                <tr><td>512</td><td>K02-1121-0412</td><td>11.21 17:48</td><td>키오스크</td><td>A</td><td>A</td><td>C</td><td>B</td><td><span class="result-type type-green">TYPE 01</span> 미끄러지는 개구쟁이</td><td>완료</td></tr>
                <tr><td>511</td><td>W-1121-0871</td><td>11.21 17:46</td><td>모바일 웹</td><td>C</td><td>C</td><td>D</td><td>A</td><td><span class="result-type type-blue">TYPE 06</span> 실수 잦은 순둥이</td><td>완료</td></tr>
                <tr><td>510</td><td>K01-1121-0398</td><td>11.21 17:45</td><td>키오스크</td><td>D</td><td>A</td><td>B</td><td>C</td><td><span class="result-type type-purple">TYPE 07</span> 영역 표시 대장</td><td>완료</td></tr>
                <tr><td>509</td><td>K03-1121-0377</td><td>11.21 17:44</td><td>키오스크</td><td>B</td><td>A</td><td>—</td><td>—</td><td>—</td><td class="incomplete">미완료</td></tr>
                <tr><td>508</td><td>W-1121-0869</td><td>11.21 17:41</td><td>모바일 웹</td><td>B</td><td>C</td><td>A</td><td>D</td><td><span class="result-type type-gold">TYPE 04</span> 적극적인 장난꾸러기</td><td>완료</td></tr>
                <tr><td>507</td><td>K02-1121-0411</td><td>11.21 17:40</td><td>키오스크</td><td>D</td><td>D</td><td>C</td><td>D</td><td><span class="result-type type-purple">TYPE 08</span> 조그난해 뚫똥 단짝</td><td>완료</td></tr>
                <tr><td>506</td><td>K01-1121-0397</td><td>11.21 17:38</td><td>키오스크</td><td>A</td><td>D</td><td>B</td><td>C</td><td><span class="result-type type-green">TYPE 02</span> 조심조심 산책가</td><td>완료</td></tr>
                <tr><td>505</td><td>W-1121-0866</td><td>11.21 17:35</td><td>모바일 웹</td><td>C</td><td>B</td><td>A</td><td>A</td><td><span class="result-type type-blue">TYPE 05</span> 열을 남기는 탐험가</td><td>완료</td></tr>
                <tr><td>504</td><td>K03-1121-0376</td><td>11.21 17:33</td><td>키오스크</td><td>B</td><td>B</td><td>A</td><td>C</td><td><span class="result-type type-gold">TYPE 03</span> 가구 파괴자</td><td>완료</td></tr>
                <tr><td>503</td><td>K01-1121-0396</td><td>11.21 17:31</td><td>키오스크</td><td>A</td><td>A</td><td>C</td><td>A</td><td><span class="result-type type-green">TYPE 01</span> 미끄러지는 개구쟁이</td><td>완료</td></tr>
                <tr><td>502</td><td>W-1121-0862</td><td>11.21 17:29</td><td>모바일 웹</td><td>D</td><td>C</td><td>C</td><td>D</td><td><span class="result-type type-purple">TYPE 08</span> 조그난해 뚫똥 단짝</td><td>완료</td></tr>
                <tr><td>501</td><td>K02-1121-0409</td><td>11.21 17:27</td><td>키오스크</td><td>C</td><td>A</td><td>B</td><td>A</td><td><span class="result-type type-blue">TYPE 05</span> 열을 남기는 탐험가</td><td>완료</td></tr>
                <tr><td>500</td><td>K03-1121-0375</td><td>11.21 17:26</td><td>키오스크</td><td>A</td><td>—</td><td>—</td><td>—</td><td>—</td><td class="incomplete">미완료</td></tr>
              </tbody>
            </table>
          </div>
          <nav class="pagination" aria-label="페이지 이동">
            <button type="button" aria-label="이전 페이지" disabled>‹</button>
            <button type="button" class="current" aria-current="page">1</button>
            <button type="button">2</button><button type="button">3</button><button type="button">4</button><button type="button">5</button>
            <span>…</span><button type="button">26</button><button type="button" aria-label="다음 페이지">›</button>
          </nav>
        </section>
      </main>
    </div>
  </body>
</html>
