const { animeOnEnter } = require('./animation');
module.exports.animBlogCard = (blogCards) => {
  const callback = (element) => {
    element.querySelector('.inner-wrap').classList.add('animated');
  };
  for (var i = 0; i < blogCards.length; i++) {
    animeOnEnter(blogCards[i], callback, true);
  }
};

module.exports.animServices = (services) => {
  const callback = (element) => {
    element.classList.add('animate');
  };
  for (var i = 0; i < services.length; i++) {
    animeOnEnter(services[i], callback, true);
  }
};
