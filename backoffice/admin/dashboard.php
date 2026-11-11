<?php
include_once('./_common.php');

$allDataSql = "SELECT COUNT(*) AS CNT FROM surveyList sl WHERE 1=1";

$surveySuccess = "SELECT COUNT(*) AS CNT FROM surveyList sl WHERE Result IS NOT NULl";

$typeSql = "SELECT count(case when sl.ChannelType = 'KIOSK' then 1 end) as KIOSK_CNT, count(case when sl.ChannelType = 'WEB' then 1 end) as WEB_CNT FROM surveyList sl WHERE 1=1 ";


$resultSql = "SELECT
                  T.Result,
                  COUNT(sl.Result) AS TYPE_CNT
              FROM (
                  SELECT 'TYPE1' AS Result UNION ALL
                  SELECT 'TYPE2' UNION ALL
                  SELECT 'TYPE3' UNION ALL
                  SELECT 'TYPE4' UNION ALL
                  SELECT 'TYPE5' UNION ALL
                  SELECT 'TYPE6' UNION ALL
                  SELECT 'TYPE7' UNION ALL
                  SELECT 'TYPE8'
              ) T
              LEFT JOIN surveyList sl
                  ON T.Result = sl.Result WHERE 1=1 " ;

if (isset($_GET['date'])) {
    $date_where = " AND DATE(sl.CreatedAt) = '". $date . "'";

    $surveySuccess .= $date_where;
    $allDataSql .= $date_where;
    $typeSql .= $date_where;

    $resultSql .= $date_where;

}

$resultSql .= " GROUP BY T.Result ORDER BY T.Result";


$allDataDate = rf_mysql_row($allDataSql, $DB);
$surveySuccessData = rf_mysql_row($surveySuccess, $DB);
$typeDate = rf_mysql_arr($typeSql, $DB);
$resultDate = rf_mysql_arr($resultSql, $DB);

function types($value) {
    return match($value) {
        "TYPE1" => [
            "title" => "미끄러지는 개구쟁이",
            "area" => "미끄럼방지",
            "recommend" => "논슬립 펫",
            "mbti" => "활동형"
        ],
        "TYPE2" => [
            "title" => "미끄러지는 개구쟁이",
            "area" => "미끄럼방지",
            "recommend" => "논슬립 펫",
            "mbti" => "활동형"
        ],
        "TYPE3" => [
            "title" => "미끄러지는 개구쟁이",
            "area" => "미끄럼방지",
            "recommend" => "논슬립 펫",
            "mbti" => "활동형"
        ],
        "TYPE4" => [
            "title" => "미끄러지는 개구쟁이",
            "area" => "미끄럼방지",
            "recommend" => "논슬립 펫",
            "mbti" => "활동형"
        ],
        "TYPE5" => [
            "title" => "미끄러지는 개구쟁이",
            "area" => "미끄럼방지",
            "recommend" => "논슬립 펫",
            "mbti" => "활동형"
        ],
        "TYPE6" => [
            "title" => "미끄러지는 개구쟁이",
            "area" => "미끄럼방지",
            "recommend" => "논슬립 펫",
            "mbti" => "활동형"
        ],
        "TYPE7" => [
            "title" => "미끄러지는 개구쟁이",
            "area" => "미끄럼방지",
            "recommend" => "논슬립 펫",
            "mbti" => "활동형"
        ],
        "TYPE8" => [
            "title" => "미끄러지는 개구쟁이",
            "area" => "미끄럼방지",
            "recommend" => "논슬립 펫",
            "mbti" => "활동형"
        ],
        default => []
    };
}

