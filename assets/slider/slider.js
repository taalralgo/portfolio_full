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
    interval: 5000,
    rewindSpeed: 2000,
    speed: 5000
} );

splide.mount();
