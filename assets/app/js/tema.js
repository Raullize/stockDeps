const switchTema = document.getElementById('darkmode-toggle');

function darkmode() {
    const body = document.querySelector('body');
    body.classList.toggle('dark-mode');
  }
  
  switchTema.addEventListener('click', darkmode);