?>
<!doctype html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#47201e" />
    <title>대시보드 | NOROO WA</title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/app.js" defer></script>
  </head>
  <body>
    <div class="app-shell">
      <aside class="sidebar">
        <a class="brand" href="index.html" aria-label="NOROO WA 홈">
          <strong>NOROO<br />WA</strong>
          <span>펫 안전 캠페인 · Admin</span>
        </a>

        <nav class="navigation" aria-label="주 메뉴">
          <a class="nav-link is-active" href="index.html" aria-current="page">
            <span class="nav-icon" aria-hidden="true"></span>대시보드
          </a>
          <a class="nav-link" href="data.php">
            <span class="nav-icon" aria-hidden="true"></span>참여자 데이터
          </a>
        </nav>

        <div class="sidebar-bottom">
          <section class="event-card" aria-label="행사 기간">
            <span>행사</span>
            <strong>2026.11.20 (금) – 11.22 (일)</strong>
          </section>
          <div class="profile">
            <span class="avatar" aria-hidden="true">A</span>
            <span class="profile-name"><strong>admin</strong><small>관리자</small></span>
            <button class="logout" type="button">로그아웃</button>
          </div>
        </div>
      </aside>

      <main class="main-content" id="dashboard">
        <header class="page-header">
          <div>
            <p class="eyebrow">NOROO WA · ADMIN</p>
            <h1>대시보드</h1>
            <p class="updated">집계 기준 <span id="updated-at">2026.11.21 17:50</span> · 5분마다 자동 갱신</p>
          </div>
          <button class="export-button" id="export-csv" type="button">
            <span aria-hidden="true">↓</span> 엑셀 다운로드
          </button>
        </header>

        <section class="filters" aria-label="조회 기간">
          <div class="date-tabs" role="group" aria-label="조회 날짜 선택">
            <button class="date-tab is-selected" type="button" data-date="all" aria-pressed="true">전체 기간</button>
            <button class="date-tab" type="button" data-date="2026-11-20" aria-pressed="false">11.20 (금)</button>
            <button class="date-tab" type="button" data-date="2026-11-21" aria-pressed="false">11.21 (토)</button>
            <button class="date-tab" type="button" data-date="2026-11-22" aria-pressed="false">11.22 (일)</button>
          </div>
          <p class="filter-hint">날짜를 선택하면 해당 일자 기준으로 바뀝니다</p>
        </section>

        <section class="metrics" aria-label="참여 현황">
          <article class="metric-card">
            <p>총 참여</p>
            <div class="metric-value"><?= $allDataDate['CNT'] ?><small>명</small></div>
            <span class="metric-note">검진 시작 기준</span>
          </article>
          <article class="metric-card" data-progress="80.4">
            <p>검진 완료</p>
            <div class="metric-value"><?= $surveySuccessData['CNT'] ?><small>명</small></div>
            <span class="metric-note">완료율 <b>80.4%</b></span>
            <div class="progress"><span style="width:80.4%"></span></div>
          </article>
          <article class="metric-card" data-progress="62">
            <p>키오스크 참여</p>
            <div class="metric-value"> <?= $typeDate[0]['KIOSK_CNT'] ?> <small>명</small></div>
            <span class="metric-note">총 참여 대비 <b>62.0%</b></span>
            <div class="progress"><span style="width:62%"></span></div>
          </article>
          <article class="metric-card" data-progress="38">
            <p>모바일 웹 참여</p>
            <div class="metric-value"><?= $typeDate[0]['WEB_CNT'] ?><small>명</small></div>
            <span class="metric-note">총 참여 대비 <b>38.0%</b></span>
            <div class="progress"><span style="width:38%"></span></div>
          </article>
        </section>

        <section class="results-card" id="participants" aria-labelledby="results-title">
          <div class="table-heading">
            <h2 id="results-title">결과 유형별 참여</h2>
            <span>검진 완료 기준</span>
          </div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th scope="col">TYPE</th><th scope="col">유형명</th><th scope="col">영역</th>
                  <th scope="col">추천 제품</th><th scope="col">성향</th><th scope="col">인원 (명)</th><th scope="col">비율</th>
                </tr>
              </thead>
              <tbody id="results-body">
                 <?php foreach ($resultDate as $value) { ?>
                    <tr>
                        <td class="type type-green"><?= $value['Result'] ?></td>
                        <td><?= types($value['Result'])['title']?> </td>
                        <td>
                            <span class="tag tag-green">미끄럼방지</span>
                        </td>
                    <td>논슬립 펫</td>
                    <td>활동형</td>
                    <td class="number"></td>
                    <td class="number">21.0%</td>
                    </tr>

                 <?php  }?>
              </tbody>
              <tfoot>
                <tr><th colspan="5" scope="row">합계</th><td class="number">1,032</td><td class="number">100%</td></tr>
              </tfoot>
            </table>
          </div>
        </section>
      </main>
    </div>
  </body>
</html>

