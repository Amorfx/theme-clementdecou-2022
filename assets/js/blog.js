const $ = require('jquery');
const InfiniteScroll = require('infinite-scroll');
const $document = $(document);
const { animBlogCard } = require('./utils/card-apparition');
const { animDarkHeader } = require('./utils/header');

$document.ready(function(){
  animDarkHeader();
  // Infinite scroll
  let infScrollBlog = new InfiniteScroll('.post-list-container .list', {
    path: '.infinite-scroll-next a',
    append: '.blog-card',
    outlayer: false,
    hideNav: '.pagination',
    history: false,
    status: '.infinite-page-status'
  });
  infScrollBlog.on('append', (body, path, items, response ) => {
    animBlogCard(items);
  });

  $('.pagination').hide();

  animBlogCard(document.querySelectorAll('.blog-card'));
});
