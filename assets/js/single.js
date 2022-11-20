const $ = require('jquery');
const { animDarkHeader } = require('./utils/header');
$(document).ready(() => {
  if ($('.contact').length === 0) {
    animDarkHeader();
  }
});

// Share popup
const allShareLink = document.querySelectorAll('.social-share a');
allShareLink.forEach((link) => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const share = e.currentTarget;
    console.log(share.getAttribute('href'));
    const shareWidth = 570;
    const shareHeight = 300;

    // Open new popup:
    const left = (window.screen.width / 2) - (shareWidth / 2);
    const top = (window.screen.height / 2) - (shareHeight / 2);
    window.open(share.getAttribute('href'), '', 'width=' + shareWidth + ', height=' + shareHeight + ', top=' + top + ', left=' + left);
  });
})
