let themeChanger = document.getElementById('theme-change');
let bodyTheme = document.getElementById('get-theme');


function setTheme(themeName) {
    localStorage.setItem('theme', themeName);
    bodyTheme.setAttribute('data-theme',themeName);

}


 function toggleTheme() {
   
    let currentTheme = bodyTheme.getAttribute('data-theme');
    console.log(currentTheme);
    if (localStorage.getItem('theme') === 'dark'){
        setTheme('default');
    } else {
        setTheme('dark');
    }
 }

 
(function () {
    if (localStorage.getItem('theme') === 'dark') {
        setTheme('dark');
    } else {
        setTheme('default');
    }
 })();
