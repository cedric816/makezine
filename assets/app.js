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