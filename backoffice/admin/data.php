<?php
    include_once('./_common.php');
    //정렬
    $sort = ($_GET['sort'] ?? '') === 'old' ? 'old' : 'new';

    //리스트 갯수
    $size = in_array((int)($_GET['size'] ?? 20), [20, 50, 100]) ? (int)($_GET['size'] ?? 20) : 20;

    //페이지네이션
    $page = max(1, (int)($_GET['page'] ?? 1));

    //전체 리스트
    $allDataListSql = "SELECT * FROM surveyList sl WHERE 1=1";

    //전체 데이터 갯수
    $dataTotalSql = "SELECT COUNT(*) AS CNT FROM surveyList sl WHERE 1=1";

    if (isset($_GET['date']) && $_GET['date'] !== 'all') {
        $date_where = " AND DATE(sl.CreatedAt) = '". $date . "'";

        $allDataListSql .= $date_where;
        $dataTotalSql .= $date_where;
    }

    $allDataListSql .= $sort === 'old' ? " ORDER BY sl.CreatedAt ASC" : " ORDER BY sl.CreatedAt DESC";

    //엑셀
    if (($_GET['export'] ?? '') === 'xlsx') {
        error_reporting(E_ALL & ~E_DEPRECATED);
        require_once __DIR__ . '/../phpoffice/vendor/autoload.php';

        $rows = [['No', '참여 일시', '채널', 'Q1', 'Q2', 'Q3', 'Q4', '결과 TYPE', '유형명', '완료 여부']];
        foreach (rf_mysql_arr($allDataListSql, $DB) as $idx => $value) {
            $done = !empty($value['Result']);
            $rows[] = [$idx + 1, $value['CreatedAt'], $value['ChannelType'], $value['Q1'], $value['Q2'], $value['Q3'], $value['Q4'], $value['Result'], $done ? types($value['Result'])['title'] : '', $done ? '완료' : '미완료'];
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('참여자 데이터');
        $sheet->fromArray($rows, null, 'A1');
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        while (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $fileDate = isset($_GET['date']) && $_GET['date'] !== 'all' ? $_GET['date'] : '전체기간';
        header("Content-Disposition: attachment; filename*=UTF-8''" . rawurlencode("noroo-wa-participants_{$fileDate}.xlsx"));
        (new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet))->save('php://output');
        exit;
    }

    $allDataListSql .= " LIMIT " . $size . " OFFSET " . (($page - 1) * $size);
    $dataTotalData = rf_mysql_row($dataTotalSql, $DB);
    $lastPage = max(1, (int)ceil($dataTotalData['CNT'] / $size));
    $allDataDate = rf_mysql_arr($allDataListSql, $DB);
?>

<!doctype html>
<html lang="ko">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#47201e" />
    <title>참여자 데이터 | NOROO WA</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/data.css" />
    <script src="js/app.js" defer></script>
    <script src="js/data.js" defer></script>
  </head>
  <body>
    <div class="app-shell">
      <aside class="sidebar">
        <a class="brand" href="dashboard.php" aria-label="NOROO WA 홈">
          <strong>NOROOWA</strong>
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
          <button class="export-button" id="export-xlsx" type="button"><span aria-hidden="true">↓</span> 엑셀 다운로드</button>
        </header>

        <section class="data-toolbar" aria-label="참여자 데이터 필터">
          <div class="date-tabs" role="group" aria-label="참여 날짜 선택">
            <?php
                $selDate = $_GET['date'] ?? 'all';
                $dateTabs = ['all' => '전체 기간', '2026-11-20' => '11.20 (금)', '2026-11-21' => '11.21 (토)', '2026-11-22' => '11.22 (일)'];
                foreach ($dateTabs as $value => $label) {
                    $on = $selDate === $value;
                ?>
                    <button class="date-tab<?php echo $on ? ' is-selected' : ''; ?>" type="button" data-date="<?php echo $value; ?>" aria-pressed="<?php echo $on ? 'true' : 'false'; ?>"><?php echo $label; ?></button>
                <?php } ?>
          </div>
          <div class="select-filters">
            <label class="visually-hidden" for="sort-order">정렬 순서</label>
            <select id="sort-order">
              <option value="new" <?= $sort === 'new' ? 'selected' : '' ?>>최근 참여순</option>
              <option value="old" <?= $sort === 'old' ? 'selected' : '' ?>>오래된 참여순</option>
            </select>
            <label class="visually-hidden" for="page-size">페이지 표시 개수</label>
              <select id="page-size">
                <?php foreach ([20, 50, 100] as $n) { ?>
                  <option value="<?= $n ?>" <?= $size === $n ? 'selected' : '' ?>><?= $n ?>개씩 보기</option>
                <?php } ?>
              </select>
          </div>
        </section>

        <section class="data-card" aria-labelledby="data-title">
          <p class="data-summary"><strong><?= $dateTabs[$selDate] ?? '전체 기간' ?></strong><span>검색 결과 <b><?= $dataTotalData['CNT'] ?>건</b></span></p>
          <div class="data-table-wrap">
            <table class="participant-table">
              <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">참여 일시</th>
                    <th scope="col">채널</th>
                    <th scope="col">Q1</th>
                    <th scope="col">Q2</th>
                    <th scope="col">Q3</th>
                    <th scope="col">Q4</th>
                    <th scope="col" class="left">결과 TYPE</th>
                    <th scope="col">완료 여부</th>
                  </tr>
            </thead>
              <tbody>
                    <?php foreach ($allDataDate as $idx => $value) {

                    ?>
                        <tr>
                            <td><?= ($page - 1) * $size + $idx + 1 ?></td>
                            <td class="center"><?= date('m.d H:i', strtotime($value['CreatedAt'])) ?></td>
                            <td><?= $value['ChannelType']?></td>
                            <td><?= !empty($value['Q1']) ? $value['Q1'] : '<span class="empty-dash"></span>' ?></td>
                            <td><?= !empty($value['Q2']) ? $value['Q2'] : '<span class="empty-dash"></span>' ?></td>
                            <td><?= !empty($value['Q3']) ? $value['Q3'] : '<span class="empty-dash"></span>' ?></td>
                            <td><?= !empty($value['Q4']) ? $value['Q4'] : '<span class="empty-dash"></span>' ?></td>
                            <td class="left">
                                <?php if (empty($value['Result'])) { ?>
                                <span class="empty-dash"></span>
                                <?php } else { ?>
                                <span class="result-type type-<?= type_color($value['Result']) ?>"><?= $value['Result']?></span>
                                <span><?= types($value['Result'])['title'] ?></span>
                                <?php } ?>
                            </td>
                            <td class="center<?= empty($value['Result']) ? ' is-incomplete' : '' ?>">
                                <?= empty($value['Result']) ? '미완료' : '완료' ?>
                            </td>
                        </tr>
                    <?php }?>
              </tbody>
            </table>
          </div>
              <nav class="pagination" aria-label="페이지 이동">
                <?php
                  $start = intdiv($page - 1, 10) * 10 + 1;
                  $end = min($lastPage, $start + 9);
                ?>
                <button type="button" data-page="1" aria-label="첫 페이지" <?= $page <= 1 ? 'disabled' : '' ?>>«</button>
                <button type="button" data-page="<?= $page - 1 ?>" aria-label="이전 페이지" <?= $page <= 1 ? 'disabled' : '' ?>>‹</button>
                <?php for ($i = $start; $i <= $end; $i++) { ?>
                  <button type="button" data-page="<?= $i ?>" <?= $i === $page ? 'class="current" aria-current="page"' : '' ?>><?= $i ?></button>
                <?php } ?>
                <button type="button" data-page="<?= $page + 1 ?>" aria-label="다음 페이지" <?= $page >= $lastPage ? 'disabled' : '' ?>>›</button>
                <button type="button" data-page="<?= $lastPage ?>" aria-label="마지막 페이지" <?= $page >= $lastPage ? 'disabled' : '' ?>>»</button>
              </nav>
        </section>
      </main>
    </div>
  </body>
</html>
