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
        const params = new URLSearchParams(location.search);
        params.set('date', target);
        params.delete('page');
        location.search = params.toString();
    });

});

document.querySelector('#export-xlsx')?.addEventListener('click', () => {
    const params = new URLSearchParams(location.search);
    params.set('export', 'xlsx');
    location.href = '?' + params.toString();
});

document.querySelector('.logout')?.addEventListener('click', () => {
    location.href = 'logout.php';
});
