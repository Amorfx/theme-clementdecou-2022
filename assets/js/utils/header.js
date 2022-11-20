const $ = require('jquery');
const $document = $(document);

module.exports.animDarkHeader = () => {
  // Have menu dark or white with scroll
  if ($document.scrollTop() >= 16) {
    $('header').first().removeClass('dark');
  }
  $document.scroll((e) => {
    const scrollTop = $document.scrollTop();
    if (scrollTop <= 16) {
      $('header').first().addClass('dark');
    } else {
      $('header').first().removeClass('dark');
    }
  });
};

