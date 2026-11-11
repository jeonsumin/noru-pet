const dateTabs = document.querySelectorAll('.date-tab');

var target = '';
dateTabs.forEach((tab) => {
    tab.addEventListener('click', () => {
        dateTabs.forEach((item) => {
            const selected = item === tab;
            item.classList.toggle('is-selected', selected);
            item.setAttribute('aria-pressed', String(selected));
            target = tab.dataset.date;
        });
        location.href = "?date=" + target;
    });

});

document.querySelector('#export-csv').addEventListener('click', () => {
    const rows = [...document.querySelectorAll('table tr')].map((row) =>
        [...row.children].map((cell) => `"${cell.innerText.trim().replaceAll('"', '""')}"`).join(','),
    );
    const blob = new Blob(['\uFEFF' + rows.join('\r\n')], {type: 'text/csv;charset=utf-8'});
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'noroo-wa-dashboard.csv';
    link.click();
    URL.revokeObjectURL(url);
});
