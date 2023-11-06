const tombolCari = document.querySelector('.tombol-cari');
const keyword = document.querySelector('.keyword');
const container = document.querySelector('.container');

// hilangkan tombol cari
tombolCari.style.display = 'none';

// event ketika menuliskan keyword
keyword.addEventListener('keyup', function () {
  // ajax
  // // xmlhttprequest
  // const xhr = new XMLHttpRequest();

  // xhr.onreadystatechange = function () {
  //   if (xhr.readyState == 4 && xhr.status == 200) {
  //     container.innerHTML = xhr.responseText;
  //   }
  // };

  // xhr.open('get', 'ajax/ajax_cari.php?keyword=' + keyword.value);
  // xhr.send();

  // fetch()
  fetch('ajax/ajax_cari.php?keyword=' + keyword.value)
    .then((Response) => Response.text())
    .then((Response) => (container.innerHTML = Response));


});