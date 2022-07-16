// Default theme
// import '@splidejs/splide/css';

// or other themes
import Splide from '@splidejs/splide';

import '@splidejs/splide/css/skyblue';

var splide = new Splide( '.splide', {
    rewind : true,
    rewindByDrag: true,
    autoWidth: true,
    gap: 20,
    lazyLoad: true,
    autoplay: true,
    interval: 3000,
    rewindSpeed: 1000,
    speed: 900,
    arrows: false,
    pagination: false,
} );

splide.mount();
