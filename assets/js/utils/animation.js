module.exports.animeOnEnter = (target, callback, doOneTime) => {
  const mapAnimated = [];
  const observer = new IntersectionObserver(entries => {
    const [{ isIntersecting, target }] = entries;
    if (doOneTime) {
      if (isIntersecting && !mapAnimated.includes(target)) {
        callback(target);
        mapAnimated.push(target);
      }
    } else {
      callback(target);
    }
  })

  observer.observe(target)
}
