<?php
include_once('./_common.php');

$allDataSql = "SELECT COUNT(*) AS CNT FROM surveyList sl WHERE 1=1";

$surveySuccess = "SELECT COUNT(*) AS CNT FROM surveyList sl WHERE Result <> ''";

$typeSql = "SELECT count(case when sl.ChannelType = 'KIOSK' then 1 end) as KIOSK_CNT, count(case when sl.ChannelType = 'WEB' then 1 end) as WEB_CNT FROM surveyList sl WHERE 1=1 ";


$resultSql = "SELECT
                  T.Result,
                  COUNT(sl.Result) AS TYPE_CNT
              FROM (
                  SELECT 'TYPE01' AS Result UNION ALL
                  SELECT 'TYPE02' UNION ALL
                  SELECT 'TYPE03' UNION ALL
                  SELECT 'TYPE04' UNION ALL
                  SELECT 'TYPE05' UNION ALL
                  SELECT 'TYPE06' UNION ALL
                  SELECT 'TYPE07' UNION ALL
                  SELECT 'TYPE08'
              ) T
              LEFT JOIN surveyList sl
                  ON T.Result = sl.Result WHERE 1=1 " ;

if (isset($_GET['date']) && $_GET['date'] !== 'all') {
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
//비율
$typeTotal = array_sum(array_column($resultDate, 'TYPE_CNT'));
$total = (int)$allDataDate['CNT'];
$doneRate = $total ? round($surveySuccessData['CNT'] / $total * 100, 1) : 0;
$KioskRate = $total ? round($typeDate[0]['KIOSK_CNT'] / $total * 100, 1) : 0;
$webRate = $total ? round($typeDate[0]['WEB_CNT'] / $total * 100, 1) : 0;


// 엑셀
if (($_GET['export'] ?? '') === 'xlsx') {
    error_reporting(E_ALL & ~E_DEPRECATED);
    require_once __DIR__ . '/../phpoffice/vendor/autoload.php';

    $rows = [
        ['기간', isset($_GET['date']) && $_GET['date'] !== 'all' ? $_GET['date'] : '전체 기간'],
        [],
        ['항목', '인원 (명)', '비율 (%)'],
        ['총 참여', $total, null],
        ['검진 완료', (int)$surveySuccessData['CNT'], $doneRate],
        ['키오스크 참여', (int)$typeDate[0]['KIOSK_CNT'], $KioskRate],
        ['모바일 웹 참여', (int)$typeDate[0]['WEB_CNT'], $webRate],
        [],
        ['TYPE', '유형명', '영역', '추천 제품', '성향', '인원 (명)', '비율 (%)'],
    ];
    foreach ($resultDate as $value) {
        $type = types($value['Result']);
        $rows[] = [$value['Result'], $type['title'], $type['area'], $type['recommend'], $type['mbti'], (int)$value['TYPE_CNT'], $typeTotal ? round($value['TYPE_CNT'] / $typeTotal * 100, 1) : 0];
    }
    $rows[] = ['합계', null, null, null, null, $typeTotal, 100];

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('대시보드');
    $sheet->fromArray($rows, null, 'A1');
    foreach (range('A', 'G') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    while (ob_get_level()) {
        ob_end_clean();
    }
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $fileDate = isset($_GET['date']) && $_GET['date'] !== 'all' ? $_GET['date'] : 'all';
    header("Content-Disposition: attachment; filename*=UTF-8''" . rawurlencode("noroo-wa-dashboard_{$fileDate}.xlsx"));
    (new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet))->save('php://output');
    exit;
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
          <strong>NOROOWA</strong>
          <span>펫 안전 검진존 · Admin</span>
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
          <button class="export-button" id="export-xlsx" type="button">
            <span aria-hidden="true">↓</span> 엑셀 다운로드
          </button>
        </header>

        <section class="filters" aria-label="조회 기간">
          <div class="date-tabs" role="group" aria-label="조회 날짜 선택">
            <?php
            $selDate = $_GET['date'] ?? 'all';
            $dateTabs = ['all' => '전체 기간', '2026-11-20' => '11.20 (금)', '2026-11-21' => '11.21 (토)', '2026-11-22' => '11.22 (일)'];
            foreach ($dateTabs as $value => $label) {
                $on = $selDate === $value;
            ?>
                <button class="date-tab<?php echo $on ? ' is-selected' : ''; ?>" type="button" data-date="<?php echo $value; ?>" aria-pressed="<?php echo $on ? 'true' : 'false'; ?>"><?php echo $label; ?></button>
            <?php } ?>
          </div>
          <p class="filter-hint">날짜를 선택하면 해당 일자 기준으로 바뀝니다</p>
        </section>

        <section class="metrics" aria-label="참여 현황">
          <article class="metric-card">
            <p>총 참여</p>
            <div class="metric-value"><?= $allDataDate['CNT'] ?><small>명</small></div>
            <span class="metric-note">검진 시작 기준</span>
          </article>
          <article class="metric-card">
            <p>검진 완료</p>
            <div class="metric-value"><?= $surveySuccessData['CNT'] ?><small>명</small></div>
            <span class="metric-note">완료율 <b><?= $doneRate ?>%</b></span>
            <div class="progress"><span style="width:<?= $doneRate ?>%"></span></div>
          </article>
          <article class="metric-card">
            <p>키오스크 참여</p>
            <div class="metric-value"> <?= $typeDate[0]['KIOSK_CNT'] ?> <small>명</small></div>
            <span class="metric-note">총 참여 대비 <b><?= $KioskRate ?>%</b></span>
            <div class="progress"><span style="width:<?= $KioskRate ?>%"></span></div>
          </article>
          <article class="metric-card">
            <p>모바일 웹 참여</p>
            <div class="metric-value"><?= $typeDate[0]['WEB_CNT'] ?><small>명</small></div>
            <span class="metric-note">총 참여 대비 <b><?= $webRate ?>%</b></span>
            <div class="progress"><span style="width:<?= $webRate ?>%"></span></div>
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
                  <th scope="col">TYPE</th>
                  <th scope="col" class="left">유형명</th>
                  <th scope="col">영역</th>
                  <th scope="col">추천 제품</th>
                  <th scope="col">성향</th>
                  <th scope="col">인원 (명)</th>
                  <th scope="col">비율</th>
                </tr>
              </thead>
              <tbody id="results-body">
                 <?php foreach ($resultDate as $value) {
                    $color = type_color($value['Result']);
                 ?>
                    <tr>
                        <td class="type type-<?= $color ?>"><?= $value['Result'] ?></td>
                        <td><?= types($value['Result'])['title']?> </td>
                        <td>
                            <span class="tag tag-<?= $color ?>"><?= types($value['Result'])['area']?></span>
                        </td>
                        <td><?= types($value['Result'])['recommend']?></td>
                        <td><?= types($value['Result'])['mbti']?></td>
                        <td class="number"><?= $value['TYPE_CNT']?></td>
                        <td class="number"><?= $typeTotal ? round($value['TYPE_CNT'] / $typeTotal * 100, 1) : 0 ?>%</td>
                    </tr>

                 <?php  }?>
              </tbody>
              <tfoot>
                <tr>
                    <th colspan="5" scope="row">합계</th>
                    <td class="number"><?= number_format($typeTotal) ?></td>
                    <td class="number">100%</td></tr>
              </tfoot>
            </table>
          </div>
        </section>
      </main>
    </div>
  </body>
</html>

