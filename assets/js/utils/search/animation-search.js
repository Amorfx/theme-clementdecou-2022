import anime from 'animejs/lib/anime.es.js';

export function animateSearch(event) {
  const searchContainer = document.querySelector('.search-outer');
  searchContainer.style.opacity = 1;
  searchContainer.style.display = 'block';

  const tl = anime.timeline({
    duration: 700,
    easing: 'cubicBezier(.2, 1, .3, 1)'
  });

  // Add children
  tl
    .add({
      targets: '.search-outer',
      scaleY: [0, 1],
      duration: 400,
      easing: 'easeInOutQuad'
    })
    .add({
      targets: '.search-outer input[type=text]',
      translateY: [-30, 0],
      opacity: 1
    })
    .add({
      targets: '.search-outer form span',
      translateY: [30, 0],
      opacity: 1
    }, 400)
    .add({
      targets: '#close',
      opacity: 1
    }, 400)
};

export function hideSearch(event) {
  anime({
    targets: '.search-outer',
    opacity: [1, 0],
    ease: 'linear',
    duration: 700,
    complete: function(anim) {
      document.querySelector('.search-outer').style = '';
      document.querySelector('.search-outer input[type=text]').style = '';
      document.querySelector('.search-outer form span').style = '';
      document.querySelector('#close').style = '';
    }
  })
}
