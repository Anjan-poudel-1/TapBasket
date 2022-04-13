let themeChanger = document.getElementById('theme-change');
let bodyTheme = document.getElementById('get-theme');
let darkThemeSvg =document.getElementById('dark-mode');
let lightThemeSvg =document.getElementById('light-mode');

let sliderImagesCount = document.querySelectorAll('.banner-wrapper__images__image').length;
let nextbtn =document.getElementById('nextBtn');
let prevbtn =document.getElementById('prevBtn');

console.log(sliderImagesCount);
let currentdisplay= null;
let timer = 6000;
let myVar = null;
let imagetrack = 0;
let executed = 0 ;
let sliderArray = [];
let initial=true;

for (var i = 1; i <= sliderImagesCount; i++) {
    sliderArray.push('image-'+i);
 }


//WE need something at first in carousel. So, the first image is kept here.

if(imagetrack==0 && initial){
   currentdisplay = document.querySelector('.'+sliderArray[0]);
   currentdisplay && currentdisplay.classList.add('show-img');
   }
// At first we need to initialize interval... 
// Upon changes, we donot want rapid change as a user might click next or previous button at the end of 6 sec timer.So, initializeinterval is called everytime next image is changed

function initializeinterval(){
     myVar = setInterval(shownext, timer);
}
if(nextbtn){
    initializeinterval();
}


function resetTimer(){
    clearInterval(myVar);
    initializeinterval();
}

nextbtn && nextbtn.addEventListener("click",shownext);
prevbtn && prevbtn.addEventListener("click",showprev);

function resetimage(id,previmg){
    currentdisplay = document.querySelector('.'+sliderArray[id]);
    previmg.classList.remove('show-img');
    currentdisplay.classList.add('show-img');
  
    initial=false;
}

//When next button is clicked

function shownext(){
    resetTimer();
    imagetrack++;
    console.log("clicked",imagetrack)
  
    if(imagetrack>(sliderArray.length-1)){   //imagetrack shows the index of slider image. if it exceeds the max value, again it is set to 0 
        imagetrack=0
    }
resetimage(imagetrack,currentdisplay);
}

//When previous button is clicked

function showprev(){
    resetTimer();
 
    imagetrack--;
   
    console.log(imagetrack);
    if(imagetrack<0){
        imagetrack=sliderArray.length-1;
        console.log(imagetrack)
    }
resetimage(imagetrack,currentdisplay);

}












function setTheme(themeName) {
    localStorage.setItem('theme', themeName);
    bodyTheme.setAttribute('data-theme',themeName);

}


 function toggleTheme() {
   
    let currentTheme = bodyTheme.getAttribute('data-theme');
    console.log(currentTheme);
    if (localStorage.getItem('theme') === 'dark'){
        setTheme('default');
        darkThemeSvg.style.display="none";
        lightThemeSvg.style.display="block";
    } else {
        setTheme('dark');
        lightThemeSvg.style.display="none";
        darkThemeSvg.style.display="block";
    }
 }

 
(function () {
    if (localStorage.getItem('theme') === 'dark') {
        setTheme('dark');
        lightThemeSvg.style.display="none";
        darkThemeSvg.style.display="block";
    } else {
        setTheme('default');
        darkThemeSvg.style.display="none";
        lightThemeSvg.style.display="block";
    }
 })();
