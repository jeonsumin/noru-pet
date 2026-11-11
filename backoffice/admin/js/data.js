document.querySelectorAll('.date-tab').forEach((tab) => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.date-tab').forEach((item) => {
      const selected = item === tab;
      item.classList.toggle('is-selected', selected);
      item.setAttribute('aria-pressed', String(selected));
    });
  });
});

document.querySelector('#export-csv').addEventListener('click', () => {
  const rows = [...document.querySelectorAll('.participant-table tr')].map((row) =>
    [...row.children].map((cell) => `"${cell.innerText.trim().replaceAll('"', '""')}"`).join(','),
  );
  const link = document.createElement('a');
  link.href = URL.createObjectURL(new Blob(['\uFEFF' + rows.join('\r\n')], { type: 'text/csv;charset=utf-8' }));
  link.download = 'noroo-wa-participants.csv';
  link.click();
  URL.revokeObjectURL(link.href);
});
