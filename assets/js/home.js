const Isotope = require('isotope-layout');
const $ = require('jquery');
const { animServices } = require('./utils/card-apparition');


$(document).ready(function(){
  const grid = document.querySelector('.projects');
  var iso = new Isotope(grid, {
    itemSelector: '.project',
    masonry: {
      columnWidth: '.grid-sizer'
    }
  });

  // Filter for isotope
  $('.projects--filters span[data-filter]').on('click', function(event) {
    event.preventDefault();
    const $filterClicked = $(this);
    const filterValue = $filterClicked.data('filter');
    $('.projects--filters li span').removeClass('active');
    $filterClicked.addClass('active');
    iso.arrange({ filter: filterValue });
  });

  $('.presentation-container, .triangle-container').addClass('animate');
  animServices(document.querySelectorAll('.service, .home-services h2'));
});

