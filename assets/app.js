/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

require('bootstrap');

/*
*animation CSS lors navigation zine
*/
let currentPageNb = 1;
let oldPageNb;
let currentPageEl;
let oldPageEl;
let nextControlEl = document.getElementById('nextControl');
let previousControlEl = document.getElementById('previousControl');

function assignCss (nb){
    currentPageEl = document.querySelector('#nav-zine button:nth-child('+nb+')');
    currentPageEl.classList.add('current-btn');
}

function removeCss (nb){
    oldPageEl = document.querySelector('#nav-zine button:nth-child('+nb+')');
    oldPageEl.classList.remove('current-btn');
}

if (nextControlEl != null){
    nextControlEl.addEventListener('click', function(){
        if (currentPageNb == 9){
            currentPageNb = 1;
            oldPageNb = 9;
            removeCss(oldPageNb);
            assignCss(currentPageNb);
        } else {
            oldPageNb = currentPageNb;
            currentPageNb ++;
            removeCss(oldPageNb);
            assignCss(currentPageNb);
        }
    })
}

if (previousControlEl != null){
    previousControlEl.addEventListener('click', function(){
        if (currentPageNb == 1){
            currentPageNb = 9;
            oldPageNb = 1;
            removeCss(oldPageNb);
            assignCss(currentPageNb);
        } else {
            oldPageNb = currentPageNb;
            currentPageNb --;
            removeCss(oldPageNb);
            assignCss(currentPageNb);
        }
    })
}

let btnList = document.getElementsByClassName('page-btn');
for (let btn of btnList){
    btn.addEventListener('click', function(){
        oldPageNb = currentPageNb;
        currentPageNb = parseInt(btn.dataset.position);
        removeCss(oldPageNb);
        assignCss(currentPageNb);
    })
}

/*
*animation du formulaire de création d'un module
*/
let champType = document.getElementById('champ-type');
let champContenu = document.getElementById('champ-contenu');
let champLegende = document.getElementById('champ-legende');
let champCollage = document.getElementById('champ-collage');
let champScotch = document.getElementById('champ-scotch');
let champUrl = document.getElementById('champ-url');
let submitBtn = document.getElementById('submit-btn');

champLegende.style.display = 'none';
champUrl.style.display = 'none';
champCollage.style.display = 'none';
champContenu.style.display = 'none';
champScotch.style.display = 'none';
submitBtn.style.display = 'none';

let typeEl = document.getElementById('module_type');
let champ = typeEl.value;
if (champ == 'paragraph' || champ == 'title') {
    champLegende.style.display = 'none';
    champUrl.style.display = 'none';
    champCollage.style.display = 'block';
    champContenu.style.display = 'block';
    champScotch.style.display = 'none';
    submitBtn.style.display = 'block';
} else if (champ == 'image') {
    champLegende.style.display = 'block';
    champUrl.style.display = 'block';
    champCollage.style.display = 'none';
    champContenu.style.display = 'none';
    champScotch.style.display = 'block';
    submitBtn.style.display = 'block';
}

champType.addEventListener('change', function (event) {
    champ = event.target.value;
    if (champ == 'paragraph' || champ == 'title') {
        champLegende.style.display = 'none';
        champUrl.style.display = 'none';
        champCollage.style.display = 'block';
        champContenu.style.display = 'block';
        champScotch.style.display = 'none';
        submitBtn.style.display = 'block';
    } else if (champ == 'image') {
        champLegende.style.display = 'block';
        champUrl.style.display = 'block';
        champCollage.style.display = 'none';
        champContenu.style.display = 'none';
        champScotch.style.display = 'block';
        submitBtn.style.display = 'block';
    }
})
