const $ = require('jquery');
const { animateSearch, hideSearch } = require('./utils/search/animation-search');
const { Menu } = require('./utils/menu');

$(document).ready(() => {
  $('[data-animation-loaded]').addClass('loaded');
  document.querySelector('.header--search-button').addEventListener('click', (e) => {
    animateSearch(e);
  });
  document.querySelector('#close').addEventListener('click', (e) => {
    hideSearch(e);
  });
  Menu.init();
});
