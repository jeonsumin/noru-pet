document.querySelector('#sort-order').addEventListener('change', (e) => {
  const params = new URLSearchParams(location.search);
  params.set('sort', e.target.value);
  location.search = params.toString();
});

document.querySelector('#page-size').addEventListener('change', (e) => {
  const params = new URLSearchParams(location.search);
  params.set('size', e.target.value);
  params.delete('page');
  location.search = params.toString();
});

document.querySelectorAll('.pagination [data-page]').forEach((btn) => {
  btn.addEventListener('click', () => {
    const params = new URLSearchParams(location.search);
    params.set('page', btn.dataset.page);
    location.search = params.toString();
  });
});