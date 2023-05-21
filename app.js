
let sliderImagesCount = document.querySelectorAll('.banner-wrapper__images__image').length;
let nextbtn =document.getElementById('nextBtn');
let prevbtn =document.getElementById('prevBtn');


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




//Themes




let themeChanger = document.getElementById('theme-change');
let bodyTheme = document.getElementById('get-theme');
let darkThemeSvg =document.getElementById('dark-mode');
let lightThemeSvg =document.getElementById('light-mode');



function setTheme(themeName) {
    localStorage.setItem('theme', themeName);
    bodyTheme.setAttribute('data-theme',themeName);

}


 function toggleTheme() {
   
    let currentTheme = bodyTheme.getAttribute('data-theme');
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



 //Forms
 let loginPasswordData = document.getElementById('password-field');
 let hidePasswordBtn =document.getElementById('hide-pass');
 let showPasswordBtn =document.getElementById('show-pass');


 hidePasswordBtn.style.display="none";
 showPasswordBtn.style.display="none";
 

 loginPasswordData.oninput= function(event){
    let tempData=(event.target.value);

    if(tempData.trim().length>0){
        showPasswordBtn.style.display="block";
    }
    else{
        hidePasswordBtn.style.display="none";
        showPasswordBtn.style.display="none";
        
    }
 }

 showPasswordBtn.onclick= ()=>{
    showPasswordBtn.style.display="none";
    hidePasswordBtn.style.display="block";
    
    loginPasswordData.setAttribute('type','text');
 }

 hidePasswordBtn.onclick= ()=>{
    showPasswordBtn.style.display="block";
    hidePasswordBtn.style.display="none";
    loginPasswordData.setAttribute('type','password');
 }



 //toast















 
