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

window.onload = function () {
    var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        autoplay: true,
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        pagination: {
            el: ".swiper-pagination",
        },
    });
    gsap.from('.landing-header', {
        duration: 1,
        opacity: 0,
        delay: 1,
        y: '-50%'
    });
    gsap.from('.my-photo', {
        duration: 1,
        y: '100%',
        opacity: 0,
        delay: 1
    });
    gsap.from('.study-process', {
        y: '160',
        stagger: 0.1,
        duration: 0.8,
        ease: 'back'
    });
    gsap.to(".geographie", {
        scrollTrigger: {
            scrub: 1
        },
        scale: 1.5
    });
    AOS.init({
        delay: 10,
        duration: 1500
    });
}