let current = Promise.resolve();

document.querySelector('#email').addEventListener('focus', function(e) {
  current = current.then(() => {
    return anime({
      targets: 'path',
      strokeDashoffset: {
        value: 0,
        duration: 700,
        easing: 'easeOutQuart'
      },
      strokeDasharray: {
        value: '240 1386',
        duration: 700,
        easing: 'easeOutQuart'
      }
    }).finished;
  });
});

document.querySelector('#password').addEventListener('focus', function(e) {
  current = current.then(() => {
    return anime({
      targets: 'path',
      strokeDashoffset: {
        value: -336,
        duration: 700,
        easing: 'easeOutQuart'
      },
      strokeDasharray: {
        value: '240 1386',
        duration: 700,
        easing: 'easeOutQuart'
      }
    }).finished;
  });
});

document.querySelector('#submit').addEventListener('focus', function(e) {
  current = current.then(() => {
    return anime({
      targets: 'path',
      strokeDashoffset: {
        value: -730,
        duration: 700,
        easing: 'easeOutQuart'
      },
      strokeDasharray: {
        value: '530 1386',
        duration: 700,
        easing: 'easeOutQuart'
      }
    }).finished;
  });
});
