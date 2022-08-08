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

const next = document.querySelector(".carousel__btn--next"),
    back = document.querySelector(".carousel__btn--back"),
    carousel = document.querySelector(".carousel__cards");
let angle = 0;

next.addEventListener("click", () => {
    angle -= 45;
    carousel.style.transform = `translateZ(-25rem) rotateY(${angle}deg)`;
});

back.addEventListener("click", () => {
    angle += 45;
    carousel.style.transform = `translateZ(-25rem) rotateY(${angle}deg)`;
});

setInterval(function (){
    next.click();
}, 4000);