const elem = document.querySelector('.isotope-grid');
let iso = new Isotope(elem, {
    // options
    layoutMode: 'packery',
    packery: {
        gutter: 10
    },
    masonry: {
        gutter: 10
    },
    fitRows: {
        gutter: 10
    },
    itemSelector: '.isotope-item',
    originLeft: false,
});