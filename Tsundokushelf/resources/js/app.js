import './bootstrap';

import Alpine from 'alpinejs';

import './isbn-fetcher';

import Splide from '@splidejs/splide';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {

const carouselEl = document.getElementById('book-carousel');
    if (carouselEl) {
        new Splide(carouselEl, {
            type   : 'loop',
            perPage: 3,
            focus  : 'center',
            arrows: false,
            autoplay: true,
            breakpoints: {
                640: { perPage: 1 },
                768: { perPage: 2 },
            }
        }).mount();
    }

    const form = document.getElementById('filterForm');
    if (form) {
        const checkboxes = form.querySelectorAll('input[type="checkbox"][name="status[]"]');
        const keywordInput = form.querySelector('input[name="keyword"]');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => form.submit());
        });

        keywordInput?.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                form.submit();
            }
        });
    }

});
