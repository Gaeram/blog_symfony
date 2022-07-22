

const body = document.querySelector('.js-body');
// je regarde l'activation du dark mode dans le local storage
// si oui, j'active la propriété css visée
if(localStorage.getItem('nightActivated') === 'true'){
    body.classList.add('night-activated')
}
const nightToggle = document.querySelector('.js-night-toggle')
// fonction réagissant à l'évenement clic
// le dark mode s'applique seulement quand un un clic sur le bouton est exécuté
nightToggle.addEventListener('click',function () {
    // si le dark mode est activé, je le désactive
    if (body.classList.contains('night-activated')) {
        body.classList.remove('night-activated');
        // je le retire du local storage
        localStorage.removeItem('nightActivated');
    } else {
        // s'il n'est pas activé, je l'active
        body.classList.add('night-activated');
        // je l'enregiste dans le local storage afin de le laisser activer sur toutes les pages
        localStorage.setItem('nightActivated', 'true');
    }
});

// Menu Burger

// je créée mes constantes afin de pouvoir assigner les classes CSS
const burger = document.querySelector('.nav-toggler');
const navig = document.querySelector("nav");

// J'écoute le clique puis execute la fonction
burger.addEventListener("click", toggleNav)
// qui rajoute la classe active à nav-toggler ce qui
// permet son affichage
function toggleNav(){
    burger.classList.toggle("active")
    navig.classList.toggle("active")
}