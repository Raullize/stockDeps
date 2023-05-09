const switchTema = document.getElementById('darkmode-toggle');

switchTema.addEventListener('change', () => {
  if (switchTema.checked) {
    // ativar o modo escuro
    document.cookie = 'darkmode=true';
    document.documentElement.classList.add('dark-mode');
  } else {
    // ativar o modo claro
    document.cookie = 'darkmode=false';
    document.documentElement.classList.remove('dark-mode');
  }
});

const darkModeCookie = document.cookie.split('; ').find(row => row.startsWith('darkmode='));
if (darkModeCookie) {
  const isDarkMode = darkModeCookie.split('=')[1] === 'true';
  if (isDarkMode) {
    // ativar o modo escuro
    switchTema.checked = true;
    document.documentElement.classList.add('dark-mode');
  }
}
